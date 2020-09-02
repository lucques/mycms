<?php
	/**
	 * This class implements the UpdateCommentMapper interface for a MySQL database.
	 */
	class MySQLUpdateCommentMapper extends AbstractMySQLMapper implements UpdateCommentMapper
	{
		protected $comment;

		/**
		 * @param Database $database
		 * @param Map $comment
		 */
		public function __construct(Database $database, Map $comment)
		{
			parent::__construct($database);

			$this->comment = $comment;
		}

		public function setComment(Map $comment)
		{
			$this->comment = $comment;
		}

		public function map()
		{
			$sql  = 'UPDATE ';
			$sql .=   $this->relation('comments') . ' ';
			$sql .= 'SET ';
			$sql .=   'nick = "' . $this->escape($this->comment->get('nick')) . '", ';
			$sql .=   'email = "' . $this->escape($this->comment->get('email')) . '", ';
			$sql .=   'website = "' . $this->escape($this->comment->get('website')) . '", ';
			$sql .=   'content = "' . $this->escape($this->comment->get('content')) . '", ';
			$sql .=   'timestamp = "' . MySQLTimestamp::fromTimestamp($this->comment->get('timestamp')) . '" ';
			$sql .= 'WHERE ';
			$sql .=   'id = ' . $this->comment->get('id');

			$this->database->query($sql);
		}
	}
