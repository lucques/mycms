<?php
	/**
	 * This class modifies a map by generating a path to the recent posts page.
	 */
	class RecentPostsPathModifier extends PathModifier
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
		 *     [page: int]
		 *   }
		 */
		public function modify(Map $map)
		{
			$destination = '';

			if ($map->containsKey('page') && $map->get('page') > 1)
			{
				$destination = $this->settings->get('controllers.recentPosts.destinationWithPage');
				$destination = $this->replace('page', $map->get('page'), $destination);
			}
			else
				$destination = $this->settings->get('controllers.recentPosts.destination');

			$map->put($this->field, $this->settings->get('root') . $destination);
		}
	}
