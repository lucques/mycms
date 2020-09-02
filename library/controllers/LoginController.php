<?php
	/**
	 * This Controller is called if the user wants to get a login page or has sent his username and password to the
	 * server. If username/password combination is right, the user gets forwarded to the dashboard and his username
	 * is mapped to his session.
	 * If the user is not the default user, the request will be dispatched to an UnauthorizedController.
	 */
	class LoginController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$settings = $request->getAttribute('settings');

				if ($request->containsPostParameter('id') &&
				    $request->containsPostParameter('password'))
				{
					if (PatternValidator::create($settings->get('datatypes.user.id.pattern'))->isValid($request->getPostParameter('id')))
					{
						//do not let the default user log in
						if ($request->getPostParameter('id') != $settings->get('session.defaultUser'))
						{
							$mapper = $request->getAttribute('mapping')->selectUserById($request->getPostParameter('id'));
							$mapper->setSelectRoles(true);

							$users = $mapper->map();

							if ($users->size() == 1)
							{
								$user = $users->get(0);

								if ($user->get('password') == md5($request->getPostParameter('password')))
								{
									$session = $request->getSession(true);
									$session->setAttribute('id', $request->getPostParameter('id'));

									$response->sendRedirect($settings->get('root'));
								}
							}
						}

						$response->put('invalidId', false);
					}
					else
						$response->put('invalidId', true);

					$response->put('loginFailed', true);
					$response->put('id', $request->getPostParameter('id'));
				}
				else
				{
					$response->put('loginFailed', false);
					$response->put('invalidId', false);
				}

				$session = $request->getSession(false);

				if ($session == null || !$session->containsAttribute('id'))
				{
					$this->widgets($request, $response);
					$this->layout($request, $response);
				}
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
			//do not let users logged in see the login page or try to log in again.
			if ($request->getAttribute('user')->get('id') != $request->getAttribute('settings')->get('session.defaultUser'))
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

			$response->put('idPattern', $settings->get('datatypes.user.id.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.login.templateDestination'));
			$response->flush($settings->get('controllers.login.templateDestination') . 'login.php');
		}
	}
