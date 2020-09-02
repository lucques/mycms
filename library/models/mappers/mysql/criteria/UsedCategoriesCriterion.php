<?php
	/**
	 * This criterion lets the mapper only select categories which are assigned to one or more posts.
	 */
	class UsedCategoriesCriterion extends AbstractCriterion implements CategoryCriterion
	{
		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);
		}

		public function from()
		{
			return array(' LEFT JOIN ' . $this->relation('posts2categories') . ' AS post2category ' .
			                'ON category.id = post2category.category_id');
		}

		public function groupBy()
		{
			return array('category.id');
		}

		public function having()
		{
			return array('COUNT(post2category.post_id) > 0');
		}
	}
