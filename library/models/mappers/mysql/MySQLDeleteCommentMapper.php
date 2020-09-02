<?php
	/**
	 * This class implements the DeleteCommentMapper interface for a MySQL database.
	 */
	class MySQLDeleteCommentMapper extends AbstractMySQLMapper implements DeleteCommentMapper
	{
		protected $id;

		/**
		 * @param Database $database
		 * @param int $id
		 */
		public function __construct(Database $database, $id)
		{
			parent::__construct($database);

			$this->id = $id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function map()
		{
			$sql  = 'DELETE FROM ';
			$sql .=   $this->relation('comments') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'id = ' . $this->id;

			$this->database->query($sql);
		}
	}
