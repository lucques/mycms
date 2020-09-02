<?php
	/**
	 * This class implements the UpdatePostMapper interface for a MySQL database.
	 */
	class MySQLUpdatePostMapper extends AbstractMySQLMapper implements UpdatePostMapper
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
			$sql  = 'UPDATE ';
			$sql .=   $this->relation('posts') . ' ';
			$sql .= 'SET ';
			$sql .=   'title = "' . $this->escape($this->post->get('title')) . '", ';
			$sql .=   'content = "' . $this->escape($this->post->get('content')) . '", ';
			$sql .=   'show_comments = ' . (int) $this->post->get('showComments') . ', ';
			$sql .=   'allow_comments = ' . (int) $this->post->get('allowComments') . ', ';
			$sql .=   'show_link = ' . (int) $this->post->get('showLink') . ', ';
			$sql .=   'show_timestamp = ' . (int) $this->post->get('showTimestamp') . ', ';
			$sql .=   'show_author = ' . (int) $this->post->get('showAuthor') . ', ';
			$sql .=   'is_static = ' . (int) $this->post->get('isStatic') . ', ';
			$sql .=   'timestamp = "' . MySQLTimestamp::fromTimestamp($this->post->get('timestamp')) . '", ';
			$sql .=   'author_id = "' . $this->escape($this->post->get('author')) . '" ';
			$sql .= 'WHERE ';
			$sql .=   'id = "' . $this->escape($this->post->get('id')) . '"';

			$this->database->query($sql);

			//delete old category assignments
			$sql  = 'DELETE FROM ';
			$sql .=   $this->relation('posts2categories') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'post_id = "' . $this->escape($this->post->get('id')) . '"';

			$this->database->query($sql);

			//insert new category assignments
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
