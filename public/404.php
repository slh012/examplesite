<?php
try{
 
	include_once('header.inc.php');

	page::assign('header1','Link Liability');
	page::assign('title','Link Liability');
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