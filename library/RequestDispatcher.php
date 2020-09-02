<?php
	/**
	 * Whenever the request has to get dispatched, an instance of this class is created. By calling dispatch() the given
	 * controller gets excecuted.
	 */
	class RequestDispatcher
	{
		protected $controller;

		/**
		 * @param string $name
		 */
		public function __construct($name)
		{
			$this->controller = null;

			$name = ucfirst($name) . 'Controller';

			$this->controller = new $name();
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 * @throws NullPointerException
		 */
		public function dispatch(Request $request, Response $response)
		{
			$this->controller->action($request, $response);
		}
	}
