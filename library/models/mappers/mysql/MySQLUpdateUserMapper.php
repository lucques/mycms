<?php
	/**
	 * This class implements the UpdateUserMapper interface for a MySQL database.
	 */
	class MySQLUpdateUserMapper extends AbstractMySQLMapper implements UpdateUserMapper
	{
		protected $user;

		/**
		 * @param Database $database
		 * @param Map $user
		 */
		public function __construct(Database $database, Map $user)
		{
			parent::__construct($database);

			$this->user = $user;
		}

		public function setUser(Map $user)
		{
			$this->user = $user;
		}

		public function map()
		{
			$sql  = 'UPDATE ';
			$sql .=   $this->relation('users') . ' ';
			$sql .= 'SET ';
			$sql .=   'nick = "' . $this->escape($this->user->get('nick')) . '", ';
			$sql .=   'password = "' . $this->escape($this->user->get('password')) . '", ';
			$sql .=   'email = "' . $this->escape($this->user->get('email')) . '", ';
			$sql .=   'website = "' . $this->escape($this->user->get('website')) . '" ';
			$sql .= 'WHERE ';
			$sql .=   'id = "' . $this->escape($this->user->get('id')) . '"';

			$this->database->query($sql);
		}
	}
