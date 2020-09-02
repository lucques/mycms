<?php
	/**
	 * This Controller is used if the user wants to get the recent posts as a news feed. This class inherits all methods
	 * of RecentPostsController which means it behaves just the same except that some functionality like the pagination
	 * is removed and the layout of course changes.
	 */
	class RecentPostsFeedController extends RecentPostsController
	{
		protected function offset(Request $request)
		{
			return 0;
		}

		protected function limit(Request $request)
		{
			return (int) $request->getAttribute('settings')->get('controllers.recentPostsFeed.postsPerPage');
		}

		protected function pagination(Request $request, Response $response)
		{
			
		}

		protected function widgets(Request $request, Response $response)
		{

		}

		protected function layout(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$this->getRequestDispatcher('page')->dispatch($request, $response);

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.recentPostsFeed.templateDestination'));
			$response->flush($settings->get('controllers.recentPostsFeed.templateDestination') . 'recentPostsFeed.php');
		}
	}
