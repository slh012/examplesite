<?php
/*
 * Download file via HTTP
 */
class http extends download
{
	
	public function get($file,$save_location)
	{
		
		//parent::get($file,$save_location);
		
		$this->archive($save_location);
		
		$fh=fopen($file,'r');
		if(!is_resource($fh))
		{
			$cwd=getcwd();
			throw new downloadException("INVALID RESOURCE: $file ($cwd) - {$_SERVER['SCRIPT_NAME']}");
		}
		
		$wfh=fopen($save_location,'w');
		if(!is_resource($wfh))
		{
			$cwd=getcwd();
			throw new downloadException("INVALID RESOURCE: $save_location ($cwd) - {$_SERVER['SCRIPT_NAME']}");
		}
		
		if(!is_writable($save_location))
		{
			$cwd=getcwd();
			throw new downloadException("UNABLE TO WRITE TO FILE: $save_location ($cwd) - {$_SERVER['SCRIPT_NAME']}");
		}
		
		while(!feof($fh))
		{
			fwrite($wfh,fgets($fh));
		}
		fclose($fh);
		fclose($wfh);
		
		$this->finish($save_location);
	}
}
?>