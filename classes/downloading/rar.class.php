<?php
/*
 * Process rar file types from download.
 *
 * Should really implement from a interface or base class to ensure function safety and availability.
 */
class rar
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
		 $rar_file = rar_open('example.rar') or die("Can't open Rar archive");
   /* $entries = rar_list($rar_file); 
    foreach ($entries as $entry) { 
        echo 'Filename: ' . $entry->getName() . "\n"; 
        $entry->extract('/dir/extract/to/'); 
    } 
    rar_close($rar_file); */
		$gz=rar_open($open_location);
                exit();
		if(is_resource($gz))
		{
			$contents=gzread($gz,filesize($open_location)*300);	//multiply encoded filesize by 300 to ensure reading of full deflated file
			if($contents)
			{
				$save_location = str_replace('/','\\',$save_location);
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
	
	public function getFile()
	{
		return $this->save_file;
	}
}

?>