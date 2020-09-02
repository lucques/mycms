<?php
	/**
	 * This Controller is called if the user wants to edit a user.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class EditUserController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				if (!$request->containsGetParameter('id') ||
				    !PatternValidator::create($settings->get('datatypes.user.id.pattern'))->isValid($request->getGetParameter('id')))
					throw new NotFoundException();

				$mapper = $mapping->selectUserById($request->getGetParameter('id'));

				$users = $mapper->map();

				if ($users->size() != 1)
					throw new NotFoundException();

				$user = $users->get(0);

				$invalidNick = false;
				$invalidEmail = false;
				$invalidWebsite = false;
				$invalidPassword = false;
				$passwordsMismatch = false;
				$failed = false;
				$edited = false;

				if ($request->containsPostParameter('nick') && $request->containsPostParameter('email') && $request->containsPostParameter('website') && (!$request->containsPostParameter('change_password') || ($request->containsPostParameter('password') && $request->containsPostParameter('password_confirmation'))))
				{
					$user->put('nick', $request->getPostParameter('nick'));
					$user->put('email', $request->getPostParameter('email'));
					$user->put('website', $request->getPostParameter('website'));

					if ($request->containsPostParameter('change_password'))
					{
						$invalidPassword = !PatternValidator::create($settings->get('datatypes.user.password.pattern'))->isValid($request->getPostParameter('password'));

						$passwordsMismatch = $request->getPostParameter('password') != $request->getPostParameter('password_confirmation');

						if (!$invalidPassword && !$passwordsMismatch)
							$user->put('password', md5($request->getPostParameter('password')));
						else
						{
							$user->put('password', $request->getPostParameter('password'));
							$user->put('passwordConfirmation', $request->getPostParameter('password_confirmation'));
						}
					}

					$invalidNick = !PatternValidator::create($settings->get('datatypes.user.nick.pattern'))->isValid($user->get('nick'));
					$invalidEmail = !PatternValidator::create($settings->get('datatypes.user.email.pattern'))->isValid($user->get('email'));
					$invalidWebsite = !PatternValidator::create($settings->get('datatypes.user.website.pattern'))->isValid($user->get('website'));

					if (!$invalidNick && !$invalidEmail && !$invalidWebsite && !$invalidPassword && !$passwordsMismatch)
					{
						$mapping->updateUser($user)->map();

						$edited = true;
					}
					else
						$failed = true;
				}

				$response->put('user', $user);
				$response->put('invalidNick', $invalidNick);
				$response->put('invalidEmail', $invalidEmail);
				$response->put('invalidWebsite', $invalidWebsite);
				$response->put('invalidPassword', $invalidPassword);
				$response->put('passwordsMismatch', $passwordsMismatch);
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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editUser'))
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

			$response->put('nickPattern', $settings->get('datatypes.user.nick.pattern'));
			$response->put('passwordPattern', $settings->get('datatypes.user.password.pattern'));
			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.editUser.templateDestination'));
			$response->flush($settings->get('controllers.editUser.templateDestination') . 'editUser.php');
		}
	}
