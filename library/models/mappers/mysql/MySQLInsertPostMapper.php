<?php
	/**
	 * This class implements the InsertPostMapper interface for a MySQL database.
	 */
	class MySQLInsertPostMapper extends AbstractMySQLMapper implements InsertPostMapper
	{
		protected $post;

		/**
		 * @param Database $database
		 * @param Map $post
		 */
		public function __construct(Database $database, Map $post)
		{
			parent::__construct($database);

			$this->post = $post;
		}

		public function setPost(Map $post)
		{
			$this->post = $post;
		}

		public function map()
		{
			$sql  = 'INSERT INTO ';
			$sql .=   $this->relation('posts') . ' (';
			$sql .=     'id, ';
			$sql .=     'title, ';
			$sql .=     'content, ';
			$sql .=     'show_comments, ';
			$sql .=     'allow_comments, ';
			$sql .=     'show_link, ';
			$sql .=     'show_timestamp, ';
			$sql .=     'show_author, ';
			$sql .=     'is_static, ';
			$sql .=     'timestamp, ';
			$sql .=     'author_id';
			$sql .=   ') ';
			$sql .=   'VALUES (';
			$sql .=     '"' . $this->escape($this->post->get('id')) . '", ';
			$sql .=     '"' . $this->escape($this->post->get('title')) . '", ';
			$sql .=     '"' . $this->escape($this->post->get('content')) . '", ';
			$sql .=     (int) $this->post->get('showComments') . ', ';
			$sql .=     (int) $this->post->get('allowComments') . ', ';
			$sql .=     (int) $this->post->get('showLink') . ', ';
			$sql .=     (int) $this->post->get('showTimestamp') . ', ';
			$sql .=     (int) $this->post->get('showAuthor') . ', ';
			$sql .=     (int) $this->post->get('isStatic') . ', ';
			$sql .=     '"' . MySQLTimestamp::fromTimestamp($this->post->get('timestamp')) . '", ';
			$sql .=     '"' . $this->escape($this->post->get('author')) . '"';
			$sql .=   ')';

			$this->database->query($sql);

			//insert category assignments
			$categoryIterator = $this->post->get('categories')->iterator();

			while ($categoryIterator->hasNext())
			{
				$category = $categoryIterator->next();

				$sql  = 'INSERT INTO ';
				$sql .=   $this->relation('posts2categories') . ' (';
				$sql .=     'post_id, ';
				$sql .=     'category_id';
				$sql .=   ') ';
				$sql .=   'VALUES (';
				$sql .=     '"' . $this->escape($this->post->get('id')) . '", ';
				$sql .=     '"' . $this->escape($category) . '"';
				$sql .=   ')';

				$this->database->query($sql);
			}
		}
	}
