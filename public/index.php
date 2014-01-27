<?php
try{

 
    
	include_once('header.inc.php');

	
	page::assign('title','PAGE TITLE UNSET');
        //page::assignLoadFile('template', 'templates/16-8.html');
	page::assignLoadFile('content', 'htmlblocks/index.html');
        
        
        //$ua = new userActivity();
        //$list = $ua->listRecipes();
        //page::assign('list_of_activities',$list);
 

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