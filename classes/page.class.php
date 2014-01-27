<?php

abstract class page
{
	static protected $template;
	static protected $variables = array();
	static protected $files = array();
	static protected $assignLoop = array();
	static protected $priority = array(
			'0'=>'H',
			'1'=>'M',
			'2'=>'L',
		);

	private function __construct()
	{

	}

	private function __clone()
	{

	}
 

	static public function newPage($page)
	{
		if (!file_exists(getcwd().DIRECTORY_SEPARATOR.$page))
		{
			throw new ftException("Template file ($page) doesn't exist at: ".getcwd().DIRECTORY_SEPARATOR.$page);
		}

		self::$template = $page;
	}

	static public function endPage()
	{

		
                foreach (self::$variables as $content => $value)
		{
		 $$content = $value;
		}

		foreach(self::$priority as $posn => $priority){
			if(!empty(self::$files[$priority])){
				foreach (self::$files[$priority] as $name => $file)
				{

					ob_start();
                                    
					include(getcwd().DIRECTORY_SEPARATOR.$file);
					$$name = ob_get_contents();
					ob_end_clean();

					

					

					$$name = str_replace(' & ',' &amp; ',$$name);
					
				}
			}
		}


		include(getcwd().DIRECTORY_SEPARATOR.self::$template);
	}

	static public function assign($variable, $value)
	{
		self::$variables[$variable] = $value;
                
	}

	static public function assignCSS($value)
	{
		$baseurl = config::get('baseurl');
		self::$variables['stylesheet'] .= '<link rel="stylesheet" type="text/css" href="'.$baseurl.'a/css/'.$value.'.css" media="screen" />';
	}

	static public function assignJS($value)
	{
		$baseurl = config::get('baseurl');
		self::$variables['javascript'] .= '<script type="text/javascript" src="'.$baseurl.'a/js/'.$value.'.js"></script>';
	}

	static public function assignLoadFile($value, $file, $priority='L')
	{
		if (!file_exists(getcwd().DIRECTORY_SEPARATOR.$file))
		{
			throw new fileException("File ($file) doesn't exist. at ".getcwd().DIRECTORY_SEPARATOR.$file);
		}
		self::$files[$priority][$value] = $file;
	}

	static public function assignFrag($variable, $file, $values, $priority = 'H')
	{
		foreach($values as $key => $value)
		{
			self::$variables[$key] = $value;
		}
		self::$files[$priority][$variable] = $file;
	}

	/*static public function assignVariable($variable, $values){
        foreach ($values as $name => $value)
		{
			$$name = $value;
		}


    }*/

	static public function assignLoop($variable, $file, $values, $return=false)
	{
		foreach ($values as $name => $value)
		{
			$$name = $value;
		}

		if (is_array($file))
		{
			$filename = $file = $file[0];
		}
		else
		{
			$filename = getcwd() . '/' . $file;
		}

		ob_start();
		if(is_file($filename))
		{
			include($filename);
		}
		else
		{
			echo $file;
		}
		$content = ob_get_contents();
		ob_end_clean();


		if(empty($variable))
		{
			return $content;
		}

		if (empty(self::$variables[$variable]))
		{
			self::$variables[$variable] = '';
		}

		self::$variables[$variable] .= $content;
	}

        static public function fragment($fragment, $fields){
            foreach ($fields as $key => $value)
            {
                $$key = $value;
            }
            

            ob_start();

                include(getcwd().DIRECTORY_SEPARATOR.$fragment);
                $html = ob_get_contents();

            ob_end_clean();

            return $html;
        }
}

?>