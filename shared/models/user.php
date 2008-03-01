<?php defined('SYSPATH') or die('No direct script access.');

class User_Model extends ORM {

	// Relationships
	protected $has_and_belongs_to_many = array('roles');

	// User roles
	protected $roles = array();

	public function __construct($id = FALSE)
	{
		parent::__construct($id);

		if ($this->object->id != 0)
		{
			// Preload the roles, so that we can optimize has_role
			foreach($this->find_related_roles() as $role)
			{
				$this->roles[$role->id] = $role->name;
			} 
		}
	}

	public function __get($key)
	{
		// Allow roles to be fetched as array(id => name)
		if ($key === 'roles')
			return $this->roles;

		return parent::__get($key);
	}

	public function __set($key, $value)
	{
		static $auth;

		if ($key === 'password')
		{
			if ($auth === NULL)
			{
				// Load Auth, attempting to use the controller copy
				$auth = isset(Kohana::instance()->auth) ? Kohana::instance()->auth : new Auth();
			}

			// Use Auth to hash the password
			$value = $auth->hash_password($value);
		}

		parent::__set($key, $value);
	}

	/**
	 * Overloading the has_role method, for optimization.
	 */
	public function has_role($role)
	{
		// Don't mess with these calls, they are too complex
		if (is_object($role))
			return parent::has_role($role);

		// Make sure the role name is a string
		$role = (string) $role;

		if (ctype_digit($role))
		{
			// Find by id
			return isset($this->roles[$role]);
		}
		else
		{
			// Find by name
			return in_array($role, $this->roles);
		}
	}


	/**
	 * Allows a model to be loaded by username or email address.
	 */
	protected function where_key($id = NULL) {
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id)) {
			return valid::email($id) ? 'email' : 'username';
		}

		return parent::where_key($id);
	}


	public function get($id) {
		// DATE_FORMAT(users.registered_on,'%d.%m.%Y, %H:%i') AS registered_on,
		$query = Kohana::instance()->db->select('*')
			->from('users')
			->where('id', (int) $id)
			->limit(1)
			->get();

		if(count($query) == 1) {
			$result = $query->result();             
			return $result[0];            
		}

		return array();
	}
	
	public function get_all() {
		// DATE_FORMAT(users.registered_on,'%d.%m.%Y, %H:%i') AS registered_on,
		$query = Kohana::instance()->db->select('*')
			->from('users')
			->orderby('username','asc')
			->get();

		if(count($query) > 0) {            
			return $query->result();            
		}

		return array();
	}

} // End User_Model