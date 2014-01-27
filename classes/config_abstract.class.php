<?php

abstract class config_abstract
{
	static public $config = array();
        static public $is_ajax = FALSE;

	abstract static public function setup();

	/* LIVE or DEV */
	static public function site_status($status)
	{
		self::set('site_status', $status);
	}


 


	static public function set($name, $value)
	{
		self::$config[$name] = $value;
	}

	static public function get($name)
	{
		if (array_key_exists($name, self::$config))
		{
			return self::$config[$name];
		}
		return false;
	}

	static public function dump()
	{
		if (DEV == self::get('site_status'))
		{
			echo '<pre style="text-align: left">';
			print_r(self::$config);
			echo '</pre>';
		}
	}
}
?>