<?php
	/**
	 * This Controller is used if the user wants to get the recent posts. The posts will be retrieved by a model and
	 * then put into the Response object. If no posts exist, the request will be dispatched to a NotFoundController
	 * object.
	 */
	class RecentPostsController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$mapping = $request->getAttribute('mapping');
			$settings = $request->getAttribute('settings');

			try
			{
				$page = $this->page($request);

				$mapper = $mapping->selectPublishedNonstaticPosts();
				$mapper->setOffset(($page - 1) * $this->limit($request));
				$mapper->setLimit($this->limit($request));
				$mapper->setAscending(false);
				$mapper->setSelectAuthor(true);
				$mapper->setSelectCategories(true);
				$mapper->addModifier(new ShowPostPathModifier($settings, 'path'));
				$mapper->addCategoryModifier(new CategoryArchivePathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editPost'))
					$mapper->addModifier(new EditPostPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deletePost'))
					$mapper->addModifier(new DeletePostPathModifier($settings, 'deletePath'));

				$posts = $mapper->map();

				if ($posts->size() == 0)
					throw new NotFoundException();

				$response->put('posts', $posts);
				$response->put('page', $page);

				$this->pagination($request, $response);
				$this->widgets($request, $response);
				$this->layout($request, $response);
			}
			catch (NotFoundException $e)
			{
				$notFoundController = $this->getRequestDispatcher('notFound');
				$notFoundController->dispatch($request, $response);
			}
		}

		/**
		 * @param Request $request
		 * @return int
		 * @throws NotFoundException
		 */
		protected function page(Request $request)
		{
			if ($request->containsGetParameter('page'))
			{
				if (!NaturalNumberValidator::create(false)->isValid($request->getGetParameter('page')) ||
				    (int) $request->getGetParameter('page') < 2)
					throw new NotFoundException();

				return (int) $request->getGetParameter('page');
			}

			return 1;
		}

		/**
		 * @param Request $request
		 * @return int
		 */
		protected function limit(Request $request)
		{
			return (int) $request->getAttribute('settings')->get('controllers.recentPosts.postsPerPage');
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 */
		protected function pagination(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');
			$mapper = $request->getAttribute('mapping')->selectNumberOfPublishedNonstaticPosts();

			$pagination = new Pagination($mapper->map(),
			                             (int) $settings->get('controllers.recentPosts.postsPerPage'),
			                             new Map());
			$pagination->addModifier(new RecentPostsPathModifier($settings, 'path'));

			$response->put('pagination', $pagination->build());
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

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.recentPosts.templateDestination'));
			$response->flush($settings->get('controllers.recentPosts.templateDestination') . 'recentPosts.php');
		}
	}
