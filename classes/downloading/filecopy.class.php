<?php
/*
 * Allow downloading of a file via system filecopy.
 */
class filecopy extends download
{
	public function get($file,$save_location)
	{
		//parent::get($file,$save_location);
		
		$this->archive($save_location);
		
		if(!copy($file,$save_location))
		{
			throw new downloadException("Unable to copy $file to $save_location.");
		}
		
		$this->finish($save_location);
		
	}
}

?>