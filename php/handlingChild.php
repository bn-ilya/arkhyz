<?php



//Извлечь из GET массив чаилдов
function getArrayToArrayHuman($getArray)
{
    $result = array();
    for ($i = 0; $i <= 100; $i++) {

        $row = array();
        if (array_key_exists('name_'.$i, $getArray)) {
            $row['name'] = trimString($getArray['name_'.$i]);
            $row['age'] = $getArray["age_".$i];
            $row['gender'] = $getArray["checkbox_gender_".$i];
            $row['tent_status'] = $getArray['tent_status_'.$i];
            $row['tent_use_id'] =($getArray['tent_status_'.$i] == "USE")?humanGetIdByName($getArray['tent_use_id_'.$i]):($getArray['tent_status_'.$i] == "PROVIDES")?humanGetMaxId()+1+$i:"";
            $row['tent_places'] =($getArray['tent_status_'.$i] == "PROVIDES")?$getArray['tent_places_'.$i]:"";
            $row['car_status'] = $getArray['car_status_'.$i];
            $row['car_use_id'] =($getArray['car_status_'.$i] == "USE")?humanGetIdByName($getArray['car_use_id_'.$i]):($getArray['car_status_'.$i] == "PROVIDES")?humanGetMaxId()+1+$i:"";
            $row['car_places'] =($getArray['car_status_'.$i] == "PROVIDES")?$getArray['car_places_'.$i]:"";
            $row['dates_of_stay'] = getArrayToDateOfStay($getArray,$i);
            $row['parent'] = $getArray['id_0'];
            $result[] = $row;
        }
    } //КОНЕЦ добавления номеров телефонов
    return $result;
}

//Получить массив child для хьюмана
function humanGetArrayChild($humanId)
{
    $result = array();

    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `parent` = " . $humanId);

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $row['tent_use_id'] = humanGetNameById($row['tent_use_id']);
        $row['car_use_id'] = humanGetNameById($row['car_use_id']);
        $row['operator'] = humanGetNameById($row['operator']);

        $result[] = $row;
    }
    return $result;
}

function getCountChild($humanId)
{
    $result = 0;

    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `parent` = " . $humanId);

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result++;
    }
    return $result;
}
?>