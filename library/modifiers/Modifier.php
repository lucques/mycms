<?php
	/**
	 * This interface defines a way to modify Map objects systematically.
	 */
	interface Modifier
	{
		/**
		 * @param Map $map
		 */
		public function modify(Map $map);
	}
