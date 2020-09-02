<?php
	/**
	 * This Controller is used if the user wants to get a custom page. The page will be flushed if it is defined in the settings.
	 * If the requested page was not defined, the request will be dispatched to a NotFoundController object.
	 */
	class CustomPageController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			try
			{
				$page = $this->getPageId($request);

				if (!in_array($page, explode(',', $settings->get('controllers.customPage.pages'))))
					throw new NotFoundException();

				$this->widgets($request, $response);

				$this->getRequestDispatcher('page')->dispatch($request, $response);

				$response->put('templatePath', $settings->get('root') . $settings->get('controllers.customPage.templateDestination'));
				$response->flush($settings->get('controllers.customPage.templateDestination') . $page . '.php');
			}
			catch (NotFoundException $e)
			{
				$this->getRequestDispatcher('notFound')->dispatch($request, $response);
			}
		}

		/**
		 * @param Request $request
		 * @throws NotFoundException
		 */
		protected function getPageId(Request $request)
		{
			$settings = $request->getAttribute('settings');

			if (!$request->containsGetParameter('id') ||
			    !PatternValidator::create($settings->get('datatypes.customPage.pattern'))->isValid($request->getGetParameter('id')))
				throw new NotFoundException();

			return $request->getGetParameter('id');
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
	}
