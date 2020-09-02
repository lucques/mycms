<?php
	/**
	 * This is the interface for selecting users from a data source.
	 */
	interface SelectUsersMapper extends MapListMapper
	{
		/**
		 * @param boolean $selectRoles
		 */
		public function setSelectRoles($selectRoles);

		/**
		 * @return MyList
		 *   MyList(Map
		 *          {
		 *            id: string
		 *            nick: string
		 *            password: string
		 *            email: string
		 *            website: string
		 *            [role: Map
		 *                   {
		 *                     id: string
		 *                     title: string
		 *                     privileges: MyList(string)
		 *                   }]
		 *          })
		 */
		public function map();
	}
