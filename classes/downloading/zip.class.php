<?php
/*
 * Process ZIP file type from a download.
 */
class zip
{
	protected $move;
	protected $save_file = array();
	
	public function __construct(download $download_class)
	{
		$this->move = $download_class;
	}
	
	public function __destruct()
	{
		foreach ($this->save_file as $file)
		{
			unlink($file);
		}
	}
	
	public function get($file, $save_location)
	{
		$this->move->get($file, $save_location);
		
		$file = $this->move->getFile();
		
		$zip = zip_open($file);
		if (is_resource($zip))
		{
			while ($entry = zip_read($zip))
			{
				if (zip_entry_open($zip, $entry, 'r'))
				{
					$name = zip_entry_name($entry);
					$filesize = zip_entry_filesize($entry);
					$zip_save = dirname($file) . "/$name.txt";
					
					if (file_exists($zip_save))
					{
						unlink($zip_save);
					}

					if (file_put_contents($zip_save, zip_entry_read($entry, $filesize)))
					{
						zip_entry_close($entry);
						debug::output("Extracted $name from $file to $zip_save");
						
						$this->save_file[] = $zip_save;
					}
					else
					{
						zip_entry_close($entry);
						if ($filesize > 0)
						{
							throw new downloadException("Unable to save $zip_save");
						}
						else
						{
							// need to know if we have multiple files in the zip.
							debug::output("$zip_save is empty");
							$status = flatfileStatus::instance();
							$status->status(WARNING);
						}
					}
				}
				else
				{
					throw new downloadException("Unable to read zip entry ($file)");
				}
			}
		}
		else
		{
			throw new downloadException("Unable to open zip file ($file) - $zip");
		}
	}
	
	public function getFile()
	{
		if (count($this->save_file) == 1)
		{
			return $this->save_file[0];
		}
		else
		{
			return $this->save_file;
		}
	}
}
?>