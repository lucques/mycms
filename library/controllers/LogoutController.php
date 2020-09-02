<?php
	/**
	 * This Controller is called if the user wants to logout.
	 * If the user is the default user, the request will be dispatched to an UnauthorizedController.
	 */
	class LogoutController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$settings = $request->getAttribute('settings');

				$session = $request->getSession(false);
				$session->invalidate();

				$response->sendRedirect($settings->get('root'));	
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
			//do not let the default user try to log out
			if ($request->getAttribute('user')->get('id') == $request->getAttribute('settings')->get('session.defaultUser'))
				throw new UnauthorizedException();
		}
	}
