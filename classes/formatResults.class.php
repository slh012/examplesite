<?php

abstract class formatResults
{

	static public function f(formatResult $f)
	{
		$class = $f->getResultType();
		$format_class = "{$class}FormatResults";
		$ret_class =  new $format_class($f);
		if ($ret_class instanceof FormatResults)
		{
			return $ret_class;
		}

		throw new Exception("$format_class should be of type formatResults");
	}

	abstract public function result();
	//abstract public function searchData();
}
?>