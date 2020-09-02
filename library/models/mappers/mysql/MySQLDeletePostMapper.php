<?php
	/**
	 * This class implements the DeletePostMapper interface for a MySQL database.
	 */
	class MySQLDeletePostMapper extends AbstractMySQLMapper implements DeletePostMapper
	{
		protected $id;

		/**
		 * @param Database $database
		 * @param string $id
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
			$sql .=   $this->relation('posts') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'id = "' . $this->escape($this->id) . '"';

			$this->database->query($sql);

			//delete category assignments
			$sql  = 'DELETE FROM ';
			$sql .=   $this->relation('posts2categories') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'post_id = "' . $this->escape($this->id) . '"';

			$this->database->query($sql);

			//delete comments
			$sql  = 'DELETE FROM ';
			$sql .=   $this->relation('comments') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'post_id = "' . $this->escape($this->id) . '"';

			$this->database->query($sql);
		}
	}
