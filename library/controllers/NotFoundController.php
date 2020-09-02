<?php
	/**
	 * This Controller is called if an action called by the user does not exist. This class inherits all methods of
	 * ShowPostController which means it behaves just the same except that the post id is predefined in the settings.
	 */
	class NotFoundController extends ShowPostController
	{
		public function action(Request $request, Response $response)
		{
			$response->setStatus(404);

			parent::action($request, $response);
		}

		protected function getPostId(Request $request)
		{
			return $request->getAttribute('settings')->get('controllers.notFound.postId');
		}
	}
