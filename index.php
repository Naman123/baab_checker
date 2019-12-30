<?php
include "input.php";
$start_time = microtime(true);
$input = (string)$input;
$arr = explode(",", $input);
$babCount = 0;
$delimeter = '@@$$@@';
foreach ($arr as $key => $thisVal)
{
    $cleanArr = [];
    $enclosedStrings = [];
    

    $cleanStr = preg_replace('~\[.*\]~', $delimeter, $thisVal);
    $pos = strpos($cleanStr, $delimeter);
    if ($pos !== false)
    {
        $cleanArr['outside_str'] = explode($delimeter, $cleanStr);
    }
    else
    {
        $cleanArr['outside_str'] = $thisVal; //no square brackets
        
	}
	

    $isBaab = checkBaab([$thisVal]);
    if ($isBaab === true)
    {
        $babCount++;
    }

}
$end_time = microtime(true);
$execution_time = ($end_time - $start_time);
echo "Total Valid Unique Ids found " . $babCount . "<br>";
echo " Execution time = " . round($execution_time, 2) . " sec";

function validateBaab($str = '')
{
    $first_half = substr($str, 0, 2);
    $second_half = strrev(substr($str, -2));
    return $first_half === $second_half;
}

function checkBaab($strArr)
{
    $isBaab = false;
    foreach ($strArr as $str)
    {
		if (preg_match_all("/\[([^\]]*)\]/", $str, $matches))
    {
		if(checkBaab($matches[1])===true){return $isBaab;}  //return false if baab is enclosed within square brackets
	}

        $n = strlen($str);
        for ($len = 1;$len <= $n;$len++)
        {
            //end
            for ($i = 0;$i <= $n - $len;$i++)
            {
                $j = $i + $len - 1;
                $subLength = ($j - $i + 1);

                if ($subLength < 4 || $subLength > 4)
                {
                    continue; //escaping loop in case string length don't match baab length i.e. 4
                    
                }

                $sub = '';
                for ($k = $i;$k <= $j;$k++)
                {
                    $sub .= $str[$k];
                }
                if (!empty($sub) && validateBaab($sub) === true)
                {
                    return true;
                }
            }

        }
    }
    return $isBaab;
}
?>
