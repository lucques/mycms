<?php
	/**
	 * This is the first Controller who gets executed. It delegates the Request and Response object to the right
	 * Controller.
	 */
	class FrontController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			$request->setAttribute('settings', $request->getAttribute('mapping')->selectSettings()->map());

			$controllers = array('categoryArchive',
			                     'dashboard',
			                     'recentPostsFeed',
			                     'recentPosts',
			                     'login',
			                     'logout',
			                     'showPost',
			                     'addPost',
			                     'editPost',
			                     'deletePost',
			                     'managePosts',
			                     'yearMonthArchive',
			                     'editComment',
			                     'deleteComment',
			                     'addCategory',
			                     'editCategory',
			                     'deleteCategory',
			                     'editSettings',
			                     'customPage',
			                     'editUser');

			try
			{
				$this->getRequestDispatcher('identifyUser')->dispatch($request, $response);

				if ($request->containsGetParameter('get') &&
				    in_array($request->getGetParameter('get'), $controllers))
					$this->getRequestDispatcher($request->getGetParameter('get'))->dispatch($request, $response);
				else
					$this->getRequestDispatcher('notFound')->dispatch($request, $response);
			}
			catch (Exception $e)
			{
				die($e->getMessage());
			}
		}
	}
