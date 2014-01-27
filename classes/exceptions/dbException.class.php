<?php

class dbException extends Exception
{
	public function __construct($m, $c = 0)
	{
            print "\nDatabase Error: ";
            parent::__construct($m,$c);
              
	}
}

?>