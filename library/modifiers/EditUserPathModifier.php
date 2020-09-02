<?php
	/**
	 * This class modifies a map by generating a path to a page to edit a user.
	 */
	class EditUserPathModifier extends PathModifier
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
		 *     id: string
		 *   }
		 */
		public function modify(Map $map)
		{
			$destination = $this->settings->get('controllers.editUser.destination');
			$destination = $this->replace('id', $map->get('id'), $destination);

			$map->put($this->field, $this->settings->get('root') . $destination);
		}
	}