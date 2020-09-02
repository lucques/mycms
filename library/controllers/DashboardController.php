<?php
	/**
	 * This Controller is called if the user wants to get a summary of the recent activities.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class DashboardController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);
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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.dashboard'))
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

			$this->getRequestDispatcher('statisticsWidget')->dispatch($request, $response);
			$this->getRequestDispatcher('unpublishedPostsWidget')->dispatch($request, $response);
			$this->getRequestDispatcher('staticPostsWidget')->dispatch($request, $response);
			$this->getRequestDispatcher('unusedCategoriesWidget')->dispatch($request, $response);
			$this->getRequestDispatcher('recentCommentsWidget')->dispatch($request, $response);
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 */
		protected function layout(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$this->getRequestDispatcher('page')->dispatch($request, $response);

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.dashboard.templateDestination'));
			$response->flush($settings->get('controllers.dashboard.templateDestination') . 'dashboard.php');
		}
	}
