<?php
/*
 * Abstract base class to provide support for handling file downloads
 */
abstract class download
{
	protected $save_file;
	protected $archive_file;
        public $error = false;

	public function __construct()
	{
		//
	}
	
	public function get($file,$save_location)
	{
		$this->finish($save_location);
	}
	
	protected function archive($old_file)
	{
		//$this->archive_file=$old_file."-".strtoupper(date('D',strtotime('yesterday')));
		$this->archive_file = $old_file . "-last";
		
		if(!rename($old_file,$this->archive_file))
		{
			debug::output("\n\nFailed to rename $old_file.\n");
		}
	}
	
	protected function finish($save_file)
	{
		$this->save_file=$save_file;
		
		//if(sha1_file($this->save_file)==sha1_file($this->archive_file))
		//{
			//throw new downloadException("File has not changed since last download.");
		//}
	}
	
	public function getFile()
	{
		return $this->save_file;
	}
	
	public function getArchiveFile()
	{
		return $this->archive_file;
	}
}
?>