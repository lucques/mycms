<?php
	/**
	 * This is the interface for updating a user from a data source.
	 */
	interface UpdateUserMapper
	{
		/**
		 * @param Map $post
		 *   Map
		 *   {
		 *     id: string
		 *     nick: string
		 *     password: string
		 *     email: string
		 *     website: string
		 *   }
		 */
		public function setUser(Map $user);

		/**
		 * 
		 */
		public function map();
	}
