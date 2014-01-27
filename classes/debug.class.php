<?php

class debug
{
	private function __construct()
	{

	}

	private function __clone()
	{

	}

	static public function output($str)
	{
		  $output = config::get('output_to_screen');
                   echo "$str\n";
	}

	static public function backtrace()
	{
		$output = config::get('output_to_screen');
      if($output==true){
        debug_print_backtrace();
		    echo "\n";
      }

	}
}
?>