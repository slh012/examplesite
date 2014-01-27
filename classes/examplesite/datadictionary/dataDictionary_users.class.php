<?php
/*
*
*representation of the table in the database
*
*/
class dataDictionary_users extends dataDictionary{
	
	
		
		public function __construct(){
			parent::__construct();	
			
		}//constructor
		
		
	
		public function fieldSpec(){	
		
			$this->fieldSpec['username'] = array('required'=>'Y',										
										'type'=>'STRING',												
										'size'=>'20');

		}
		