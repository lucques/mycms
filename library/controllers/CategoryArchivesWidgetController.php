<?php
	/**
	 * This Controller is called by other controllers which want to offer a widget which lets you navigate through the
	 * category archives.
	 */
	class CategoryArchivesWidgetController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$mapper = $request->getAttribute('mapping')->selectUsedCategoriesOfPublishedPosts();
			$mapper->setSelectNumberOfPosts(true);
			$mapper->addModifier(new CategoryArchivePathModifier($request->getAttribute('settings'), 'path'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editCategory'))
				$mapper->addModifier(new EditCategoryPathModifier($settings, 'editPath'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteCategory'))
				$mapper->addModifier(new DeleteCategoryPathModifier($settings, 'deletePath'));

			$archives = $mapper->map();

			if ($archives->size() > 0)
				$response->put('categoryArchivesWidget', $archives);
		}
	}
