<?php
$input=file_get_contents('http://wollmilchsau.in/puzzle/input.1.txt');

  $start_time = microtime(true); 
  $input=(string) $input;
  $arr=explode("\n",$input);
  $babCount=0;
  $delimeter='@@$$@@';
  foreach($arr as $key=>$thisVal){
	$cleanArr=[];
	$enclosedStrings=[];
	if (preg_match_all("/\[([^\]]*)\]/", $thisVal, $matches)) {
		$enclosedStrings=$matches[1];
		$cleanArr['inside_str']=$enclosedStrings;
	}

	$cleanStr=preg_replace( '~\[.*\]~' , $delimeter, $thisVal);  
	$pos = strpos($cleanStr, $delimeter);
    if($pos !== false) {
		$cleanArr['outside_str']=explode($delimeter,$cleanStr);
	}
	else{
		$cleanArr['outside_str']=$thisVal; //no square brackets
	}

		$isBaab=subString($cleanArr);
		if(!empty($isBaab) && $isBaab!==false){
			$babCount++;
	}

  }
  $end_time = microtime(true); 
  $execution_time = ($end_time - $start_time);   
  echo "Total Baab Strings found ".$babCount."<br>";
  echo " Execution time = ".round($execution_time,2)." sec"; 
?>
<?php

   function checkBaab($str='') {
    $first_half=substr($str,0,2);
	$second_half=strrev(substr($str,-2));
	return $first_half===$second_half;
	}
 
  function subString($strArr)  
{ 
	//check if square bracket enclosed strings contains a baab
	$inside_str=isset($strArr['inside_str'])?$strArr['inside_str']:[];
	$outside_str=$strArr['outside_str'];
	$isBaabWithinBrackets=false;
	if(!empty($inside_str)){
		$insideBaabStr=checkBaabString($inside_str);
		$isBaabWithinBrackets=!empty($insideBaabStr)?true:false;
		if($isBaabWithinBrackets===true){return false;} //returnig if square bracket contains baab
	}
	
	if(!empty($outside_str)){
		$isoutsideBaabStr=checkBaabString($outside_str);
		$isBaabOutside=!empty($isoutsideBaabStr)?true:false;
		return $isBaabOutside;

	}

}
function checkBaabString($strArr){
	$isBaab=false;
	foreach($strArr as $str){
	
		$n=strlen($str);
		for ($len = 1; $len <= $n; $len++)  
		{  
			//end          
			for ($i = 0; $i <= $n - $len; $i++)  
			{               
				$j = $i + $len - 1;   
				$subLength=($j-$i+1);
				
	
				if($subLength<4 || $subLength>4){
					//echo 'kaushik<br>';
					continue; //escaping loop in case string length don't match baab length i.e. 4
				}
	
				$sub=''; 
				for ($k = $i; $k <= $j; $k++) {
					$sub.=$str[$k]; 
				}
				//echo 'counter'.$i."==".$j."==".$sub."<br>";      

				//secho 'naman<br>';
	
				if(!empty($sub) && checkBaab($sub)===true){  
					return true;
				}
			}             
	
		} 
	}
  
	return $isBaab;
}
?>
