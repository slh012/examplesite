<?php
try{
 
	include_once('header.inc.php');


	page::assign('title','PAGE TITLE UNSET');
        page::assignLoadFile('content', 'htmlblocks/404.html');
	
        include_once('footer.inc.php');
}
catch(dbException $e)
{
	debug::output($e->getMessage());

}
catch(Exception $e)
{
	debug::output($e->getMessage());

}
?>
