<?php

	class formGenerator{

		private $docLoader;
		private $dataDic;
		//protected $utils;
		public $form = array();


		public $html = '';

		public $name = '';
		public $value = '';
		public $method = '';
		public $action = '';
		public $id = '';

		public $form_messages = '';

		public $formSpec = array();
		public $submit = array();


		public $searchType = '';

		public $notice ='';

		protected $noOfGuestsList = array();
		protected $dayList = array();
		protected $monthList = array();
		protected $completeTitleList = array();
		protected $regularTitleList = array();
		protected $genderList = array();
		protected $countryList = array();

		protected $cardTypeList = array();
		protected $errors = array();
		protected $completed = array();

		protected $dictionaryList;

		public function __construct ($errors, $completed){



		//	$this->form = array_merge($this->form,$pagefill);

			$this->errors = $errors;
			$this->completed = $completed;
			$secureBaseurl = config::get('baseurl');
			$this->notice = "<img src=\"{$secureBaseurl}a/i/icons/required_icon.jpg\" alt=\"Required\" width=\"16\" height=\"16\"/>";

			//$this->html = '* Required Information.';
			if(!empty($this->errors))$this->html .= '<br/><span style="color:red;">Please complete all required fields.<br/>This icon '.$this->notice.' indicates fields you need to complete.</span><br/><br/>';


			//allows us to load a dictionary or use predefined dictinaries
			$this->dictionaryList =  ($this->dictionaryList) ?  $this->dictionaryList:$this->config->tableList;

			$this->loadLists();
		}//constructor

		public function loadDictionaries($dictionaryList){
			if(!is_array($dictionaryList)){
				$this->errors['dictionaryList'] = 'You need to pass an array of dictionaries';
				return false;
			}else{
				$this->dictionaryList = $dictionaryList;
			}

		}//loadDictionaries

		private function loadLists(){

			$this->dayList = utils::days();//get day list array
			$this->monthList = utils::months();//month list array

		//	$this->completeTitleList = utils::title();//title list array

			$this->regularTitleList = utils::regularTitle();//title list array
		//	$this->genderList = utils::gender();//gender list array
		//	$this->countryList = utils::country();//gender list array

			$this->cardTypeList = utils::cardTypes();//get day list array
			$this->noOfGuestsList = array('1'=>'1',
								'2'=>'2',
								'3'=>'3',
								'4'=>'4');

		$this->CallTimeList = array('A.S.A.P'=>'A.S.A.P',
									'No preference'=>'No preference',
									'Morning 9 - 12am'=>'Morning 9 - 12am',
									'Lunchtime 12 - 2pm'=>'Lunchtime 12 -2pm',
									'Afternoon 2 - 5pm'=>'Afternoon 2 - 5pm',
									'Evening 5 - 9pm'=>'Evening 5 - 9pm',

									);


		}//loadLists


		protected function invalidData($no=''){



				//$tableList =  $this->config->tableList;

					//get a list of all tables
					foreach($this->dictionaryList as $table){

						//pickup each table
						//$fieldSpec = $this->dataDic->$table();
						$DataDictionary = 'dataDictionary_'.$table;
						$dataDic = new $DataDictionary;
						$fieldSpec = $dataDic->fieldSpec();

							//blank out all holders
						foreach($fieldSpec as $field=>$spec){

							//if($this->form['e_'.$field.$no] != $this->notice){

									$this->form['e_'.$field.$no] = '';

							//}
							//if($this->form['e_'.$field.'_p'] != $this->notice){

									$this->form['e_'.$field.'_p'] = '';

							//}

						}

					}//foreach

					if(!empty($this->errors)){
					//loop through completed data
						foreach($this->errors as $key=>$value){
							//replace empty positions with values

								$this->form['e_'.$key] =$this->notice;


								$this->form['e_'.$key.'_p'] = $this->notice;
						}//foreach

					}//if errors


		}//areFieldsComplete

		protected function invalidDataMessages( $no=''){
		//print"<pre>";
			//$tableList =  $this->config->tableList;

					//get a list of all tables
					foreach($this->dictionaryList as $table){

						//pickup each table
						//$fieldSpec = $this->dataDic->$table();
						$DataDictionary = 'dataDictionary_'.$table;
						$dataDic = new $DataDictionary;
						$fieldSpec = $dataDic->fieldSpec();

							//blank out all holders
						foreach($fieldSpec as $field=>$spec){

							//if($this->form['m_'.$field.$no] != $this->notice){

								//$this->form['m_'.$field] = '';
								$this->form['m_'.$field.$no] = '';
								if(empty($no)){
									$this->form['m_'.$field] = '';
									//$this->form['p_m_'.$field] = '';
								}


							//}
						}

					}//foreach
				if(!empty($this->errors)){
					//loop through completed data
					foreach($this->errors as $key=>$value){

						//replace empty positions with values
						$this->form['m_'.$key.$no] = '<span style="color:red;">'.$value.'/<span>';
						$this->form['m_'.$key] = '<span style="color:red;">'.$value.'</span>';
						//$this->form['p_m_'.$key] = $value.'<br/>';
					}//foreach

				//print_r($this->form);
			}//if errors
		unset($no);
		}//invalidDataMessages

		protected function autoComplete( $no=''){


				//$tableList =  $this->config->tableList;

					//get a list of all tables
					foreach($this->dictionaryList as $table){

						//pickup each table
						//$fieldSpec = $this->dataDic->$table();
						 $DataDictionary = 'dataDictionary_'.$table;
						$dataDic = new $DataDictionary;
						$fieldSpec = $dataDic->fieldSpec();

							//blank out all holders
							foreach($fieldSpec as $field=>$spec){

								//	$this->form[$field] = '';


									if(empty($no)){

										$this->form[$field] = '';
										$this->form[$field.'_p'] = '';
									}else{

										$this->form[$field.'_p'] = '';
										$this->form[$field.$no] = '';
									}
							}//foreach

					}//foreach

				if(!empty($this->completed)){
					//loop through completed data
					foreach($this->completed as $key=>$value){
						//	chop off last num
						$truncated = utils::removeLastNum($key);
						//replace empty positions with values
						$this->form[$key] = $value;
					}//foreach


			}//if completed
				//print"<pre>";
				//print_r($this->form);
		unset($no);
		}//autoComplete

		public function submit(){

                        $this->html .= '<div align="center">';

                        $this->html .= file_get_contents('htmlblocks/forms/submit.html');
                        $this->html .= '</div>';
                        $this->html .= '</form>';


			$keys=array_keys($this->submit);

			array_walk($keys,create_function('&$v','$v="%".$v."%";'));

			$this->html=str_replace($keys,$this->submit,$this->html);



		}//submit

		public function hiddenFields($name, $value){

                        $fragment = 'htmlblocks/forms/hidden.html';

			$fields['name'] = $name;
			$fields['value'] = $value;


                        $this->html .=page::fragment($fragment, $fields);

		}//hiddenFields

		protected function setFormParameters(){

                    //$tableList =  $this->config->tableList;

                    //get a list of all tables
                    foreach($this->dictionaryList as $table){

                            //pickup each table
                            //$fieldSpec = $this->dataDic->$table();
                            $DataDictionary = 'dataDictionary_'.$table;
                            $dataDic = new $DataDictionary;
                            $fieldSpec = $dataDic->fieldSpec();

                                    //blank out all holders
                                    foreach($fieldSpec as $field=>$spec){

                                            $this->form[$field.'_size'] = $spec['size'];
                                            $this->form[$field.'_rows'] = $spec['rows'];
                                            $this->form[$field.'_cols'] = $spec['cols'];
                                    }//foreach

                    }//foreach

		}//setFormParameters

		public function form($formFragment, $customer){



			$holder = file_get_contents($formFragment);


			$no = 1;
			while($no <= $customer){

				/***** custom details *******/



				/***** custom details *******/
				$this->autoComplete($no);
				$this->invalidData($no);
				$this->invalidDataMessages($no);

				$this->setFormParameters();
				//$this->dropdowns($completed);
				$this->form['no'] = $no;

				$this->html .= $holder;


				$keys=array_keys($this->form);

				array_walk($keys,create_function('&$v','$v="%".$v."%";'));

				$this->html=str_replace($keys,$this->form,$this->html);
				$this->html=str_replace($keys,$this->form,$this->html);//stopped working properly


				$no++;

			}//while



			return $this->html;


		}//form



		public function noOfGuests($formFragment){



			$holder = file_get_contents($formFragment);




				/***** custom details *******/



				/***** custom details *******/
				$this->autoComplete($no);
				$this->invalidData($no);
				$this->invalidDataMessages($no);

				$this->setFormParameters();
				//$this->dropdowns($completed);




				$this->form['noOfGuestsList'] =  utils::makeOptions($this->noOfGuestsList, $this->completed['noOfGuests']);




				$this->html .= $holder;


				$keys=array_keys($this->form);

				array_walk($keys,create_function('&$v','$v="%".$v."%";'));

				$this->html=str_replace($keys,$this->form,$this->html);
				$this->html=str_replace($keys,$this->form,$this->html);//stopped working properly






			return $this->html;


		}//guests


		private function dropdowns( $completed,$no=''){

			$passengers = array('1'=>'1',
								'2'=>'2',
								'3'=>'3',
								'4'=>'4');



			$this->form['adultsdrop'] =  utils::makeOptions($passengers, $completed['adults']);
			$this->form['infantsdrop'] =  utils::makeOptions($passengers, $completed['infants']);
			$this->form['childrendrop'] =  utils::makeOptions($passengers, $completed['children']);
			$this->form['seniorsdrop'] =  utils::makeOptions($passengers, $completed['seniors']);


		}//dropdowns



		public function form_messages($form_messages, $errors, $customer){



			$this->html .= '<div align="center">';

			$fh = fopen($form_messages,"r");
			$holder = fread($fh,filesize($form_messages));


			$no = 1;
			while($no <= $customer){

				$this->form['no'] = $no;
				$this->invalidDataMessages($errors, $no);

				$this->html .= $holder;

				$keys=array_keys($this->form);

				array_walk($keys,create_function('&$v','$v="%".$v."%";'));

				$this->html=str_replace($keys,$this->form,$this->html);
				$no++;

			}//while
			$this->html .= '</div>';

		}//form_messages

		public function setup(){
			$this->html .= "<form  action=\"{$this->formSpec['action']}\" method=\"{$this->formSpec['method']}\" name=\"{$this->formSpec['name']}\" id=\"{$this->formSpec['id']}\" onsubmit='{$this->formSpec['onsubmit']}'>";
		}//setup

		public function prebook($formFragment, $customer, $errors, $completed){


			$fh = fopen($formFragment,"r");
			$holder = fread($fh,filesize($formFragment));



			$this->html = '<form action="'."{$this->formSpec[action]}".'.php" method="'."{$this->formSpec[method]}".'" id="'."{$this->formSpec[formID]}".' ">';



			$no = 1;
			while($no <= $customer){

				/***** custom details *******/

				//$this->customDetails_prebook2006($no);

				/***** custom details *******/
				$this->autoComplete($completed, $no);
				$this->invalidData($errors, $no);
				$this->invalidDataMessages($errors, $no);

				$this->setFormParameters();
				$this->dropdowns($completed);
				$this->form['no'] = $no;
				$this->html .= $holder;


				$keys=array_keys($this->form);

				array_walk($keys,create_function('&$v','$v="%".$v."%";'));

				$this->html=str_replace($keys,$this->form,$this->html);

				 //%Gender%SeqNumber%_r%
				// $value.$SeqNumber.'_r'
				//'e_'.$field.$no
				//%e_%no%field%
				$no++;

			}//while

			$this->html .= '<div align="center">';
			$fh = fopen('htmlblocks/submit.htm',"r");
			$this->html .= fread($fh,filesize('htmlblocks/submit.htm'));
			$this->html .= '</div>';

			$this->form['name'] = $this->formSpec['name'];
			$this->form['value'] = $this->formSpec['value'];
			$this->form['id'] = $this->formSpec['id'];

			$keys=array_keys($this->form);

			array_walk($keys,create_function('&$v','$v="%".$v."%";'));

			$this->html=str_replace($keys,$this->form,$this->html);

			$this->html .= '</form>';


			return $this->html;

		}//customer

	}//FormBuilder

?>