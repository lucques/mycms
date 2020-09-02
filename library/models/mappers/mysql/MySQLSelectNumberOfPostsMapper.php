<?php
	/**
	 * This class implements the SelectNumberOfPostsMapper interface for a MySQL database.
	 */
	class MySQLSelectNumberOfPostsMapper extends AbstractMySQLMapper implements SelectNumberOfPostsMapper
	{
		protected $criterion;

		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->criterion = new CompositeCriterion();
		}

		public function map()
		{
			$sql  = 'SELECT ';
			$sql .=   'COUNT(post.id) AS number ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('posts') . ' AS post' . implode('', $this->criterion->from()) . ' ';

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
		 * @param PostCriterion $criterion
		 */
		public function addCriterion(PostCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
