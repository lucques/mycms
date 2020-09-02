<?php
	/**
	 * This class implements a MappingModel for a MySQL database.
	 */
	class MySQLMappingModel implements MappingModel
	{
		protected $database;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			$this->database = $database;
		}

		public function selectCategories()
		{
			$mapper = new MySQLSelectCategoriesMapper($this->database);

			return $mapper;
		}

		public function selectUnusedCategories()
		{
			$mapper = new MySQLSelectCategoriesMapper($this->database);
			$mapper->addCriterion(new UnusedCategoriesCriterion($this->database));

			return $mapper;
		}

		public function selectUsedCategoriesOfPublishedPosts()
		{
			$mapper = new MySQLSelectCategoriesMapper($this->database);
			$mapper->addCriterion(new UsedCategoriesCriterion($this->database));
			$mapper->addCriterion(new CategoriesOfPublishedPostsCriterion($this->database));

			return $mapper;
		}

		public function selectCategoryById($id)
		{
			$mapper = new MySQLSelectCategoriesMapper($this->database);
			$mapper->addCriterion(new CategoryByIdCriterion($this->database, $id));

			return $mapper;
		}

		public function selectUsedCategoryById($id)
		{
			$mapper = new MySQLSelectCategoriesMapper($this->database);
			$mapper->addCriterion(new CategoryByIdCriterion($this->database, $id));
			$mapper->addCriterion(new UsedCategoriesCriterion($this->database));

			return $mapper;
		}

		public function selectNumberOfCategories()
		{
			$mapper = new MySQLSelectNumberOfCategoriesMapper($this->database);

			return $mapper;
		}

		public function updateCategory(Map $category)
		{
			return new MySQLUpdateCategoryMapper($this->database, $category);
		}

		public function insertCategory(Map $category)
		{
			return new MySQLInsertCategoryMapper($this->database, $category);
		}

		public function deleteCategory($id)
		{
			return new MySQLDeleteCategoryMapper($this->database, $id);
		}

		public function selectCommentById($id)
		{
			$mapper = new MySQLSelectCommentsMapper($this->database);
			$mapper->addCriterion(new CommentByIdCriterion($this->database, $id));

			return $mapper;
		}

		public function selectComments()
		{
			$mapper = new MySQLSelectCommentsMapper($this->database);

			return $mapper;
		}

		public function selectCommentsByPostId($id)
		{
			$mapper = new MySQLSelectCommentsMapper($this->database);
			$mapper->addCriterion(new CommentsByPostIdCriterion($this->database, $id));

			return $mapper;
		}

		public function selectNumberOfComments()
		{
			$mapper = new MySQLSelectNumberOfCommentsMapper($this->database);

			return $mapper;
		}

		public function updateComment(Map $comment)
		{
			return new MySQLUpdateCommentMapper($this->database, $comment);
		}

		public function insertComment(Map $comment, $postId)
		{
			return new MySQLInsertCommentMapper($this->database, $comment, $postId);
		}

		public function deleteComment($id)
		{
			return new MySQLDeleteCommentMapper($this->database, $id);
		}

		public function selectPostById($id)
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new PostByIdCriterion($this->database, $id));

			return $mapper;
		}

		public function selectPublishedPostById($id)
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new PostByIdCriterion($this->database, $id));

			return $mapper;
		}

		public function selectPublishedStaticPosts()
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new StaticPostsCriterion($this->database));

			return $mapper;
		}

		public function selectPublishedNonstaticPosts()
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new NonstaticPostsCriterion($this->database));

			return $mapper;
		}

		public function selectPublishedPostsByCategoryId($id)
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new PostsByCategoryIdCriterion($this->database, $id));

			return $mapper;
		}

		public function selectPublishedNonstaticPostsByTimestamp(Map $timestamp)
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new NonstaticPostsCriterion($this->database));
			$mapper->addCriterion(new PostsByTimestampCriterion($this->database, $timestamp));

			return $mapper;
		}

		public function selectUnpublishedPosts()
		{
			$mapper = new MySQLSelectPostsMapper($this->database);
			$mapper->addCriterion(new UnpublishedPostsCriterion($this->database));

			return $mapper;
		}

		public function selectNumberOfPosts()
		{
			$mapper = new MySQLSelectNumberOfPostsMapper($this->database);

			return $mapper;
		}

		public function selectNumberOfPublishedNonstaticPosts()
		{
			$mapper = new MySQLSelectNumberOfPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new NonstaticPostsCriterion($this->database));

			return $mapper;
		}

		public function selectNumberOfPublishedPostsByCategoryId($categoryId)
		{
			$mapper = new MySQLSelectNumberOfPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new PostsByCategoryIdCriterion($this->database, $categoryId));

			return $mapper;
		}

		public function selectNumberOfPublishedNonstaticPostsByTimestamp(Map $timestamp)
		{
			$mapper = new MySQLSelectNumberOfPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new NonstaticPostsCriterion($this->database));
			$mapper->addCriterion(new PostsByTimestampCriterion($this->database, $timestamp));

			return $mapper;
		}

		public function selectTimestampsOfPublishedNonstaticPosts()
		{
			$mapper = new MySQLSelectTimestampsOfPostsMapper($this->database);
			$mapper->addCriterion(new PublishedPostsCriterion($this->database));
			$mapper->addCriterion(new NonstaticPostsCriterion($this->database));

			return $mapper;
		}

		public function updatePost(Map $post)
		{
			return new MySQLUpdatePostMapper($this->database, $post);
		}

		public function insertPost(Map $post)
		{
			return new MySQLInsertPostMapper($this->database, $post);
		}

		public function deletePost($id)
		{
			return new MySQLDeletePostMapper($this->database, $id);
		}

		public function selectSettings()
		{
			return new MySQLSelectSettingsMapper($this->database);
		}

		public function selectUserById($id)
		{
			$mapper = new MySQLSelectUsersMapper($this->database);
			$mapper->addCriterion(new UserByIdCriterion($this->database, $id));

			return $mapper;
		}

		public function updateUser(Map $user)
		{
			return new MySQLUpdateUserMapper($this->database, $user);
		}

		public function updateSettings(Map $settings)
		{
			return new MySQLUpdateSettingsMapper($this->database, $settings);
		}
	}
