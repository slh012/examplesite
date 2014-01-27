<?php

/**
 * Description of searchFormatResults
 *
 * @author sean
 */
class linkSearchFormatResults extends formatResults {

    protected $search;
    public $result_set;
    
    
    
    //put your code here
    public function  __construct(search $search) {
        $result_set = $search->getResultSet();
        if (!is_resource($result_set))
        {
             //   throw new Exception('Can\'t format results - no resultset set');
        }
        $this->result_set = $result_set;

        $this->search = $search;

        // get the first row out of the database for specific names and formatted data
        $r = mysql::i()->fetch_object($this->result_set);

        mysql::i()->seek($this->result_set, 0);
    }

   

    

    public function result()
    {
            $r = mysql::i()->fetch_object($this->result_set);
           
           
            if (is_object($r))
            {
                /*format the data*/
                $r->baseurl = config::get('baseurl');
               
               
            }

            return $r;
    }
}
?>
