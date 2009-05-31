<?php
/**
 * User AUTHENTICATION library. Handles user login and logout, as well as secure
 * password hashing.
 *
 * Based on Kohana's AUTH library and Fred Wu's AuthLite library.
 *
 */
class Auth_Core {

	protected $config_name;
	protected $session;
	protected $config;
	protected $user_model;
	protected $columns;	

	/**
	 * Create an instance of Auth.
	 *
	 * @return  object
	 */
	public static function factory($config_name = 'auth')
	{
		return new Auth($config_name);
	}

	/**
	 * Return a static instance of Auth.
	 *
	 * @return  object
	 */
	public static function instance($config_name = 'auth')
	{
		static $instance;

		// Load the Auth instance
		empty($instance[$config_name]) and $instance[$config_name] = new Auth($config_name);

		return $instance[$config_name];
	}

	/**
	 * Loads Session and configuration options.
	 *
	 * @return  void
	 */
	public function __construct($config_name = 'auth')
	{
		$this->config_name     = $config_name;
		$this->session         = Session::instance();
		$this->config          = Kohana::config($config_name);
		$this->user_model      = $this->config['user_model'];
		$this->columns         = $this->config['columns'];
		
		// Clean up the salt pattern and split it into an array
		$this->config['salt_pattern'] = preg_split('/,\s*/', $this->config['salt_pattern']);
		
		Kohana::log('debug', 'Auth Library loaded');
	}

	/**
	 * Check if there is an active session.
	 *
	 * @return  boolean
	 */
	public function logged_in()
	{
		// Get the user from the session
		$user = $this->session->get($this->config['session_key']);
		
		$status = is_object($user) ? true : false;
		
		// Get the user from the cookie
		if ($status === FALSE AND $this->config['lifetime'])
		{
			if ( ($token = cookie::get('auth_'.$this->config_name.'_autologin')) )
			{
				$token = explode('.',$token);
			
				if (count($token) === 2 AND is_string($token[0]) AND is_numeric($token[1]))
				{
					// Search user on user ID and token. Because user ID is primary key, this is much faster than
					// searching on just the token.
					$user = ORM::factory($this->user_model)->where($this->columns['token'],$token[0])->find($token[1]);
					
					if ($user->loaded)
					{
						$status = true;
						$this->complete_login($user,TRUE);
					}
				}
			}
		}

		return $status === TRUE ? $user : FALSE;
	}
	
	public function get_user()
	{
		return $this->logged_in();
	}

	protected function complete_login($user, $remember = FALSE)
	{
		if ($remember === TRUE AND $this->config['lifetime'])
		{
			// Create token
			$token = text::random('alnum', 32);
			
			$user->{$this->columns['token']} = $token;
			
			// TODO: find a better way to store used_id in cookie
			cookie::set('auth_'.$this->config_name.'_autologin', $token . '.' . $user->primary_key_value, $this->config['lifetime']);
		}

		if(isset($this->columns['last_login']))
		{
			$user->{$this->columns['last_login']} = time();
		}
		
		if(isset($this->columns['logins']))
		{
			$user->{$this->columns['logins']}++;
		}

		$user->save();

		// Regenerate session (prevents session fixation attacks)
		$this->session->regenerate();
		
		$this->session->set($this->config['session_key'], $user);
	}

	/**
	 * Attempt to log in a user by using an ORM object and plain-text password.
	 *
	 * @param   string   username to log in
	 * @param   string   password to check against
	 * @param   boolean  enable auto-login
	 * @return  boolean
	 */
	public function login($username, $password, $remember = FALSE)
	{
		if (empty($password))
			return FALSE;

		$user = is_object($username) ? $username : ORM::factory($this->user_model)->where($this->columns['username'], $username)->find();
		
		$salt = $this->find_salt($user->{$this->columns['password']});

		if($this->hash_password($password, $salt) === $user->{$this->columns['password']})
		{
			$this->complete_login($user,$remember);
						
			return TRUE;
		}
		
		return FALSE;
	}

	/**
	 * Log out a user by removing the related session variables.
	 *
	 * @param   boolean  completely destroy the session
	 * @return  boolean
	 */
	public function logout($destroy = FALSE)
	{
		if (cookie::get('auth_'.$this->config_name.'_autologin'))
		{
			cookie::delete('auth_'.$this->config_name.'_autologin');
		}
		
		if ($destroy === TRUE)
		{
			// Destroy the session completely
			$this->session->destroy();
		}
		else
		{
			// Remove the user from the session
			$this->session->delete($this->config['session_key']);

			// Regenerate session_id
			$this->session->regenerate();
		}

		return ! $this->logged_in(NULL);
	}

	/**
	 * Creates a hashed password from a plaintext password, inserting salt
	 * based on the configured salt pattern.
	 *
	 * @param   string  plaintext password
	 * @return  string  hashed password string
	 */
	public function hash_password($password, $salt = FALSE)
	{
		if ($salt === FALSE)
		{
			// Create a salt seed, same length as the number of offsets in the pattern
			$salt = substr($this->hash(uniqid(NULL, TRUE)), 0, count($this->config['salt_pattern']));
		}

		// Password hash that the salt will be inserted into
		$hash = $this->hash($salt.$password);

		// Change salt to an array
		$salt = str_split($salt, 1);

		// Returned password
		$password = '';

		// Used to calculate the length of splits
		$last_offset = 0;

		foreach ($this->config['salt_pattern'] as $offset)
		{
			// Split a new part of the hash off
			$part = substr($hash, 0, $offset - $last_offset);

			// Cut the current part out of the hash
			$hash = substr($hash, $offset - $last_offset);

			// Add the part to the password, appending the salt character
			$password .= $part.array_shift($salt);

			// Set the last offset to the current offset
			$last_offset = $offset;
		}

		// Return the password, with the remaining hash appended
		return $password.$hash;
	}

	/**
	 * Perform a hash, using the configured method.
	 *
	 * @param   string  string to hash
	 * @return  string
	 */
	public function hash($str)
	{
		return hash($this->config['hash_method'], $str);
	}

	/**
	 * Finds the salt from a password, based on the configured salt pattern.
	 *
	 * @param   string  hashed password
	 * @return  string
	 */
	public function find_salt($password)
	{
		$salt = '';

		foreach ($this->config['salt_pattern'] as $i => $offset)
		{
			// Find salt characters, take a good long look...
			$salt .= substr($password, $offset + $i, 1);
		}

		return $salt;
	}

} // End Auth