<?php
	/**
	 * This Controller is called if the user wants to delete a comment.
	 * This is no public action which means that you must have the permission defined in the role, otherwise the
	 * request will be dispatched to an UnauthorizedController.
	 */
	class DeleteCommentController extends Controller
	{
		public function action(Request $request, Response $response)
		{
			try
			{
				$this->authorize($request, $response);

				if (!$request->containsGetParameter('id') ||
				    !NaturalNumberValidator::create(false)->isValid($request->getGetParameter('id')))
					throw new NotFoundException();

				$mapping = $request->getAttribute('mapping');
				$settings = $request->getAttribute('settings');

				$mapper = $mapping->selectCommentById((int) $request->getGetParameter('id'));
				$mapper->addModifier(new ShowCommentPathModifier($settings, 'path'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.editComment'))
					$mapper->addModifier(new EditCommentPathModifier($settings, 'editPath'));

				if ($request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteComment'))
					$mapper->addModifier(new DeleteCommentPathModifier($settings, 'deletePath'));

				$comments = $mapper->map();

				if ($comments->size() != 1)
					throw new NotFoundException();

				$comment = $comments->get(0);

				if ($request->containsPostParameter('delete'))
				{
					$mapping->deleteComment($comment->get('id'))->map();

					$response->sendRedirect($settings->get('root'));
				}
				else
				{
					$response->put('comment', $comment);

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
			if (!$request->getAttribute('user')->get('role')->get('privileges')->contains('controllers.deleteComment'))
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

			$response->put('templatePath', $settings->get('root') . $settings->get('controllers.deleteComment.templateDestination'));
			$response->flush($settings->get('controllers.deleteComment.templateDestination') . 'deleteComment.php');
		}
	}
