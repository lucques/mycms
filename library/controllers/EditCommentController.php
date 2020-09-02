<?php
	/**
	 * This Controller is called if the user wants to edit a comment.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class EditCommentController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				if (!$request->containsGetParameter('id') ||
				    !NaturalNumberValidator::create(false)->isValid($request->getGetParameter('id')) ||
				    (int) $request->getGetParameter('id') == 0)
					throw new NotFoundException();

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				$mapper = $mapping->selectCommentById((int) $request->getGetParameter('id'));
				$mapper->addModifier(new ShowCommentPathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editComment'))
					$mapper->addModifier(new EditCommentPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteComment'))
					$mapper->addModifier(new DeleteCommentPathModifier($settings, 'deletePath'));

				$comments = $mapper->map();

				if ($comments->size() != 1)
					throw new NotFoundException();

				$comment = $comments->get(0);

				$invalidNick = false;
				$invalidEmail = false;
				$invalidWebsite = false;
				$invalidContent = false;
				$invalidTimestamp = false;
				$failed = false;
				$edited = false;

				if ($request->containsPostParameter('nick') &&
				    $request->containsPostParameter('email') &&
				    $request->containsPostParameter('website') &&
				    $request->containsPostParameter('content') &&
				    $request->containsPostParameter('timestamp_year') &&
				    $request->containsPostParameter('timestamp_month') &&
				    $request->containsPostParameter('timestamp_day') &&
				    $request->containsPostParameter('timestamp_hour') &&
				    $request->containsPostParameter('timestamp_minute') &&
				    $request->containsPostParameter('timestamp_second'))
				{
					$comment->put('nick', $request->getPostParameter('nick'));
					$comment->put('email', $request->getPostParameter('email'));
					$comment->put('website', $request->getPostParameter('website'));
					$comment->put('content', $request->getPostParameter('content'));

					$invalidNick = $comment->get('nick') == '' &&
					                  (boolean) $settings->get('datatypes.comment.nick.required') ||
					               $comment->get('nick') != '' &&
					                  !PatternValidator::create($settings->get('datatypes.comment.nick.pattern'))->isValid($comment->get('nick'));

					$invalidEmail = $comment->get('email') == '' &&
					                   (boolean) $settings->get('datatypes.comment.email.required') ||
					                $comment->get('email') != '' &&
					                   !PatternValidator::create($settings->get('dataypes.comment.email.pattern'))->isValid($comment->get('email'));

					$invalidWebsite = $comment->get('website') == '' &&
					                     (boolean) $settings->get('datatypes.comment.website.required') ||
					                  $comment->get('website') != '' &&
					                     !PatternValidator::create($settings->get('datatypes.comment.website.pattern'))->isValid($comment->get('website'));

					$invalidContent = !PatternValidator::create($settings->get('datatypes.comment.content.pattern'))->isValid($comment->get('content'));

					$invalidTimestamp = !NaturalNumberValidator::create(false)->isValid($request->getPostParameter('timestamp_year')) ||
							    !NaturalNumberValidator::create(true)->isValid($request->getPostParameter('timestamp_month')) ||
							    !NaturalNumberValidator::create(true)->isValid($request->getPostParameter('timestamp_day')) ||
							    !NaturalNumberValidator::create(true)->isValid($request->getPostParameter('timestamp_hour')) ||
							    !NaturalNumberValidator::create(true)->isValid($request->getPostParameter('timestamp_minute')) ||
							    !NaturalNumberValidator::create(true)->isValid($request->getPostParameter('timestamp_second')) ||
					                    strlen($request->getPostParameter('timestamp_year')) != 4 ||
					                    strlen($request->getPostParameter('timestamp_month')) != 2 ||
					                    strlen($request->getPostParameter('timestamp_day')) != 2 ||
					                    strlen($request->getPostParameter('timestamp_hour')) != 2 ||
					                    strlen($request->getPostParameter('timestamp_minute')) != 2 ||
					                    strlen($request->getPostParameter('timestamp_second')) != 2;

					if (!$invalidTimestamp)
					{
						$timestamp = new Map();
						$timestamp->put('year', (int) $request->getPostParameter('timestamp_year'));
						$timestamp->put('month', (int) $request->getPostParameter('timestamp_month'));
						$timestamp->put('day', (int) $request->getPostParameter('timestamp_day'));
						$timestamp->put('hour', (int) $request->getPostParameter('timestamp_hour'));
						$timestamp->put('minute', (int) $request->getPostParameter('timestamp_minute'));
						$timestamp->put('second', (int) $request->getPostParameter('timestamp_second'));

						$invalidTimestamp = !TimestampValidator::isValid($timestamp);

						if (!$invalidTimestamp)
							$comment->put('timestamp', $timestamp);
					}

					if ($invalidTimestamp)
					{
						$timestamp = new Map();
						$timestamp->put('year', $request->getPostParameter('timestamp_year'));
						$timestamp->put('month', $request->getPostParameter('timestamp_month'));
						$timestamp->put('day', $request->getPostParameter('timestamp_day'));
						$timestamp->put('hour', $request->getPostParameter('timestamp_hour'));
						$timestamp->put('minute', $request->getPostParameter('timestamp_minute'));
						$timestamp->put('second', $request->getPostParameter('timestamp_second'));

						$comment->put('timestamp', $timestamp);
					}

					if (!$invalidNick &&
					    !$invalidEmail &&
					    !$invalidWebsite &&
					    !$invalidContent &&
					    !$invalidTimestamp)
					{
						$mapping->updateComment($comment)->map();

						$edited = true;
					}
					else
						$failed = true;
				}

				$response->put('comment', $comment);
				$response->put('invalidNick', $invalidNick);
				$response->put('invalidEmail', $invalidEmail);
				$response->put('invalidWebsite', $invalidWebsite);
				$response->put('invalidContent', $invalidContent);
				$response->put('invalidTimestamp', $invalidTimestamp);
				$response->put('failed', $failed);
				$response->put('edited', $edited);

				$this->widgets($request, $response);
				$this->layout($request, $response);
			}
			catch (UnauthorizedException $e)
			{
				$this->getRequestDispatcher('unauthorized')->dispatch($request, $response);
			}
			catch (NotFoundException $e)
			{
				$this->getRequestDispatcher('notFound')->dispatch($request, $response);
			}
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 * @throws UnauthorizedException
		 */
		protected function authorize(Request $request, Response $response)
		{
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editComment'))
				throw new UnauthorizedException();
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 */
		protected function widgets(Request $request, Response $response)
		{
			$this->getRequestDispatcher('categoryArchivesWidget')->dispatch($request, $response);
			$this->getRequestDispatcher('yearMonthArchivesWidget')->dispatch($request, $response);
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 */
		protected function layout(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$this->getRequestDispatcher('page')->dispatch($request, $response);

			$response->put('nickPattern', $settings->get('datatypes.comment.nick.pattern'));
			$response->put('contentPattern', $settings->get('datatypes.comment.content.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.editComment.templateDestination'));
			$response->flush($settings->get('controllers.editComment.templateDestination') . 'editComment.php');
		}
	}
