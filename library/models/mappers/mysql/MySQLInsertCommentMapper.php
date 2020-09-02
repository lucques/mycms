<?php
	/**
	 * This class implements the InsertCommentMapper interface for a MySQL database.
	 */
	class MySQLInsertCommentMapper extends AbstractMySQLMapper implements InsertCommentMapper
	{
		protected $comment;
		protected $postId;

		/**
		 * @param Database $database
		 * @param Map $comment
		 * @param string $postId
		 */
		public function __construct(Database $database, Map $comment, $postId)
		{
			parent::__construct($database);

			$this->comment = $comment;
			$this->postId = $postId;
		}

		public function setComment(Map $comment)
		{
			$this->comment = $comment;
		}

		public function setPostId($id)
		{
			$this->postId = $id;
		}

		public function map()
		{
			$sql  = 'INSERT INTO ';
			$sql .=   $this->relation('comments') . ' (';
			$sql .=     'nick, ';
			$sql .=     'email, ';
			$sql .=     'website, ';
			$sql .=     'content, ';
			$sql .=     'timestamp, ';
			$sql .=     'post_id';
			$sql .=   ') ';
			$sql .=   'VALUES (';
			$sql .=     '"' . $this->escape($this->comment->get('nick')) . '", ';
			$sql .=     '"' . $this->escape($this->comment->get('email')) . '", ';
			$sql .=     '"' . $this->escape($this->comment->get('website')) . '", ';
			$sql .=     '"' . $this->escape($this->comment->get('content')) . '", ';
			$sql .=     '"' . MySQLTimestamp::fromTimestamp($this->comment->get('timestamp')) . '", ';
			$sql .=     '"' . $this->escape($this->postId) . '"';
			$sql .=   ') ';

			$this->database->query($sql);
		}
	}
