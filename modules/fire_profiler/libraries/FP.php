<?php

require_once MODPATH.'fire_profiler/vendor/FirePHPCore-0.3/lib/FirePHPCore/fb.php';

class FP
{

	/**
	 * Psuedo construct static class that interfaces with FirePHP getInstance
	 * 
	 * @return		object
	 */
	public static function i()
	{
		static $instance;
		
		// Create the instance if it does not exist, initialize self::init()
		empty($instance) and $instance = FirePHP::getInstance(TRUE);
	 
		return $instance;		
	}

	public static function env() 
	{
		// Add all built in profiles to event
		Event::add('fire-profiler.run', array('FP', 'benchmarks'));
		Event::add('fire-profiler.run', array('FP','database'));
		Event::add('fire-profiler.run', array('FP','session'));
		Event::add('fire-profiler.run', array('FP', 'post'));
		Event::add('fire-profiler.run', array('FP', 'get'));
		Event::add('fire-profiler.run', array('FP', 'cookies'));
			  	
		// Add profiler to page output automatically
		Event::add('system.display', array('FP', 'render'));
	}
	
	/**
	 * Disables the profiler for this page only.
	 * Best used when profiler is autoloaded.
	 *
	 * @return  void
	 */
	public static function disable()
	{
		// Removes itself from the event queue
		Event::clear('system.display', array('FP', 'render'));
	}
	
	/**
	 * Render the profiler. Output is added to FirePHP
	 *
	 * @param   boolean  return the output if TRUE
	 * @return  void|string
	 */	
	public static function render()
	{
		// If in production mode then exit
		if ((IN_PRODUCTION) AND (Kohana::config('fire_profiler.production_mode_off')))
			return FALSE;
	
		Event::run('fire-profiler.run', $this);			
	}
	
	/**
	 * Benchmark times and memory usage from the Benchmark library.
	 *
	 * @return  void
	 */	
	public static function database()
	{
		$queries = Database::$benchmarks;

		$total_time = $total_rows = 0;
		$table = array();
		$table[] = array('SQL Statement','Time','Rows');
		
		
		
		foreach ($queries as $query)
		{
			$table[]=array(str_replace("\n",' ',$query['query']), number_format($query['time'], 3), $query['rows']);

			$total_time += $query['time'];
			$total_rows += $query['rows'];
		}

		self::i()->fb(array(count($queries).' SQL queries took '.number_format($total_time,3).' seconds and returned '.$total_rows.' rows',  $table
		  ),FirePHP::TABLE);		
	}

	/**
	 * Database query benchmarks.
	 *
	 * @return  void
	 */	
	public static function benchmarks()
	{
		$benchmarks = Benchmark::get(TRUE);

		// Moves the first benchmark (total execution time) to the end of the array
		$benchmarks = array_slice($benchmarks, 1) + array_slice($benchmarks, 0, 1);
		
		$table = array();
		$table[] = array('Benchmark','Time','Memory');
		
		foreach ($benchmarks as $name => $benchmark)
		{
			// Clean unique id from system benchmark names
			$name = ucwords(str_replace(array('_', '-'), ' ', str_replace(SYSTEM_BENCHMARK.'_', '', $name)));

			$table[]= array($name, number_format($benchmark['time'], 3), number_format($benchmark['memory'] / 1024 / 1024, 2).'MB');
		}
		
		self::i()->fb(array(count($benchmarks).' benchmarks took '.number_format($benchmark['time'], 3).' seconds and used up '. number_format($benchmark['memory'] / 1024 / 1024, 2).'MB'.' memory',  $table
		  ), FirePHP::TABLE);			
	}
	
	/**
	 * Session data.
	 *
	 * @return  void
	 */	
	public static function session()
	{
	
		if (empty($_SESSION)) return;
			
		$table = array();
		$table[] = array('Session','Value');
		
		foreach($_SESSION as $name => $value)
		{
			if (is_object($value))
			{
				$value = get_class($value).' [object]';
			}

			$table[] = array($name, $value);

		}

		self::i()->fb(array('Session: '.count($_SESSION).' session variables',  $table  ),FirePHP::TABLE);		
	}
	
	/**
	 * Cookie data.
	 *
	 * @return  void
	 */	
	public static function cookies()
	{
		$table = array();
		$table[] = array('Cookies','Value');
			
		foreach($_COOKIE as $name => $value)
		{
			$table[] = array($name, $value);
		}	
		self::i()->fb(array('Cookies: '.count($_COOKIE).' cookies',  $table  ),FirePHP::TABLE);	
	}

	/**
	 * POST data.
	 *
	 * @return  void
	 */
	public static function post()
	{
		if (empty($_POST)) return;
			
		$table = array();
		$table[] = array('POST','Value');
			
		foreach($_POST as $name => $value)
		{
			$table[] = array($name, $value);
		}	
		self::i()->fb(array('Post: '.count($_POST).' POST variables',  $table  ),FirePHP::TABLE);		
	}
	
	/**
	 * GET data.
	 *
	 * @return  void
	 */
	public static function get()
	{
		if (empty($_GET)) return;
			
		$table = array();
		$table[] = array('GET','Value');
			
		foreach($_GET as $name => $value)
		{
			$table[] = array($name, $value);
		}	
		self::i()->fb(array('GET: '.count($_GET).' GET variables',  $table  ),FirePHP::TABLE);		
	}
	
	/**
	 * Intefacet to FirePHP log, just to make things easier
	 *
	 * @param       $data
	 * @param		$label
	 */
	public static function log($data, $label)
	{
		FB::log($data, $label);
	}
	
	/**
	 * Intefacet to FirePHP info, just to make things easier
	 *
	 * @param       $data
	 * @param		$label
	 */
	public static function info($data, $label)
	{
		FB::info($data, $label);
	}
	
	/**
	 * Intefacet to FirePHP warn, just to make things easier
	 *
	 * @param       $data
	 * @param		$label
	 */
	public static function warn($data, $label)
	{
		FB::warn($data, $label);
	}
	
	/**
	 * Intefacet to FirePHP error, just to make things easier
	 *
	 * @param       $data
	 * @param		$label
	 */
	public static function error($data, $label)
	{
		FB::error($data, $label);
	}
	
}
