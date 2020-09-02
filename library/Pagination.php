<?php
	/**
	 * This class represents a pagination.
	 */
	class Pagination
	{
		protected $numberOfPages;
		protected $data;
		protected $modifier;

		/**
		 * @param int $numberOfData
		 * @param int $dataPerPage
		 * @param Map $data
		 */
		public function __construct($numberOfData, $dataPerPage, Map $data)
		{
			$this->numberOfPages = (int) ceil($numberOfData / $dataPerPage);
			$this->data = $data;
			$this->modifier = new CompositeModifier();
		}

		/**
		 * @param Modifier $modifier
		 */
		public function addModifier(Modifier $modifier)
		{
			$this->modifier->add($modifier);
		}

		/**
		 * @return MyList
		 */
		public function build()
		{
			$pagination = new MyList();

			for ($i = 0; $i < $this->numberOfPages; $i ++)
			{
				$page = clone $this->data;
				$page->put('page', $i + 1);

				$this->modifier->modify($page);

				$pagination->add($page);
			}

			return $pagination;
		}
	}
