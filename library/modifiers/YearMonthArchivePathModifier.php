<?php
	/**
	 * This class modifies a map by generating a path to a year-month archive.
	 */
	class YearMonthArchivePathModifier extends PathModifier
	{
		/**
		 * @param Map $settings
		 * @param string $field
		 */
		public function __construct(Map $settings, $field)
		{
			parent::__construct($settings, $field);
		}

		/**
		 * @param Map $map
		 *   Map
		 *   {
		 *     year: int
		 *     month: int
		 *     [page: int]
		 *   }
		 */
		public function modify(Map $map)
		{
			$destination = '';

			if ($map->containsKey('page') && $map->get('page') > 1)
			{
				$destination = $this->settings->get('controllers.yearMonthArchive.destinationWithPage');
				$destination = $this->replace('page', $map->get('page'), $destination);
			}
			else
				$destination = $this->settings->get('controllers.yearMonthArchive.destination');

			$destination = $this->replace('year', $map->get('year'), $destination);
			$destination = $this->replace('month', TimestampFormatter::format($map, '%monthWithLeadingZero%'), $destination);

			$map->put($this->field, $this->settings->get('root') . $destination);
		}
	}
