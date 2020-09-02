<?php
	/**
	 * This Controller is used if the user wants to get a post. The post will be retrieved by a model and then put into
	 * the Response object. If the requested post does not exist, the request will be dispatched to a NotFoundController
	 * object.
	 */
	class ShowPostController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$mapping = $request->getAttribute('mapping');
			$settings = $request->getAttribute('settings');

			try
			{
				$mapper = $mapping->selectPublishedPostById($this->getPostId($request));
				$mapper->setSelectAuthor(true);
				$mapper->setSelectCategories(true);
				$mapper->addModifier(new ShowPostPathModifier($settings, 'path'));
				$mapper->addCategoryModifier(new CategoryArchivePathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editPost'))
					$mapper->addModifier(new EditPostPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deletePost'))
					$mapper->addModifier(new DeletePostPathModifier($settings, 'deletePath'));

				$posts = $mapper->map();

				if ($posts->size() != 1)
					throw new NotFoundException();

				$post = $posts->get(0);

				$invalidNick = false;
				$invalidEmail = false;
				$invalidWebsite = false;
				$invalidContent = false;
				$invalidCaptcha = false;
				$commentFailed = false;
				$commentWritten = false;

				if ($post->get('allowComments'))
				{
					$captchaModel = new CaptchaModel();

					if ($request->containsPostParameter('nick') &&
					    $request->containsPostParameter('email') &&
					    $request->containsPostParameter('website') &&
					    $request->containsPostParameter('content') &&
					    (($request->containsPostParameter('captcha_input') &&
					      $request->containsPostParameter('captcha_answer')) ||
					     !(boolean) $settings->get('controllers.showPost.captcha.enabled')))
					{
						$comment = new Map();
						$comment->put('nick', $request->getPostParameter('nick'));
						$comment->put('email', $request->getPostParameter('email'));
						$comment->put('website', $request->getPostParameter('website'));
						$comment->put('content', $request->getPostParameter('content'));
						$comment->put('timestamp', Timestamp::fromUnixTimestamp(time()));

						$invalidNick = $comment->get('nick') == '' &&
						                  (boolean) $settings->get('datatypes.comment.nick.required') ||
						               $comment->get('nick') != '' &&
						                  !PatternValidator::create($settings->get('datatypes.comment.nick.pattern'))->isValid($comment->get('nick'));

						$invalidEmail = $comment->get('email') == '' &&
						                   (boolean) $settings->get('datatypes.comment.email.required') ||
						                $comment->get('email') != '' &&
						                   !PatternValidator::create($settings->get('datatypes.comment.email.pattern'))->isValid($comment->get('email'));

						$invalidWebsite = $comment->get('website') == '' &&
						                     (boolean) $settings->get('datatypes.comment.website.required') ||
						                  $comment->get('website') != '' &&
						                     !PatternValidator::create($settings->get('datatypes.comment.website.pattern'))->isValid($comment->get('website'));

						$invalidContent = !PatternValidator::create($settings->get('datatypes.comment.content.pattern'))->isValid($comment->get('content'));

						$invalidCaptcha = (boolean) $settings->get('controllers.showPost.captcha.enabled') &&
							          !$captchaModel->isValid($request->getPostParameter('captcha_answer'),
							                                  $request->getPostParameter('captcha_input'));

						if (!$invalidNick &&
						    !$invalidEmail &&
						    !$invalidWebsite &&
						    !$invalidContent &&
						    !$invalidCaptcha)
						{
							$mapping->insertComment($comment, $post->get('id'))->map();

							$commentWritten = true;
						}
						else
						{
							$response->put('commentForm', $comment);

							$commentFailed = true;
						}
					}

					if ((boolean) $settings->get('controllers.showPost.captcha.enabled'))
						$response->put('captcha', $captchaModel->create());
				}

				if ($post->get('showComments'))
				{
					$commentsMapper = $mapping->selectCommentsByPostId($post->get('id'));

					if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editComment'))
						$commentsMapper->addModifier(new EditCommentPathModifier($settings, 'editPath'));

					if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteComment'))
						$commentsMapper->addModifier(new DeleteCommentPathModifier($settings, 'deletePath'));

					$post->put('comments', $commentsMapper->map());
				}

				$response->put('invalidNick', $invalidNick);
				$response->put('invalidEmail', $invalidEmail);
				$response->put('invalidWebsite', $invalidWebsite);
				$response->put('invalidContent', $invalidContent);
				$response->put('invalidCaptcha', $invalidCaptcha);
				$response->put('commentFailed', $commentFailed);
				$response->put('commentWritten', $commentWritten);
				$response->put('post', $post);

				$this->widgets($request, $response);
				$this->layout($request, $response);
			}
			catch (NotFoundException $e)
			{
				$this->getRequestDispatcher('notFound')->dispatch($request, $response);
			}
		}

		/**
		 * @param Request $request
		 * @throws NotFoundException
		 */
		protected function getPostId(Request $request)
		{
			$settings = $request->getAttribute('settings');

			if (!$request->containsGetParameter('id') ||
			    !PatternValidator::create($settings->get('datatypes.post.id.pattern'))->isValid($request->getGetParameter('id')))
				throw new NotFoundException();

			return $request->getGetParameter('id');
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

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.showPost.templateDestination'));
			$response->flush($settings->get('controllers.showPost.templateDestination') . 'showPost.php');
		}
	}
