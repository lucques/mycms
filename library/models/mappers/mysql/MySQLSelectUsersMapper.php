<?php
	/**
	 * This class implements the SelectUsersMapper interface for a MySQL database.
	 */
	class MySQLSelectUsersMapper extends MySQLMapListMapper implements SelectUsersMapper
	{
		protected $selectRoles;
		protected $criterion;

		/**
		 * @param Database $database
		 */
		public function __construct(Database $database)
		{
			parent::__construct($database);

			$this->selectRoles = false;
			$this->criterion = new CompositeCriterion();
		}

		public function setSelectRoles($selectRoles)
		{
			$this->selectRoles = $selectRoles;
		}

		public function map()
		{
			$users = new MyList();

			$sql  = 'SELECT ';
			$sql .=   'user.id, ';
			$sql .=   'user.nick, ';
			$sql .=   'user.password, ';
			$sql .=   'user.email, ';
			$sql .=   'user.website';

			if ($this->selectRoles)
			{
				$sql = $sql .  ', role.id AS role_id, ';
				$sql = $sql .    'role.title AS role_title, ';
				$sql = $sql .    'role.privileges AS role_privileges';
			}

			$sql .= ' FROM ';
			$sql .=   $this->relation('users') . ' AS user';

			if ($this->selectRoles)
			{
				$criterion = new ModifiableCriterion();
				$criterion->addToFrom(' JOIN ' . $this->relation('roles') . ' AS role ' .
				                         'ON user.role_id = role.id');

				$this->criterion->add($criterion);
			}

			$sql .=   implode('', $this->criterion->from()) . ' ';

			$where = $this->criterion->where();

			if (count($where) > 0)
				$sql .= 'WHERE ' . implode(' AND ', $where) . ' ';

			$groupBy = $this->criterion->groupBy();

			if (count($groupBy) > 0)
				$sql .= 'GROUP BY ' . implode(', ', $groupBy) . ' ';

			$having = $this->criterion->having();

			if (count($having) > 0)
				$sql .= 'HAVING ' . implode(' AND ', $having) . ' ';

			$iterator = $this->database->query($sql);
			$iterator->skip($this->offset);

			for ($i = 0; ($this->limit == -1 || $i < $this->limit) && $iterator->hasNext(); $i ++)
			{
				$tuple = $iterator->next();

				$user = new Map();
				$user->put('id', $tuple['id']);
				$user->put('nick', $tuple['nick']);
				$user->put('password', $tuple['password']);
				$user->put('email', $tuple['email']);
				$user->put('website', $tuple['website']);

				if ($this->selectRoles)
				{
					$role = new Map();
					$role->put('id', $tuple['role_id']);
					$role->put('title', $tuple['role_title']);
					$role->put('privileges', MyList::fromArray(explode(',', $tuple['role_privileges'])));

					$user->put('role', $role);
				}

				$this->modifier->modify($user);

				$users->add($user);
			}

			return $users;
		}

		/**
		 * @param UserCriterion $criterion
		 */
		public function addCriterion(UserCriterion $criterion)
		{
			$this->criterion->add($criterion);
		}
	}
