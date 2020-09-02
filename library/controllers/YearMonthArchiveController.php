<?php
	/**
	 * This Controller is used if the user wants to get posts from a given year and month. The posts will be retrieved
	 * by a model and then put into the Response object. If no posts exist, the request will be dispatched to a
	 * NotFoundController object.
	 */
	class YearMonthArchiveController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				if (!$request->containsGetParameter('year') ||
				    !$request->containsGetParameter('month') ||
				    !NaturalNumberValidator::create(false)->isValid($request->getGetParameter('year')) ||
				    !NaturalNumberValidator::create(true)->isValid($request->getGetParameter('month')) ||
				    strlen($request->getGetParameter('year')) != 4 ||
				    strlen($request->getGetParameter('month')) != 2)
					throw new NotFoundException();

				$timestamp = new Map();
				$timestamp->put('year', (int) $request->getGetParameter('year'));
				$timestamp->put('month', (int) $request->getGetParameter('month'));

				if (!TimestampValidator::isValid($timestamp))
					throw new NotFoundException();

				$settings = $request->getAttribute('settings');

				$page = $this->page($request);

				$mapper = $request->getAttribute('mapping')->selectPublishedNonstaticPostsByTimestamp($timestamp);
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

				$response->put('timestamp', $timestamp);
				$response->put('posts', $posts);
				$response->put('page', $page);

				$this->pagination($request, $response, $timestamp);
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
			return (int) $request->getAttribute('settings')->get('controllers.yearMonthArchive.postsPerPage');
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 * @param Map $timestamp
		 */
		protected function pagination(Request $request, Response $response, Map $timestamp)
		{
			$settings = $request->getAttribute('settings');

			$mapper = $request->getAttribute('mapping')->selectNumberOfPublishedNonstaticPostsByTimestamp($timestamp);

			$pagination = new Pagination($mapper->map(),
			                             (int) $settings->get('controllers.yearMonthArchive.postsPerPage'),
			                             $timestamp);
			$pagination->addModifier(new YearMonthArchivePathModifier($settings, 'path'));

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

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.yearMonthArchive.templateDestination'));
			$response->flush($settings->get('controllers.yearMonthArchive.templateDestination') . 'yearMonthArchive.php');
		}
	}
