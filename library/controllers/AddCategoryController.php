<?php
	/**
	 * This Controller is called if the user wants to add a new category.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class AddCategoryController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				$invalidId = false;
				$idTaken = false;
				$invalidTitle = false;
				$failed = false;
				$written = false;

				if ($request->containsPostParameter('id') &&
				    $request->containsPostParameter('title'))
				{
					$category = new Map();
					$category->put('id', $request->getPostParameter('id'));
					$category->put('title', $request->getPostParameter('title'));

					$invalidId = !PatternValidator::create($settings->get('datatypes.category.id.pattern'))->isValid($category->get('id'));

					if (!$invalidId)
						$idTaken = $mapping->selectCategoryById($request->getPostParameter('id'))->map()->size() == 1;

					$invalidTitle = !PatternValidator::create($settings->get('datatypes.category.title.pattern'))->isValid($category->get('title'));

					if (!$invalidId &&
					    !$idTaken &&
					    !$invalidTitle)
					{
						$mapping->insertCategory($category)->map();

						$written = true;
					}
					else
					{
						$response->put('category', $category);

						$failed = true;
					}
				}

				$response->put('invalidId', $invalidId);
				$response->put('idTaken', $idTaken);
				$response->put('invalidTitle', $invalidTitle);
				$response->put('failed', $failed);
				$response->put('written', $written);

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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.addCategory'))
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

			$response->put('idPattern', $settings->get('datatypes.category.id.pattern'));
			$response->put('titlePattern', $settings->get('datatypes.category.title.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.addCategory.templateDestination'));
			$response->flush($settings->get('controllers.addCategory.templateDestination') . 'addCategory.php');
		}
	}
