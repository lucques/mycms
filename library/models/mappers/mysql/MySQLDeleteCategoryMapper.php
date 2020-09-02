<?php
	/**
	 * This class implements the DeleteCategoryMapper interface for a MySQL database.
	 */
	class MySQLDeleteCategoryMapper extends AbstractMySQLMapper implements DeleteCategoryMapper
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
			$sql .=   $this->relation('categories') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'id = "' . $this->escape($this->id) . '"';

			$this->database->query($sql);

			//delete category assignments
			$sql  = 'DELETE FROM ';
			$sql .=   $this->relation('posts2categories') . ' ';
			$sql .= 'WHERE ';
			$sql .=   'category_id = "' . $this->escape($this->id) . '"';

			$this->database->query($sql);
		}
	}
