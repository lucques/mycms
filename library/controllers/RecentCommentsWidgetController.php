<?php
	/**
	 * This Controller is called by other controllers which want to offer a widget which shows the recent comments.
	 */
	class RecentCommentsWidgetController extends Controller
	{	
		public function action(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$mapper = $request->getAttribute('mapping')->selectComments();
			$mapper->setLimit((int) $settings->get('controllers.recentCommentsWidget.number'));
			$mapper->setAscending(false);
			$mapper->addModifier(new ShowCommentPathModifier($settings, 'path'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editComment'))
				$mapper->addModifier(new EditCommentPathModifier($settings, 'editPath'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteComment'))
				$mapper->addModifier(new DeleteCommentPathModifier($settings, 'deletePath'));

			$comments = $mapper->map();

			if ($comments->size() > 0)
				$response->put('recentCommentsWidget', $comments);
		}
	}
