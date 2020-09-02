<?php
	/**
	 * This Controller is used to identify the user. This means it is called whenever it matters who the user is. If
	 * there is an existing session with a user logged in, the user and its role are put into the Request object as an
	 * attribute. If there is no session, the default user with its role will be loaded.
	 */
	class IdentifyUserController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$mapping = $request->getAttribute('mapping');
			$settings = $request->getAttribute('settings');
			$session = $request->getSession(false);

			if ($session == null || !$session->containsAttribute('id'))
			{
				$mapper = $mapping->selectUserById($settings->get('session.defaultUser'));
				$mapper->setSelectRoles(true);

				$request->setAttribute('user', $mapper->map()->get(0));
			}
			else
			{
				$mapper = $mapping->selectUserById($session->getAttribute('id'));
				$mapper->setSelectRoles(true);

				$users = $mapper->map();

				$request->setAttribute('user', $users->get(0));
			}
		}
	}
