<?php
	/**
	 * This Controller is called by other controllers which want to offer a widget which lets you navigate through the
	 * year-month archives.
	 */
	class YearMonthArchivesWidgetController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$mapper = $request->getAttribute('mapping')->selectTimestampsOfPublishedNonstaticPosts();
			$mapper->setSelectYear(true);
			$mapper->setSelectMonth(true);
			$mapper->setSelectNumberOfPosts(true);
			$mapper->addModifier(new YearMonthArchivePathModifier($request->getAttribute('settings'), 'path'));

			$archives = $mapper->map();

			if ($archives->size() > 0)
				$response->put('yearMonthArchivesWidget', $archives);
		}
	}
