<?php
	/**
	 * This Controller is called if the user wants to edit the settings.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class EditSettingsController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				$failed = false;
				$edited = false;

				$keyIterator = $settings->keyList()->iterator();

				$allKeysExist = true;

				while ($keyIterator->hasNext())
				{
					$key = $keyIterator->next();

					if (!$request->containsPostParameter(str_replace('.', '_', $key)))
					{
						$allKeysExist = false;
						break;
					}

					$settings->put($key, $request->getPostParameter(str_replace('.', '_', $key)));

					$failed = $failed || !PatternValidator::create($settings->get('datatypes.setting.value.pattern'))->isValid($settings->get($key));
				}

				if ($allKeysExist && !$failed)
				{
					$mapping->updateSettings($settings)->map();

					$edited = true;
				}

				$response->put('settings', $settings);
				$response->put('failed', $failed);
				$response->put('edited', $edited);

				$this->widgets($request, $response);
				$this->layout($request, $response);
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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editSettings'))
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

			$response->put('valuePattern', $settings->get('datatypes.setting.value.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.editSettings.templateDestination'));
			$response->flush($settings->get('controllers.editSettings.templateDestination') . 'editSettings.php');
		}
	}
