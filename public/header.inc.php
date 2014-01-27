<?php
function getTime() { 
    $timer = explode( ' ', microtime() ); 
    $timer = $timer[1] + $timer[0]; 
    return $timer; 
}

     $start = getTime(); 


	set_include_path('../classes/examplesite'.PATH_SEPARATOR.'../classes/examplesite/datadictionary'.PATH_SEPARATOR.'../classes/datadictionary'.PATH_SEPARATOR.'../classes/downloading'.PATH_SEPARATOR.'../classes/forms'.PATH_SEPARATOR.'../classes/db'.PATH_SEPARATOR.'../classes/exceptions'.PATH_SEPARATOR.'../classes');
	include_once('init.inc.php');
              
       
         
