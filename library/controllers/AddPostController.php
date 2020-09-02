<?php
	/**
	 * This Controller is called if the user wants to add a new post. He can also set the timestamp and add
	 * categories.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class AddPostController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				$categoryMapper = $mapping->selectCategories();

				$categories = $categoryMapper->map();

				$invalidId = false;
				$idTaken = false;
				$invalidTitle = false;
				$invalidContent = false;
				$invalidTimestamp = false;
				$failed = false;
				$written = false;

				if ($request->containsPostParameter('id') &&
				    $request->containsPostParameter('title') &&
				    $request->containsPostParameter('content') &&
				    $request->containsPostParameter('timestamp_year') &&
				    $request->containsPostParameter('timestamp_month') &&
				    $request->containsPostParameter('timestamp_day') &&
				    $request->containsPostParameter('timestamp_hour') &&
				    $request->containsPostParameter('timestamp_minute') &&
				    $request->containsPostParameter('timestamp_second'))
				{
					$post = new Map();
					$post->put('id', $request->getPostParameter('id'));
					$post->put('title', $request->getPostParameter('title'));
					$post->put('content', $request->getPostParameter('content'));
					$post->put('showComments', $request->containsPostParameter('show_comments'));
					$post->put('allowComments', $request->containsPostParameter('allow_comments'));
					$post->put('showLink', $request->containsPostParameter('show_link'));
					$post->put('showTimestamp', $request->containsPostParameter('show_timestamp'));
					$post->put('showAuthor', $request->containsPostParameter('show_author'));
					$post->put('isStatic', $request->containsPostParameter('isStatic'));

					$invalidId = !PatternValidator::create($settings->get('datatypes.post.id.pattern'))->isValid($post->get('id'));

					if (!$invalidId)
						$idTaken = $mapping->selectPostById($request->getPostParameter('id'))->map()->size() == 1;

					$invalidTitle = !PatternValidator::create($settings->get('datatypes.post.title.pattern'))->isValid($post->get('title'));
					$invalidContent = !PatternValidator::create($settings->get('datatypes.post.content.pattern'))->isValid($post->get('content'));

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
							$post->put('timestamp', $timestamp);
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

						$post->put('timestamp', $timestamp);
					}

					$selectedCategories = new MyList();

					$categoryIterator = $categories->iterator();

					while ($categoryIterator->hasNext())
					{
						$category = $categoryIterator->next();

						if ($request->containsPostParameter('category_' . $category->get('id')))
							$selectedCategories->add($category->get('id'));
					}

					$post->put('categories', $selectedCategories);

					if (!$invalidId &&
					    !$idTaken &&
					    !$invalidTitle &&
					    !$invalidContent &&
					    !$invalidTimestamp)
					{
						//replace the author with the author id
						$post->put('author', $request->getAttribute('user')->get('id'));

						$mapping->insertPost($post)->map();

						$written = true;
					}
					else
					{
						$response->put('post', $post);

						$failed = true;
					}
				}

				$response->put('invalidId', $invalidId);
				$response->put('idTaken', $idTaken);
				$response->put('invalidTitle', $invalidTitle);
				$response->put('invalidContent', $invalidContent);
				$response->put('invalidTimestamp', $invalidTimestamp);
				$response->put('failed', $failed);
				$response->put('written', $written);
				$response->put('categories', $categories);
				$response->put('author', $request->getAttribute('user'));

				$this->widgets($request, $response);
				$this->layout($request, $response);
			}
			catch (UnauthorizedException $e)
			{
				$this->getRequestDispatcher('unauthorized')->dispatch($request, $response);
			}
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 * @throws UnauthorizedException
		 */
		protected function authorize(Request $request, Response $response)
		{
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.addPost'))
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

			$response->put('idPattern', $settings->get('datatypes.post.id.pattern'));
			$response->put('titlePattern', $settings->get('datatypes.post.title.pattern'));
			$response->put('contentPattern', $settings->get('datatypes.post.content.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.addPost.templateDestination'));
			$response->flush($settings->get('controllers.addPost.templateDestination') . 'addPost.php');
		}
	}
