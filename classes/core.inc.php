<?php
/* Global site wide Constants */
define('LIVE', 1);
define('DEV', 2);



define('INBOX_IMPORTANT', 1);

if ( ! defined( "PATH_SEPARATOR" ) ) {
  if ( strpos( $_ENV[ "OS" ], "Win" ) !== false )
    define( "PATH_SEPARATOR", ";" );
  else define( "PATH_SEPARATOR", ":" );
}

error_reporting(0); 
ob_start();
session_start();

//require_once('session.inc.php');

function __autoload($class)
{
	if($fh=@fopen("{$class}.class.php",'r',true))
	{
		fclose($fh);
		require("{$class}.class.php");
	}elseif($fh=@fopen("{$class}.inc.php",'r',true))
	{
		fclose($fh);
		require("{$class}.inc.php");
	}
	else
	{
           // echo $class."<br/>";
		require("{$class}.php");
	}
}

?>