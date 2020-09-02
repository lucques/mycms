<?php
	/**
	 * This class implements the UpdateCategoryMapper interface for a MySQL database.
	 */
	class MySQLUpdateCategoryMapper extends AbstractMySQLMapper implements UpdateCategoryMapper
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
			$sql  = 'UPDATE ';
			$sql .=   $this->relation('categories') . ' ';
			$sql .= 'SET ';
			$sql .=   'title = "' . $this->escape($this->category->get('title')) . '" ';
			$sql .= 'WHERE ';
			$sql .=   'id = "' . $this->escape($this->category->get('id')) . '"';

			$this->database->query($sql);
		}
	}
