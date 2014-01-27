<?php
/*
 * Allow downloading of file via FTP
 */
class ftp extends download
{

	private $ftp_connection_details = array();
	private $ftp;
	
	
	public function __construct($ftp_connection_details,$ftp_mode=FTP_BINARY)
	{
		parent::__construct();

		$this->ftp_connection_details = $ftp_connection_details;
		$this->ftp_mode = $ftp_mode;
		
		$this->ftp=ftp_connect($this->ftp_connection_details[0],$this->ftp_connection_details[4]);
			
		$ftp_login=ftp_login($this->ftp,$this->ftp_connection_details[1],$this->ftp_connection_details[2]);
		print("\n\nConnected To FTP\n\n");
		if(!is_resource($this->ftp) || !$ftp_login)
		{
			throw new downloadException("FAILED TO CONNECT TO {$this->ftp_connection_details[0]} FOR USER {$this->ftp_connection_details[1]} ({$this->ftp_connection_details[2]})  - {$_SERVER['SCRIPT_NAME']}");
		}
	}

	public function __destruct()
	{
		ftp_close($this->ftp);
	}


	public function put($file,$save_location){
		//$this->archive($save_location);

		if(!ftp_put($this->ftp,$save_location,$file,$this->ftp_mode))
		{
			throw new downloadException("FAILED TO PUT FILE {$file} TO STORE AT {$save_location} FROM {$this->ftp_connection_details[0]} - {$_SERVER['SCRIPT_NAME']}");
		}

		//$this->finish($save_location);
	}


	public function get($file,$save_location)
	{
		//ftp and return filename
		$this->archive($save_location);

		if(!ftp_get($this->ftp,$save_location,$file,$this->ftp_mode))
		{
			throw new downloadException("FAILED TO GET FILE {$file} TO STORE AT {$save_location} FROM {$this->ftp_connection_details[0]} - {$_SERVER['SCRIPT_NAME']}");
		}

		$this->finish($save_location);
	}

	public function get_directory_listing($dir='')
	{
		return (empty($dir))? ftp_nlist($this->ftp,$dir) : ftp_nlist($this->ftp,$dir);
	}

	public function change_directory($dir){
		if (ftp_chdir($this->ftp, $dir)) {
			echo "Current directory is now: " . ftp_pwd($this->ftp) . "\n";
		} else {
			echo "Couldn't change directory\n";
		}
	}

	public function make_directory($dir){
		if (ftp_mkdir($this->ftp, $dir)) {
			echo "successfully created $dir\n";
		} else {
			echo "There was a problem while creating $dir\n";
		}
		 
	}

}
?>