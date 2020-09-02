<?php
	/**
	 * This Controller is called by other controllers which want to offer a widget that shows all published static posts.
	 */
	class StaticPostsWidgetController extends Controller
	{	
		public function action(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$mapper = $request->getAttribute('mapping')->selectPublishedStaticPosts();
			$mapper->setAscending(false);
			$mapper->setSelectAuthor(true);
			$mapper->addModifier(new ShowPostPathModifier($settings, 'path'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editPost'))
				$mapper->addModifier(new EditPostPathModifier($settings, 'editPath'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deletePost'))
				$mapper->addModifier(new DeletePostPathModifier($settings, 'deletePath'));

			$posts = $mapper->map();

			if ($posts->size() > 0)
				$response->put('staticPostsWidget', $posts);
		}
	}
