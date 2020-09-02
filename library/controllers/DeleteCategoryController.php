<?php
	/**
	 * This Controller is called if the user wants to delete a category.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class DeleteCategoryController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				if (!$request->containsGetParameter('id') ||
				    !PatternValidator::create($settings->get('datatypes.category.id.pattern'))->isValid($request->getGetParameter('id')))
					throw new NotFoundException();

				$mapper = $mapping->selectCategoryById($request->getGetParameter('id'));
				$mapper->setSelectNumberOfPosts(true);
				$mapper->addModifier(new CategoryArchivePathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editCategory'))
					$mapper->addModifier(new EditCategoryPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteCategory'))
					$mapper->addModifier(new DeleteCategoryPathModifier($settings, 'deletePath'));

				$categories = $mapper->map();

				if ($categories->size() != 1)
					throw new NotFoundException();

				$category = $categories->get(0);

				if ($request->containsPostParameter('delete'))
				{
					$mapping->deleteCategory($category->get('id'))->map();

					$response->sendRedirect($settings->get('root'));
				}
				else
				{
					//remove the category archive path if category is not used yet
					if ($category->get('numberOfPosts') == 0)
					$category->remove('path');

					$response->put('category', $category);

					$this->widgets($request, $response);
					$this->layout($request, $response);
				}
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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteCategory'))
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

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.deleteCategory.templateDestination'));
			$response->flush($settings->get('controllers.deleteCategory.templateDestination') . 'deleteCategory.php');
		}
	}
