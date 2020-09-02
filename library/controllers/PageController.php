<?php
	/**
	 * This Controller is called from other controllers to put some common data into the Response object.
	 */
	class PageController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$response->put('title', $settings->get('meta.title'));
			$response->put('description', $settings->get('meta.description'));
			$response->put('language', $settings->get('meta.language'));
			$response->put('footer', $settings->get('meta.footer'));
			$response->put('timeZoneOffset', $settings->get('meta.timeZoneOffset'));
			$response->put('timeZoneOffsetInDST', $settings->get('meta.timeZoneOffsetInDST'));
			$response->put('host', $settings->get('host'));
			$response->put('root', $settings->get('root'));
			$response->put('path', $request->getPath());

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.dashboard'))
				$response->put('dashboardPath', $settings->get('root') . $settings->get('controllers.dashboard.destination'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.addPost'))
				$response->put('addPostPath', $settings->get('root') . $settings->get('controllers.addPost.destination'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.addCategory'))
				$response->put('addCategoryPath', $settings->get('root') . $settings->get('controllers.addCategory.destination'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editSettings'))
				$response->put('editSettingsPath', $settings->get('root') . $settings->get('controllers.editSettings.destination'));

			if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editUser'))
			{
				$modifier = new EditUserPathModifier($settings, 'editPath');
				$modifier->modify($request->getAttribute('user'));

				$response->put('editUserPath', $request->getAttribute('user')->get('editPath'));

				$request->getAttribute('user')->remove('editPath');
			}

			if ($request->getAttribute('user')->get('id') != $request->getAttribute('settings')->get('session.defaultUser'))
				$response->put('logoutPath', $settings->get('root') . $settings->get('controllers.logout.destination'));
		}
	}
