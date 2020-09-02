<?php
	/**
	 * This class modifies a map by generating a path to a comment on a post page.
	 */
	class ShowCommentPathModifier extends PathModifier
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
		 *     post: Map
		 *           {
		 *             id: string
		 *           }
		 *     id: string
		 *   }
		 */
		public function modify(Map $map)
		{
			$destination = $this->settings->get('controllers.showPost.destination');
			$destination = $this->replace('id', $map->get('post')->get('id'), $destination);

			$anchor = $this->settings->get('controllers.showPost.commentAnchor');
			$anchor = $this->replace('id', $map->get('id'), $anchor);

			$map->put($this->field, $this->settings->get('root') . $destination . $anchor);
		}
	}
