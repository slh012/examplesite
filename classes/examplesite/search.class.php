<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of searchclass
 *
 * @author sean
 */
class linkSearch extends search {
    
    public $result_set;
    public $found_rows;
    private $search_data = array();
    
    private $filter_type;
    
    public function  __construct($search_data) {
        $this->search_data = $search_data;

        foreach($this->search_data as $key=>$value){
            $key = strtolower($key);
                       
            
            switch($key){
               
                
                case"FIELD NAME":
                    $this->query_params[] = "FIELD NAME = '$value'";
                    $this->addSearchParam('FIELD NAME', $value);
                break;           
                              
                
                default;
                    
            }
        }
        
    }

    
    
    public function query($query=''){
      
        if (!empty($this->query_params))
        {
            $params = ' where ' . join(' and ', $this->query_params);
            $sql = "select SQL_CALC_FOUND_ROWS *, $params FROM TABLE NAME $this->order_by $this->limit";
                       
        }
        else
        {
             $sql = "select SQL_CALC_FOUND_ROWS * FROM TABLE NAME $this->order_by  $this->limit";                        
                         
        }
       
        $this->result_set = mysql::i()->query($sql);
        $q = mysql::i()->query("select found_rows() as found_rows");
        $r = mysql::i()->fetch_object($q);
        
        $this->found_rows = $r->found_rows;
    }

    public function getResultSetNums(){
        $start = number_format($this->limit_start + 1,0,'.',',');
	   $end = number_format($this->limit_start + mysql::i()->num_rows($this->result_set),0,'.',',');
	   return array('start' => $start, 'end' => $end);
    }

    public function addSearchParam($name, $value){
        $this->search_params[$name] = htmlspecialchars($value, ENT_QUOTES);
    }

    public function getResultType(){
        return get_class($this);
    }

    public function getResultSet(){
        
        return $this->result_set;
        
        if (is_resource($this->result_set))
            {
                    return $this->result_set;
            }
            else
            {
                    return array();
            }
    }
}
?>