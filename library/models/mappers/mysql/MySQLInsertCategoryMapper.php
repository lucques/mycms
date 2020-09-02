<?php
	/**
	 * This class implements the InsertCategoryMapper interface for a MySQL database.
	 */
	class MySQLInsertCategoryMapper extends AbstractMySQLMapper implements InsertCategoryMapper
	{
		protected $category;

		/**
		 * @param Database $database
		 * @param Map $category
		 */
		public function __construct(Database $database, Map $category)
		{
			parent::__construct($database);

			$this->category = $category;
		}

		public function setCategory(Map $category)
		{
			$this->category = $category;
		}

		public function map()
		{
			$sql  = 'INSERT INTO ';
			$sql .=   $this->relation('categories') . ' (';
			$sql .=     'id, ';
			$sql .=     'title';
			$sql .=   ') ';
			$sql .=   'VALUES (';
			$sql .=     '"' . $this->escape($this->category->get('id')) . '", ';
			$sql .=     '"' . $this->escape($this->category->get('title')) . '"';
			$sql .=   ')';

			$this->database->query($sql);
		}
	}
