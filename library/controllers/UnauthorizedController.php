<?php
	/**
	 * This Controller is called if an action called by the user is unauthorized. This class inherits all methods of
	 * ShowPostController which means it behaves just the same except that the post id is predefined in the settings.
	 */
	class UnauthorizedController extends ShowPostController
	{
		public function action(Request $request, Response $response)
		{
			$response->setStatus(401);

			parent::action($request, $response);
		}

		protected function getPostId(Request $request)
		{
			return $request->getAttribute('settings')->get('controllers.unauthorized.postId');
		}
	}
