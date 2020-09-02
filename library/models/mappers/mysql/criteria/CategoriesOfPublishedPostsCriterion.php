<?php
	/**
	 * This criterion lets the mapper only select categories which are assigned to at least one published post.
	 */
	class CategoriesOfPublishedPostsCriterion extends AbstractCriterion implements CategoryCriterion
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
			return array(' LEFT JOIN '. $this->relation('posts2categories') . ' AS post2category ' .
			                'ON category.id = post2category.category_id',
			             ', ' . $this->relation('posts') . ' AS post');
		}

		public function where()
		{
			return array('post2category.post_id = post.id',
			             'post.timestamp < NOW()');
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
