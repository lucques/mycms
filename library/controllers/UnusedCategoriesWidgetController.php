<?php
	/**
	 * This Controller is called by other controllers which want to offer a widget that shows all unused categories.
	 */
	class UnusedCategoriesWidgetController extends Controller
	{	
		public function action(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$mapper = $request->getAttribute('mapping')->selectUnusedCategories();

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editCategory'))
				$mapper->addModifier(new EditCategoryPathModifier($settings, 'editPath'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteCategory'))
				$mapper->addModifier(new DeleteCategoryPathModifier($settings, 'deletePath'));

			$categories = $mapper->map();

			if ($categories->size() > 0)
				$response->put('unusedCategoriesWidget', $categories);
		}
	}
