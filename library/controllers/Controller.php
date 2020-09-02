<?php
	/**
	 * Controller objects handle requests, evaluate them, dispatch them to other Controller objects, use models and then
	 * send a Response object back to the client.
	 */
	abstract class Controller
	{
		/**
		 * @param Request $request
		 * @param Response $response
		 */
		abstract public function action(Request $request, Response $response);

		/**
		 * @param string $controllerName
		 * @return RequestDispatcher
		 */
		protected function getRequestDispatcher($controller)
		{
			return new RequestDispatcher($controller);
		}
	}
