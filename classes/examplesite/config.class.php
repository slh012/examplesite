<?php

class config extends config_abstract
{
	private function __construct()
	{

	}

	static public function setup(){
 
            if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'){
               
                GLOBAL $is_ajax;
                $is_ajax = TRUE;
                self::$is_ajax = TRUE;
            }
            
            if ($_SERVER['SERVER_NAME'] == 'www.examplesite.com'){
                
                //LIVE               
               
                define('ENV', 'PROD');
                error_reporting(E_ALL ^ E_NOTICE);
                ini_set("display_errors", 0);
                ini_set("log_errors", 1);
                self::set('mysql_conn','127.0.0.1:USER:PASSWORD:examplesite');                                  
                self::set('baseurl','http://www.examplesite.com/');                 
                 
            }elseif($_SERVER['SERVER_NAME']=='examplesite.local'){
               
                //DEV
                
                define('ENV', 'DEV');
                error_reporting(E_ALL ^ E_NOTICE);
                ini_set("display_errors", 1);
                ini_set("log_errors", 0);
                self::set('mysql_conn','127.0.0.1:root::examplesite');
                self::set('baseurl','http://examplesite.local/');                
            }
          
            

            self::set('templates',array(
                    'header'=>'templates'.DIRECTORY_SEPARATOR.'header.html',
                    'left'=>'templates'.DIRECTORY_SEPARATOR.'left.html',                    
                    'footer'=>'templates'.DIRECTORY_SEPARATOR.'footer.html',
                    'top'=>'templates'.DIRECTORY_SEPARATOR.'top.html'
            ));
           
            
            
            self::set('main_template','templates'.DIRECTORY_SEPARATOR.'main.html');

            self::set('site_name','');
             
            self::set('admin_email','');
            self::set('twitter','https://twitter.com/');
            self::set('facebook','http://www.facebook.com/');
            self::set('googleplus','https://plus.google.com/');
            self::set('linkedin','');
            self::set('youtube','');
            self::set('rss','');
           



	}
}
?>