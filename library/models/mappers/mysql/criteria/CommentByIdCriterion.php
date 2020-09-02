<?php
	/**
	 * This criterion lets the mapper only select one comment by id.
	 */
	class CommentByIdCriterion extends AbstractCriterion implements CommentCriterion
	{
		protected $id;

		/**
		 * @param Database $database
		 * @param int $id
		 */
		public function __construct(Database $database, $id)
		{
			parent::__construct($database);

			$this->id = $id;
		}

		public function where()
		{
			return array('comment.id = ' . $this->id);
		}
	}
