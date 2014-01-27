<?php
/*
 * Process Z file type from a download.
 */
class z
{
	protected $move;
	protected $save_file;
	
	public function __construct(download $download_class)
	{
		$this->move = $download_class;
	}
	
	public function __destruct()
	{
		unlink($this->save_file);
	}
	
	public function get($file, $save_location)
	{
		$this->move->get($file, $save_location);
		
		$file = $this->move->getFile();
		
		if (file_exists($file))
		{
			debug::output(system("zcat '$file' > '$file.txt'"));
			$this->save_file = "$file.txt";
		}
		else
		{
			throw new downloadException("File doesn't exist - ($file)");
		}
	}
	
	public function getFile()
	{
		return $this->save_file;
	}
}

?>