<?php
/*
 * Process GZ file types from download.
 *
 * Should really implement from a interface or base class to ensure function safety and availability.
 */
class gz
{
	protected $move;
	protected $save_file;
	
	public function __construct()
	{
		 
	}
	
	public function __destruct()
	{
		//unlink($this->save_file);
	}
	
        public function gzfilesize($filename) {
          $gzfs = FALSE;
          if(($zp = fopen($filename, 'r'))!==FALSE) {
            if(@fread($zp, 2) == "\x1F\x8B") { // this is a gzip'd file
              fseek($zp, -4, SEEK_END);
              if(strlen($datum = @fread($zp, 4))==4)
                extract(unpack('Vgzfs', $datum));
            }
            else // not a gzip'd file, revert to regular filesize function
              $gzfs = filesize($filename);
            fclose($zp);
          }
          return($gzfs);
        }
        
        public function get2($open_location,$save_location){
            $sfp = gzopen($open_location, "r");
            $fp = fopen($save_location, "w");

            while ($string = gzread($sfp, 4096)) {
                fwrite($fp, $string, strlen($string));
            }
            gzclose($sfp);
            fclose($fp);
        }
        
	public function get($open_location,$save_location)
	{
		//echo is_readable($open_location);
		$gz=gzopen($open_location,"r");
		if(is_resource($gz))
		{
                        $filesize = $this->gzfilesize($open_location);
			$contents=gzread($gz,$filesize);	//multiply encoded filesize by 300 to ensure reading of full deflated file
			if($contents)
			{
				//$save_location = str_replace('/','\\',$save_location);
				if(file_put_contents($save_location,$contents))
				{
					gzclose($gz);					
					
					$this->save_file=$save_location;
                                        
                                        
				}else{
                                   
                                    throw new downloadException("Unable to save csv entry ($save_location)");
                                }
                              
                               
			}
			else
			{
				throw new downloadException("Unable to read gz entry ($open_location)");
			}
		}
		else
		{
			throw new downloadException("Unable to open gz file ($open_location) - $gz");
		}
	}
	
        public function uncompress ($open_location,$save_location){
            $gz=gzopen($open_location,"r");
            if(is_resource($gz))
            {
                    $filesize = $this->gzfilesize($open_location);
                    $contents=gzread($gz,$filesize);	//multiply encoded filesize by 300 to ensure reading of full deflated file
                    if($contents)
                    {
                            //$bits = explode('.',$save_location);
                            //$gz_save   = $bits[0].'.csv';  
                        //debug::output("Saving file to: ".$save_location);
                            if(file_put_contents($save_location,$contents))
                            {
                                    gzclose($gz);
                                    //debug::output("Extracted $open_location to $gz_save");

                                    $this->save_file=$save_location;
                            }
                    }
                    else
                    {
                            throw new downloadException("Unable to read gz entry ($open_location)");
                    }
            }
            else
            {
                    throw new downloadException("Unable to open gz file ($open_location) - $gz");
            }
        }
        
        public function compress($open_location,$save_location){
            

            // Open the gz file (w9 is the highest compression)
            $fp = gzopen ($save_location, 'w9');

            // Compress the file
            gzwrite ($fp, file_get_contents($open_location));

            // Close the gz file and we are done
            gzclose($fp);
        }
        
	public function getFile()
	{
		return $this->save_file;
	}
}

?>