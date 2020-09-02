<?php
	/**
	 * This class implements the SelectNumberOfCategoriesMapper interface for a MySQL database.
	 */
	class MySQLSelectNumberOfCategoriesMapper extends AbstractMySQLMapper implements SelectNumberOfCategoriesMapper
	{
		protected $criterion;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->criterion = new CompositeCriterion();
		}

		public function map()
		{
			$sql  = 'SELECT ';
			$sql .=   'COUNT(category.id) AS number ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('categories') . ' AS category' . implode('', $this->criterion->from()) . ' ';

			$where = $this->criterion->where();

			if (count($where) > 0)
				$sql .= 'WHERE ' . implode(' AND ', $where) . ' ';

			$groupBy = $this->criterion->groupBy();

			if (count($groupBy) > 0)
				$sql .= 'GROUP BY ' . implode(',', $groupBy) . ' ';

			$having = $this->criterion->having();

			if (count($having) > 0)
				$sql .= 'HAVING ' . implode(' AND ', $having) . ' ';

			$tuple = $this->database->query($sql)->next();

			return (int) $tuple['number'];
		}

		/**
		 * @param CategoryCriterion $criterion
		 */
		public function addCriterion(CategoryCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
