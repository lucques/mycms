<?php
	/**
	 * This criterion lets the mapper only select posts which are assigned to a given category id.
	 */
	class PostsByCategoryIdCriterion extends AbstractCriterion implements PostCriterion
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

		public function from()
		{
			return array(', ' . $this->relation('posts2categories') . ' AS post2category');
		}

		public function where()
		{
			return array('post.id = post2category.post_id',
			             'post2category.category_id = "' . $this->escape($this->id) . '"');
		}
	}
