<?php

require_once('core.inc.php');

    

config::setup();

/*
* Required Singlton for DB connection
*/
mysql::i(config::get('mysql_conn'));


/*
* Optional Factory for connecting to additional schemas
*/
//$db = mysql::f(config::get('mysql_conn'));
   

/*
* Automatically set the javascript files to their min counterparts when not in DEV mode
*/
$minjs = (ENV == 'DEV')? '':'.min';
page::assign('minjs',$minjs);

/*
* Setup/clear various common variables
*/
$baseurl = config::get('baseurl');//commonly used variable 
page::assign('baseurl', $baseurl);
page::assign('css','');
page::assign('javascript','');
page::assign('msg','');
page::assign('logged_in_console','');

/*
* Build the main templates
*/
page::newPage(config::get('main_template'));
foreach(config::get('templates') as $position => $filename) {

	page::assignLoadFile($position, $filename);
}


?>
