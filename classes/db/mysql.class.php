<?php

class mysql implements database_interface
{
	/*
	 * MySQL connection resource.
	 *
	 * @type resource
	 */
	protected $mysql;

	static public $instance;
	static public $instance_f = array();

	private function __construct()
	{

	}

	//factory
	static public function f($connection)
	{

        list($host,$user,$pass,$db)=explode(':',$connection);
        if(empty(self::$instance_f[$connection])){
                $i=new mysql;         
                $i->connect($host,$user,$pass,$db, true);
                self::$instance_f[$connection] = $i;
                self::$instance_f[$connection]->set_charset('utf8');
                return $i;
        }else{
          return self::$instance_f[$connection];
        }

	}

	//instance
	static public function i($connection='') 
	{
	
            if(!isset(self::$instance))
		{
		
                list($host,$user,$pass,$db)=explode(':',$connection);
				self::$instance=new mysql;
                       
				self::$instance->connect($host,$user,$pass,$db);
				self::$instance->set_charset('utf8');
                        
		}

		return self::$instance;
	}

	public function connect($host,$user,$pass,$db, $newlink = false)
	{
           
            
	
                $this->mysql=mysqli_connect($host,$user,$pass,$db);//or die("Error " . mysqli_error($link));
                  
                if(!$this->mysql->connect_error)
		{
		
                   // throw new dbException(mysqli_connect_error() ,mysqli_connect_errno() );
		}

		
	}

	public function escape_string($str)
	{
		return mysqli_real_escape_string($this->mysql, $str);
	}
        
        public function multi_query($sql, $num = '')
	{
            
            //self::log($sql);
            
            $c = 1;
            if (mysqli_multi_query($this->mysql, $sql)) {
                debug::output("Executing queries:");
		do {
                    /* store first result set */
                    if ($result = mysqli_store_result($this->mysql)) {
                        while ($row = mysqli_fetch_row($result)) {
                            printf("%s\n", $row[0]);
                        }
                        mysqli_free_result($result);
                    }
                    /* print divider */
                    if (mysqli_more_results($this->mysql)) { 
                        if($c == 1)printf("{$c} ");
                        $c++;
                        printf("{$c} ");
                    }
                } while (mysqli_next_result($this->mysql));
                
                if($num != '' && $c != $num){
                    //debug::output("SQL: $sql");
                    throw new dbException("The number of queries expected were not executed;\n".mysqli_error($this->mysql), 0);
                    
                    return false;
                }
                debug::output("");
                return $result;
                
                }else{
                    throw new dbException(mysqli_error($this->mysql)."\nSQL: $sql",mysqli_errno($this->mysql));
                    return false;
                }
	}
        
	public function query($sql)
	{

		$q=mysqli_query($this->mysql, $sql);
		if($q===false)
		{
			throw new dbException(mysqli_error($this->mysql)."\nSQL: $sql",mysqli_errno($this->mysql));
		}

		return $q;
	}

	public function unbuffered_query($sql)
	{
		$q = mysqli_unbuffered_query($sql, $this->mysql);
		if ($q === false)
		{
			throw new dbException(mysqli_error($this->mysql) . "\nSQL: $sql", mysqli_errno($this->mysql));
		}

		return $q;
	}
        
        public function set_charset($charset){
            $this->mysql->set_charset($charset);
        }
        
	public function last_error()
	{
		return mysqli_error($this->mysql);
	}
        
        public function prepare($sql)
	{
           
		return mysqli_prepare($this->mysql, $sql);
	}

        public function bind_param($r, $param1){
            return  $r->bind_param($param1);
        }


        public function fetch_row($result)
	{
		if (!is_resource($result))
		{
			//debug_print_backtrace();
		}
		return mysqli_fetch_row($result);
	}

	public function fetch_object($result)
	{
		if(!is_resource($result))
		{
			//debug_print_backtrace();
		}
		return $result->fetch_object();
	}

	public function fetch_array($result,$result_type=MYSQL_ASSOC)
	{
		if(!is_resource($result))
		{
		//	debug_print_backtrace();
		}

		return mysqli_fetch_array($result,$result_type);
	}

	public function last_id()
	{
		return mysqli_insert_id($this->mysql);
	}

	public function affected_rows()
	{
		return mysqli_affected_rows($this->mysql);
	}

	public function num_rows($r)
	{
		return mysqli_num_rows($r);
	}

	public function seek($r,$i)
	{
		return $r->data_seek($i);
	}

	public function free_result($r)
	{
		return mysqli_free_result($r);
	}
	public function close()
	{

		return mysqli_close($this->mysql);
	}
        
        public function errno(){
            return mysqli_errno($this->mysql);
            
        }
}
?>