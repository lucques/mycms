<?php
	/**
	 * This interface contains all methods to select, write and update data from a data source.
	 */
	interface MappingModel
	{
		/**
		 * @return SelectCategoriesMapper
		 */
		public function selectCategories();

		/**
		 * @return SelectCategoriesMapper
		 */
		public function selectUnusedCategories();

		/**
		 * @return SelectCategoriesMapper
		 */
		public function selectUsedCategoriesOfPublishedPosts();

		/**
		 * @param string $id
		 * @return SelectCategoriesMapper
		 */
		public function selectCategoryById($id);

		/**
		 * @param string $id
		 * @return SelectCategoriesMapper
		 */
		public function selectUsedCategoryById($id);

		/**
		 * @return SelectNumberOfCategoriesMapper
		 */
		public function selectNumberOfCategories();

		/**
		 * @param Map $category
		 * @return UpdateCategoryMapper
		 */
		public function updateCategory(Map $category);

		/**
		 * @param Map $category
		 * @return InsertCategoryMapper
		 */
		public function insertCategory(Map $category);

		/**
		 * @param string $id
		 * @return DeleteCategoryMapper
		 */
		public function deleteCategory($id);

		/**
		 * @return SelectCommentsMapper
		 */
		public function selectCommentById($id);

		/**
		 * @return SelectCommentsMapper
		 */
		public function selectComments();

		/**
		 * @param string $id
		 * @return SelectCommentsMapper
		 */
		public function selectCommentsByPostId($id);

		/**
		 * @return SelectNumberOfCommentsMapper
		 */
		public function selectNumberOfComments();

		/**
		 * @param Map $comment
		 * @return UpdateCommentMapper
		 */
		public function updateComment(Map $comment);

		/**
		 * @param Map $comment
		 * @param string $postId
		 * @return InsertCommentMapper
		 */
		public function insertComment(Map $comment, $postId);

		/**
		 * @param int $id
		 * @return DeleteCommentMapper
		 */
		public function deleteComment($id);

		/**
		 * @param string $id
		 * @return SelectPostsMapper
		 */
		public function selectPostById($id);

		/**
		 * @param string $id
		 * @return SelectPostsMapper
		 */
		public function selectPublishedPostById($id);

		/**
		 * @return SelectPostsMapper
		 */
		public function selectPublishedStaticPosts();

		/**
		 * @return SelectPostsMapper
		 */
		public function selectPublishedNonstaticPosts();

		/**
		 * @param string $categoryId
		 * @return SelectPostsMapper
		 */
		public function selectPublishedPostsByCategoryId($id);

		/**
		 * @param Map $timestamp
		 * @return SelectPostsMapper
		 */
		public function selectPublishedNonstaticPostsByTimestamp(Map $timestamp);

		/**
		 * @return SelectNumberOfPostsMapper
		 */
		public function selectNumberOfPosts();

		/**
		 * @return SelectNumberOfPostsMapper
		 */
		public function selectNumberOfPublishedNonstaticPosts();

		/**
		 * @param string $categoryId
		 * @return SelectNumberOfPostsMapper
		 */
		public function selectNumberOfPublishedPostsByCategoryId($id);

		/**
		 * @param Map $timestamp
		 * @return SelectNumberOfPostsMapper
		 */
		public function selectNumberOfPublishedNonstaticPostsByTimestamp(Map $timestamp);

		/**
		 * @return SelectTimestampsOfPostsMapper
		 */
		public function selectTimestampsOfPublishedNonstaticPosts();

		/**
		 * @param Map $post
		 * @return UpdatePostMapper
		 */
		public function updatePost(Map $post);

		/**
		 * @param Map $post
		 * @return InsertPostMapper
		 */
		public function insertPost(Map $post);

		/**
		 * @param string $id
		 * @return DeletePostMapper
		 */
		public function deletePost($id);

		/**
		 * @return SelectSettingsMapper
		 */
		public function selectSettings();

		/**
		 * @param string $id
		 * @return SelectUsersMapper
		 */
		public function selectUserById($id);

		/**
		 * @param Map $user
		 * @return UpdateUserMapper
		 */
		public function updateUser(Map $user);

		/**
		 * @param Map $settings
		 * @return UpdateSettingsMapper
		 */
		public function updateSettings(Map $settings);
	}
