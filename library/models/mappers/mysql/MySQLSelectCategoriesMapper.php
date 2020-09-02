<?php
	/**
	 * This class implements the SelectCategoriesMapper interface for a MySQL database.
	 */
	class MySQLSelectCategoriesMapper extends MySQLMapListMapper implements SelectCategoriesMapper
	{
		protected $selectNumberOfPosts;
		protected $criterion;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->selectNumberOfPosts = false;
			$this->criterion = new CompositeCriterion();
		}

		public function setSelectNumberOfPosts($selectNumberOfPosts)
		{
			$this->selectNumberOfPosts = $selectNumberOfPosts;
		}

		public function map()
		{
			$categories = new MyList();

			if ($this->selectNumberOfPosts)
			{
				$criterion = new ModifiableCriterion();
				$criterion->addToFrom(' LEFT JOIN ' . $this->relation('posts2categories') . ' ' .
				                         'AS post2category ' .
				                         'ON category.id = post2category.category_id');
				$criterion->addToGroupBy('category.id');
				$criterion->addToGroupBy('category.title');

				$this->criterion->add($criterion);
			}

			$sql  = 'SELECT ';
			$sql .=   'category.id, ';
			$sql .=   'category.title';

			if ($this->selectNumberOfPosts)
				$sql .= ', COUNT(post2category.post_id) AS number_of_posts';

			$sql .= ' ';
			$sql .= 'FROM ';
			$sql .=   $this->relation('categories') . ' AS category';
			$sql .=   implode('', $this->criterion->from()) . ' ';

			$where = $this->criterion->where();

			if (count($where) > 0)
				$sql .= 'WHERE ' . implode(' AND ', $where) . ' ';

			$groupBy = $this->criterion->groupBy();

			if (count($groupBy) > 0)
				$sql .= 'GROUP BY ' . implode(', ', $groupBy) . ' ';

			$having = $this->criterion->having();

			if (count($having) > 0)
				$sql .= 'HAVING ' . implode(' AND ', $having) . ' ';

			$sql .= 'ORDER BY ';
			$sql .=   'category.title';

			$iterator = $this->database->query($sql);
			$iterator->skip($this->offset);

			for ($i = 0; ($this->limit == -1 || $i < $this->limit) && $iterator->hasNext(); $i ++)
			{
				$tuple = $iterator->next();

				$category = new Map();
				$category->put('id', $tuple['id']);
				$category->put('title', $tuple['title']);

				if ($this->selectNumberOfPosts)
					$category->put('numberOfPosts', $tuple['number_of_posts']);

				$this->modifier->modify($category);

				$categories->add($category);
			}

			return $categories;
		}

		/**
		 * @param CategoryCriterion $criterion
		 */
		public function addCriterion(CategoryCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
