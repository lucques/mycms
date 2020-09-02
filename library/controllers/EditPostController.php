<?php
	/**
	 * This Controller is called if the user wants to edit a post.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class EditPostController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				if (!$request->containsGetParameter('id') ||
				    !PatternValidator::create($settings->get('datatypes.post.id.pattern'))->isValid($request->getGetParameter('id')))
					throw new NotFoundException();

				$mapper = $mapping->selectPostById($request->getGetParameter('id'));
				$mapper->setSelectAuthor(true);
				$mapper->setSelectCategories(true);
				$mapper->addModifier(new ShowPostPathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editPost'))
					$mapper->addModifier(new EditPostPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deletePost'))
					$mapper->addModifier(new DeletePostPathModifier($settings, 'deletePath'));

				$posts = $mapper->map();

				if ($posts->size() != 1)
					throw new NotFoundException();

				$post = $posts->get(0);

				//replace the categories with a list of the ids of the categories
				$selectedCategories = new MyList();

				$categoryIterator = $post->get('categories')->iterator();

				while ($categoryIterator->hasNext())
					$selectedCategories->add($categoryIterator->next()->get('id'));

				$post->put('categories', $selectedCategories);

				$categoryMapper = $mapping->selectCategories();

				$categories = $categoryMapper->map();

				$invalidTitle = false;
				$invalidContent = false;
				$invalidTimestamp = false;
				$failed = false;
				$edited = false;

				if ($request->containsPostParameter('title') &&
				    $request->containsPostParameter('content') &&
				    $request->containsPostParameter('timestamp_year') &&
				    $request->containsPostParameter('timestamp_month') &&
				    $request->containsPostParameter('timestamp_day') &&
				    $request->containsPostParameter('timestamp_hour') &&
				    $request->containsPostParameter('timestamp_minute') &&
				    $request->containsPostParameter('timestamp_second'))
				{
					$post->put('title', $request->getPostParameter('title'));
					$post->put('content', $request->getPostParameter('content'));
					$post->put('showComments', $request->containsPostParameter('show_comments'));
					$post->put('allowComments', $request->containsPostParameter('allow_comments'));
					$post->put('showLink', $request->containsPostParameter('show_link'));
					$post->put('showTimestamp', $request->containsPostParameter('show_timestamp'));
					$post->put('showAuthor', $request->containsPostParameter('show_author'));
					$post->put('isStatic', $request->containsPostParameter('is_static'));

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

					if (!$invalidTitle &&
					    !$invalidContent &&
					    !$invalidTimestamp)
					{
						//replace the author with the author id
						$post->put('author', $post->get('author')->get('id'));

						$mapping->updatePost($post)->map();

						$edited = true;
					}
					else
						$failed = true;
				}

				//remove the show post path if post is not published yet
				if (Timestamp::toUnixTimestamp($post->timestamp) > time())
					$post->remove('path');

				$response->put('post', $post);
				$response->put('invalidTitle', $invalidTitle);
				$response->put('invalidContent', $invalidContent);
				$response->put('invalidTimestamp', $invalidTimestamp);
				$response->put('failed', $failed);
				$response->put('edited', $edited);
				$response->put('categories', $categories);

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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editPost'))
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

			$response->put('titlePattern', $settings->get('datatypes.post.title.pattern'));
			$response->put('contentPattern', $settings->get('datatypes.post.content.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.editPost.templateDestination'));
			$response->flush($settings->get('controllers.editPost.templateDestination') . 'editPost.php');
		}
	}
