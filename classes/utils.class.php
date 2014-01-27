<?php

class utils {
    //put your code here

    static public $ip = false;

       static public  function cleanElements($html){
  
  $search = array (
         "'<script[^>]*?>.*?</script>'si",  //remove js
          "'<style[^>]*?>.*?</style>'si", //remove css 
          "'<head[^>]*?>.*?</head>'si", //remove head
         "'<link[^>]*?>.*?</link>'si", //remove link
         "'<object[^>]*?>.*?</object>'si"
                      ); 
        $replace = array ( 
              "",
                                   "",
              "",
              "",
              ""
                      );                 
  $str = preg_replace ($search, $replace, $html);
  
  return $str;
 }
   

    //To replace all types of whitespace with a single space
    static public function replaceWhitespace($str) {
        $result = $str;
        foreach (array(
        "  ", " \t",  " \r",  " \n",
        "\t\t", "\t ", "\t\r", "\t\n",
        "\r\r", "\r ", "\r\t", "\r\n",
        "\n\n", "\n ", "\n\t", "\n\r",
        ) as $replacement) {
        $result = str_replace($replacement, $replacement[0], $result);
        }
        return $str !== $result ? replaceWhitespace($result) : $result;
    }
    
    static public function ping($host)
    {
        //doesnt work
            exec(sprintf('ping -c 1 %s', escapeshellarg($host)), $res, $rval);
            if($rval >= 0){
                return true;
            }else{
                return false;
            }
            
    }
    
     static public function isSiteAvailable($url)
       {
         //doesnt work
               //check, if a valid url is provided
               if(!filter_var($url, FILTER_VALIDATE_URL))
               {
                       //return 'URL provided wasn\'t valid';
                   return false;
               }

               //make the connection with curl
               $cl = curl_init($url);
               curl_setopt($cl,CURLOPT_CONNECTTIMEOUT,10);
               curl_setopt($cl,CURLOPT_HEADER,true);
               curl_setopt($cl,CURLOPT_NOBODY,true);
               curl_setopt($cl,CURLOPT_RETURNTRANSFER,true);

               //get response
               $response = curl_exec($cl);

               curl_close($cl);

               if ($response) return true;//return 'Site seems to be up and running!';

               return false;//'Oops nothing found, the site is either offline or the domain doesn\'t exist';
       }
    
    static public function jarvisWidgetEditbox(){
       return  '<div class="jarviswidget-editbox">
            <div>
                <label>Title:</label>
                <input type="text" />
            </div>
            <div>
                <label>Styles:</label>
                <span data-widget-setstyle="purple" class="purple-btn"></span>
                <span data-widget-setstyle="navyblue" class="navyblue-btn"></span>
                <span data-widget-setstyle="green" class="green-btn"></span>
                <span data-widget-setstyle="yellow" class="yellow-btn"></span>
                <span data-widget-setstyle="orange" class="orange-btn"></span>
                <span data-widget-setstyle="pink" class="pink-btn"></span>
                <span data-widget-setstyle="red" class="red-btn"></span>
                <span data-widget-setstyle="darkgrey" class="darkgrey-btn"></span>
                <span data-widget-setstyle="black" class="black-btn"></span>
            </div>
        </div>';
    }
    
    static public function normalize($value, $max, $min, $top, $bottom){
        return $bottom+($value-$min)*($top-$bottom)/($max-$min);
    }
    
    static public function HexToRGB($hex){
        $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
        
        return array('r'=>$r,'g'=>$g,'b'=>$b);

    }
    
    static public function RGBToHSLOld($r, $g, $b){
        
        $var_r = $r;
        $var_g = $g;
        $var_b = $b;
        
        $var_min = min($var_r,$var_g,$var_b);
        $var_max = max($var_r,$var_g,$var_b);
        $del_max = $var_max - $var_min;

        $l = ($var_max + $var_min) / 2;

        if ($del_max == 0)
        {
                $h = 0;
                $s = 0;
        }
        else
        {
                if ($l < 0.5)
                {
                        $s = $del_max / ($var_max + $var_min);
                }
                else
                {
                        $s = $del_max / (2 - $var_max - $var_min);
                }

                $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
                $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
                $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

                if ($var_r == $var_max)
                {
                        $h = $del_b - $del_g;
                }
                elseif ($var_g == $var_max)
                {
                        $h = (1 / 3) + $del_r - $del_b;
                }
                elseif ($var_b == $var_max)
                {
                        $h = (2 / 3) + $del_g - $del_r;
                }

                if ($h < 0)
                {
                        $h += 1;
                }

                if ($h > 1)
                {
                        $h -= 1;
                }
        }
        return array('h'=>$h,'s'=>$s,'l'=>$l);
    }
    
    static public function RGBToHex($r, $g, $b) {
       
       $hex = "#";
       $hex .= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);

       return $hex; // returns the hex value including the number sign (#)
    }
    
    static function HSLtoHex( $Hue = 0, $Saturation = 0, $Luminance = 0 )
    {
        /*
        --------------------------------------------------------------------------------------------
        Function Name: HSLtoHex( Mixed(Hue), Mixed(Saturation), Mixed(Luminance) )

        $Hue, $Saturation, $Luminance   - (Mixed) Can be string, float, or integer.
                                          Pct ( 0% - 100% ) | decimal ( 0 to 1.0 ) | integer ( 0 - 255 )


        HSLtoHex converts an HSL ( Hue, Saturation, and Luminance ) color into a Hexadecimal Color.
        Maximum for any value is 100%, 1.0, or 255. Invalid values passed will result in 0.
        --------------------------------------------------------------------------------------------
        */

            $HSLColor    = array( 'Hue' => $Hue, 'Saturation' => $Saturation, 'Luminance' => $Luminance );
            $RGBColor    = array( 'Red' => 0, 'Green' => 0, 'Blue' => 0 );


            foreach( $HSLColor as $Name => $Value )
            {
                    if( is_string( $Value ) && strpos( $Value, '%' ) !== false )
                            $Value = round( round( (int)str_replace( '%', '', $Value ) / 100, 2 ) * 255, 0 );

                    else if( is_float( $Value ) )
                            $Value = round( $Value * 255, 0 );

                    $Value    = (int)$Value * 1;
                    $Value    = $Value > 255 ? 255 : ( $Value < 0 ? 0 : $Value );
                    $ValuePct = round( $Value / 255, 6 );

                    define( "{$Name}", $ValuePct );

            }


            $RGBColor['Red']   = Luminance;
            $RGBColor['Green'] = Luminance;
            $RGBColor['Blue']  = Luminance;



            $Radial  = Luminance <= 0.5 ? Luminance * ( 1.0 + Saturation ) : Luminance + Saturation - ( Luminance * Saturation );



            if( $Radial > 0 )
            {

                    $Ma   = Luminance + ( Luminance - $Radial );
                    $Sv   = round( ( $Radial - $Ma ) / $Radial, 6 );
                    $Th   = Hue * 6;
                    $Wg   = floor( $Th );
                    $Fr   = $Th - $Wg;
                    $Vs   = $Radial * $Sv * $Fr;
                    $Mb   = $Ma + $Vs;
                    $Mc   = $Radial - $Vs;


                    // Color is between yellow and green
                    if ($Wg == 1)
                    {
                            $RGBColor['Red']   = $Mc;
                            $RGBColor['Green'] = $Radial;
                            $RGBColor['Blue']  = $Ma;
                    }
                    // Color is between green and cyan
                    else if( $Wg == 2 )
                    {
                            $RGBColor['Red']   = $Ma;
                            $RGBColor['Green'] = $Radial;
                            $RGBColor['Blue']  = $Mb;
                    }

                    // Color is between cyan and blue
                    else if( $Wg == 3 )
                    {
                            $RGBColor['Red']   = $Ma;
                            $RGBColor['Green'] = $Mc;
                            $RGBColor['Blue']  = $Radial;
                    }

                    // Color is between blue and magenta
                    else if( $Wg == 4 )
                    {
                            $RGBColor['Red']   = $Mb;
                            $RGBColor['Green'] = $Ma;
                            $RGBColor['Blue']  = $Radial;
                    }

                    // Color is between magenta and red
                    else if( $Wg == 5 )
                    {
                            $RGBColor['Red']   = $Radial;
                            $RGBColor['Green'] = $Ma;
                            $RGBColor['Blue']  = $Mc;
                    }

                    // Color is between red and yellow or is black
                    else
                    {
                            $RGBColor['Red']   = $Radial;
                            $RGBColor['Green'] = $Mb;
                            $RGBColor['Blue']  = $Ma;
                    }

             }

//print_r($RGBColor);

             $RGBColor['Red']   = ($C = round( $RGBColor['Red'] * 255, 0 )) < 15 ? '0'.dechex( $C ) : dechex( $C );
             $RGBColor['Green'] = ($C = round( $RGBColor['Green'] * 255, 0 )) < 15 ? '0'.dechex( $C ) : dechex( $C );
             $RGBColor['Blue']  = ($C = round( $RGBColor['Blue'] * 255, 0 )) < 15 ? '0'.dechex( $C ) : dechex( $C );

//print_r($RGBColor);
//exit();

             return '#' . $RGBColor['Red'].$RGBColor['Green'].$RGBColor['Blue'];


    }

    
    static function HSLToRGB( $h, $s, $l ){
        $r; 
        $g; 
        $b;

        $c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
        $x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
        $m = $l - ( $c / 2 );

        if ( $h < 60 ) {
            $r = $c;
            $g = $x;
            $b = 0;
        } else if ( $h < 120 ) {
            $r = $x;
            $g = $c;
            $b = 0;            
        } else if ( $h < 180 ) {
            $r = 0;
            $g = $c;
            $b = $x;                    
        } else if ( $h < 240 ) {
            $r = 0;
            $g = $x;
            $b = $c;
        } else if ( $h < 300 ) {
            $r = $x;
            $g = 0;
            $b = $c;
        } else {
            $r = $c;
            $g = 0;
            $b = $x;
        }

        $r = floor ( ( $r + $m ) * 255 );
        $g = floor ( ( $g + $m ) * 255 );
        $b = floor ( ( $b + $m  ) * 255 );

        return array( 'r'=> $r , 'g'=> $g , 'b'=> $b  );
    }
    
    
    
    static function rgbToHsl( $r, $g, $b ) {
            $oldR = $r;
            $oldG = $g;
            $oldB = $b;

            $r /= 255;
            $g /= 255;
            $b /= 255;

            $max = max( $r, $g, $b );
            
            $min = min( $r, $g, $b );

            $h;
            $s;
            $l = ( $max + $min ) / 2;
            $d = $max - $min;

            if( $d == 0 ){
                    $h = $s = 0; // achromatic
            } else {
                    $s = $d / ( 1 - abs( 2 * $l - 1 ) );

                    switch( $max ){
                        case $r:
                            $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 ); 
                            if ($b > $g) {
                                $h += 360;
                            }
                            break;

                        case $g: 
                            $h = 60 * ( ( $b - $r ) / $d + 2 ); 
                            break;

                        case $b: 
                            $h = 60 * ( ( $r - $g ) / $d + 4 ); 
                            break;
                    }			        	        
            }

            return array( 'h'=>round( $h, 2 ), 's'=>round( $s, 2 ), 'l'=>round( $l, 2 ) );
    }
    
    static public function recursiveIP($domain, $c){
            
            $options = array(
                'options' => array(
                    'default' => 0, // value to return if the filter fails                    
                ),
                'flags' => FILTER_FLAG_ALLOW_OCTAL,
            );
            
                   $result = gethostbyname($domain);
              
                   $valid = filter_var($result, FILTER_VALIDATE_IP, $options);
               
                   if($valid == 0) $error = true;
                   
                    if($error===true){

                        if($c == 3){					

                                return;
                        }
                        return self::recursiveIP($domain, ++$c);
                    }else{
                        return $result;
                    }
            }//recursiveCall
    
            
     static public function checkDomain($url, $c){         
            
           // debug::output("checking... ".$url);
          
            if(!checkdnsrr($url)){

                if($c == 3){					

                        return false;
                }
                return self::checkDomain($url, ++$c);
            }else{
                return true;
            }
     }       
     static public function recursiveStatusCode($url, $c){
           
            $code = self::get_http_response_code($url);
          
            if(empty($code)) $error = true;
            // debug::output($domain.' code: '.$code);
            if($error===true){

                if($c == 3){					

                        return '404';
                }
                return self::recursiveStatusCode($url, ++$c);
            }else{
                return $code;
            }
        }//recursiveCall


//        static public function get_http_response_code($theURL) {
//            $headers = @get_headers($theURL);
//            //print_r($headers);
//            return trim(substr($headers[0], 9, 3));
//        }  
        
        static public function get_http_response_code($theURL) {
            debug::output($theURL);
            $headers = get_headers($theURL);
            debug::output("headers".$headers);
            $num = count($headers);
            for($i=$num; $i>=0; $i--){
              if(strpos($headers[$i], 'HTTP')!== FALSE){
                   // echo "header found {$headers[$i]}\n";
                     return trim(substr($headers[$i], 9, 3));
                }
            }
           
        }    
            
       
    
    static public function recursiveGetPrefix($db_prefixes, $c){
            
        $time = microtime(1) * 10000000 + 0x01b21dd213814000;
       
        // Convert to a string representation
        $time = sprintf("%F", $time);
        preg_match("/^\d+/", $time, $time); //strip decimal point
        // And now to a 64-bit binary representation       
        $db_prefix = base_convert($time[0], 10, 16);

        if(in_array($db_prefix, $db_prefixes)) $error = true;
        
        if($error===true){

            if($c == 10){					
                //in reality changes of hiting 10 duplicates is impossible
                    return;
            }
            return self::recursiveGetPrefix($db_prefixes, ++$c);
        }else{
            return $db_prefix;
        }
    }//recursiveCall
    
    function get_prefix(){
        
        return $time;
    }
    
    static public function retrieveTree($path)  {
	//traverser a directory tree using recursion.

            $delim = strstr(PHP_OS, "WIN") ? "\\" : "/";

            if ($dir=@opendir($path)) {
                    while (($element=readdir($dir))!== false) {
                            if (is_dir($path.$delim.$element) && $element!= "." && $element!= "..") {
                                    $array[$element] = self::retrieveTree($path.$delim.$element);
                            } elseif ($element!= "." && $element!= "..") {
                                    $array[] = $element;
                            }
                    }
                    closedir($dir);
            }
            return (isset($array) ? $array : false);
    }//retrieveTree
        
    static public function redirect($url){
        $baseurl = config::get('baseurl');
        header("Location: {$baseurl}{$url} ");
        exit();
    }
    
    static public function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }
    
    static public function get_domain($url){
         $parse = parse_url($url);
        return str_replace('www.', '', $parse['host']); // prints 'google.com'
    }

    static public function cleanForHTML($str){
        return str_replace('"','',$str);
    }

    static public function getIP($return_array = false)
    {
            if (empty(self::$ip))
            {
                    $ip = null;
                    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                    {
                            $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                    }

                    if (is_array($ip))
                    {
                            if (count($ip) > 1)
                            {
                                    $via_proxy = mysql::i()->escape_string(array_pop($ip));
                                    $via_proxy = trim($via_proxy);
                            }

                            $ip = mysql::i()->escape_string(array_pop($ip));
                    }

                    if (empty($ip))
                    {
                            $ip = $_SERVER['REMOTE_ADDR'];
                    }

                    if (empty($via_proxy))
                    {
                            $via_proxy = '';
                    }

                    $ip = trim($ip);

                    self::$ip = array('ip' => $ip, 'via_proxy' => $via_proxy);
            }

            if  (false === $return_array)
            {
                    if (is_array(self::$ip))
                    {
                            $ip = self::$ip;
                            return $ip['ip'];
                    }
                    else
                    {
                            return self::$ip;
                    }
            }
            else
            {
                    return self::$ip;
            }
    }

    static public function makeOptionCheckbox($k, $v , $category='', $selected=''){
        
       
        $v = ucwords(strtolower($v));
        $option = "<div><label for=\"{$v}\"><input type=\"checkbox\" value=\"{$k}\" id=\"{$category}\" name=\"{$category}\" ";
       
        if($k == $selected[$category]) {
            
                $option .= ' checked="checked"';
        }
        $option .= "/>{$v}</label></div>\n";
        return $option;
    }

    static public function makeOption($k, $v ,$selected=''){
        $v = ucwords(strtolower($v));
        $option = "<option value='$k'";
        if($k == $selected) {
                $option .= ' selected="selected"';
        }
        $option .= ">$v</option>\n";
        return $option;
    }

    static public function makeNumberedOptions($start,$end,$selected='') {




        while($start<=$end) {
                $v = ucwords(strtolower($v));
                $options .= "<option value='$start'";
                if($start == $selected) {
                        $options .= ' selected="selected"';
                }
                $options .= ">$start</option>\n";
                $start++;
        }


        return $options;

    }//makeOptions

    static public function makeOptions($arr,$selected='') {
	

		if(is_array($arr)){

			foreach($arr as $k => $v) {
				$v = ucwords(strtolower($v));
				$options .= "<option value='$k'";
				if($k == $selected) {
					$options .= ' selected="selected"';
				}
				$options .= ">$v</option>\n";
			}
		}//is array

		return $options;

    }//makeOptions

    static public function timeOfDay(){

        $timeOfDay = array('1'=>'morning',
                        '2'=>'afternoon',
                        '3'=>'evening',
                       );
        return $timeOfDay;
    }//months
    
    static public function days(){

        for($i=1; $i<=31; $i++)
        {
            $days[$i] = $i;
        }
        return $days;
    }//days

    static public function months(){

        $months = array('1'=>'january',
                        '2'=>'february',
                        '3'=>'march',
                        '4'=>'april',
                        '5'=>'may',
                        '6'=>'june',
                        '7'=>'july',
                        '8'=>'august',
                        '9'=>'september',
                        '10'=>'october',
                        '11'=>'november',
                        '12'=>'december');
        return $months;
    }//months

    static public function years($offest){
        $thisyear = date('Y', time())-$offest;
        
        for($i=$thisyear; $i>=1900; $i--)
        {
            $years[$i] = $i;
        }
        return $years;
    }//days
    
    static public function regularTitle(){
            $title = array	(	'Mr' => 'Mr', 'Master' => 'Master', 'Mrs' => 'Mrs',
                            'Miss' => 'Miss', 'Ms' => 'Ms' , 'Dr' => 'Dr' , 'Prof' => 'Prof' ,
            'Lord' => 'Lord' , 'Lady' => 'Lady' , 'Sir' => 'Sir' , 'Rev' => 'Rev'
                            );
        return $title;
    }//regularTitle

    static public function cardTypes(){
        $cardTypes = array	(	'MasterCard' => 'MasterCard', 'Visa Credit' => 'Visa Credit', 'Visa Debit' => 'Visa Debit','American Express' => 'American Express', 'Diners Club' => 'Diners Club',
                                                                            'Solo' => 'Solo', 'Maestro' => 'Maestro'
                                                                    );
        return $cardTypes;
    }//cardTypes


    static public function get_days($selected=''){
        for($i=1;$i<= 365;$i++){
            $options .= self::makeOption($i, $i, $selected);
        }
        return $options;
   }

   static public function get_hours($selected=''){
        for($i=1;$i<= 23;$i++){
            $options .= self::makeOption($i, $i, $selected);
        }
        return $options;
   }

   static public function get_minutes($selected=''){
        for($i=1;$i<= 59;$i++){
            $options .= self::makeOption($i, $i, $selected);
        }
        return $options;
   }

   static public function get_unit_of_time($selected=''){
       $unit = array('Days','Hours', 'Minutes', 'Seconds');
       foreach($unit as $k => $v){
           $k = $v;
            $options .= self::makeOption($k, $v, $selected);
        }
        return $options;
   }

   
    
    
    
}
?>