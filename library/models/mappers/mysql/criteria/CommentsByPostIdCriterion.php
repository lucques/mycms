<?php
	/**
	 * This criterion lets the mapper only select comments which belong to a given post id.
	 */
	class CommentsByPostIdCriterion extends AbstractCriterion implements CommentCriterion
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

		public function where()
		{
			return array('post.id = "' . $this->escape($this->id) . '"');
		}
	}
