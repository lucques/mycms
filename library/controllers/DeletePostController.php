<?php
	/**
	 * This Controller is called if the user wants to delete a post.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class DeletePostController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				if (!$request->containsGetParameter('id') ||
				    !PatternValidator::create($settings->get('datatypes.post.id.pattern'))->isValid($request->getGetParameter('id')))
					throw new NotFoundException();

				$mapper = $mapping->selectPostById($request->getGetParameter('id'));
				$mapper->addModifier(new ShowPostPathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editPost'))
					$mapper->addModifier(new EditPostPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deletePost'))
					$mapper->addModifier(new DeletePostPathModifier($settings, 'deletePath'));

				$posts = $mapper->map();

				if ($posts->size() != 1)
					throw new NotFoundException();

				$post = $posts->get(0);

				if ($request->containsPostParameter('delete'))
				{
					$mapping->deletePost($post->get('id'))->map();

					$response->sendRedirect($settings->get('root'));
				}
				else
				{
					//remove the show post path if post is not published yet
					if (Timestamp::toUnixTimestamp($post->timestamp) > time())
						$post->remove('path');

					$response->put('post', $post);

					$this->widgets($request, $response);
					$this->layout($request, $response);
				}
			}
			catch (UnauthorizedException $e)
			{
				$this->getRequestDispatcher('unauthorized')->dispatch($request, $response);
			}
			catch (NotFoundException $e)
			{
				$this->getRequestDispatcher('notFound')->dispatch($request, $response);
			}
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 * @throws UnauthorizedException
		 */
		protected function authorize(Request $request, Response $response)
		{
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deletePost'))
				throw new UnauthorizedException();
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 */
		protected function widgets(Request $request, Response $response)
		{
			$this->getRequestDispatcher('categoryArchivesWidget')->dispatch($request, $response);
			$this->getRequestDispatcher('yearMonthArchivesWidget')->dispatch($request, $response);
		}

		/**
		 * @param Request $request
		 * @param Response $response
		 */
		protected function layout(Request $request, Response $response)
		{
			$settings = $request->getAttribute('settings');

			$this->getRequestDispatcher('page')->dispatch($request, $response);

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.deletePost.templateDestination'));
			$response->flush($settings->get('controllers.deletePost.templateDestination') . 'deletePost.php');
		}
	}
