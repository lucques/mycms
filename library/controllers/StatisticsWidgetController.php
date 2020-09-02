<?php
	/**
	 * This Controller is called by other controllers which want to offer a widget which summarizes some statistics.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * widget will not be added.
	 */
	class StatisticsWidgetController extends Controller
	{	
		public function action(Request $request, Response $response)
		{
			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.statisticsWidget'))
			{
				$mapping = $request->getAttribute('mapping');

				$statistics = new Map();
				$statistics->put('posts', $mapping->selectNumberOfPosts()->map());
				$statistics->put('categories', $mapping->selectNumberOfCategories()->map());
				$statistics->put('comments', $mapping->selectNumberOfComments()->map());

				$response->put('statisticsWidget', $statistics);
			}
		}
	}
