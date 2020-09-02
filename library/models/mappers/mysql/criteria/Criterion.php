<?php
	/**
	 * This interface defines the methods which a Criterion consist of. Every methods returns an array with parts of an
	 * SQL query.
	 */
	interface Criterion
	{
		/**
		 * @return array Every item of this array carries a join string like ', posts' or ' LEFT JOIN posts'. Those
		 *               items will be concatenated from left to right in the FROM clause of an SQL statement.
		 */
		public function from();

		/**
		 * @return array Every item of this array carries a condition string like '0 < 10' or 'post.id = "myid"'.
		 *               Those items will be concatenated with an 'AND' in the WHERE clause of an SQL statement.
		 */
		public function where();

		/**
		 * @return array Every item of this array carries an attribute like 'post.id' or 'post.timestamp'. Those items
		 *               will be concatenated in the GROUP BY clause of an SQL statement.
		 */
		public function groupBy();

		/**
		 * @return array Every item of this array carries a condition string like 'COUNT(post.id) > 5'. Those items
		 *               will be concatenated in the HAVING clause of an SQL statement.
		 */
		public function having();
	}
