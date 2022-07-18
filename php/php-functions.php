<?php
//Текущая дата
function getTodayDate()
{
    $date = date("Y-m-d H:i:s");
    return $date;
}

function trimString($str)
{
    return preg_replace('/\s+/', ' ', trim($str));
}

//Переобразует в 0010
function getArrayToDateOfStay($getArray, $numHum)
{
    $result = "";
    for ($i = 1; $i <= 4; $i++) {
        if (array_key_exists('check_date'.$i.'_' . $numHum, $getArray) &&$getArray['check_date'.$i.'_' . $numHum] != "") {
            $result .= "1";
        } else {
            $result .= "0";
        }
    }

    return $result;
}

function sqlAddKeyAndValue($tableName, $sqlQuery, $key, $value){
    $firstKeyValue =strpos($sqlQuery,'VALUES()')>0;
    if ($firstKeyValue == true)
        $firstKeyValue = "";
    else
        $firstKeyValue = ", ";

    $posKey = strpos($sqlQuery, $tableName."(") + strlen($tableName)+1;

    $result = substr($sqlQuery,0,$posKey) .  $key . $firstKeyValue . substr($sqlQuery,$posKey, strlen($sqlQuery));
    $posValue = strpos($result,"VALUES(") + 7;
    $result = substr($result,0,$posValue) . "'". $value ."'". $firstKeyValue . substr($result,$posValue, strlen($result));

        //. substr($sqlQuery,$posKey+strlen($value),$posValue-$posKey+strlen($value)) . $firstKeyValue . $value . ")" ;
    return  $result;
}
?>

