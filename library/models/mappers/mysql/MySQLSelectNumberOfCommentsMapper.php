<?php
	/**
	 * This class implements the SelectNumberOfCommentsMapper interface for a MySQL database.
	 */
	class MySQLSelectNumberOfCommentsMapper extends AbstractMySQLMapper implements SelectNumberOfCommentsMapper
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
			$sql .=   'COUNT(comment.id) AS number ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('comments') . ' AS comment' . implode('', $this->criterion->from()) . ' ';

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
		 * @param CommentCriterion $criterion
		 */
		public function addCriterion(CommentCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
