<?php
//Получить всё количество записанных хьюманов
function humanGetAllSortArray($where=""){

    //Получаем всех родителей
    $arrayHuman = array();
    $statement = $GLOBALS['pdo']->query("SELECT if(`parent` = '',`id`, `parent`) as 'sort_id',`id`, `name`, `age`, `gender`, `note`, `parent`, `credit`, `donation`, `car_status`, `car_places`, `car_use_id`, `tent_status`, `tent_places`, `tent_use_id`, `church`, `operator`, `dates_of_stay` FROM `human_list` ".$where." ORDER BY `sort_id`");
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $arrayHuman[] = $row;
    }


    return $arrayHuman;
}
//Получить ID human по его NAME
function humanGetIdByName($name){
    if(trim($name) == '' || trim($name) == ""){
        return "0";
    }

    $statement = $GLOBALS['pdo']->query("SELECT `id` FROM `human_list` WHERE `name` = '$name'");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['id'];
    }
    return "0";
}

//Получить максимальный id хьюмана
function humanGetMaxId(){
    $statement = $GLOBALS['pdo']->query("SELECT MAX(`id`) AS \"result\" FROM `human_list`");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['result'];
    }
    return 0;
}

//Получить данные human
function humanGetDataById($id){
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `id` = $id");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $row['tent_use_id'] = humanGetNameById($row['tent_use_id']);
        $row['car_use_id'] = humanGetNameById($row['car_use_id']);
        $row['operator'] = operatorGetNameById($row['operator']);
        return $row;
    }
    return null;
}

//Получить имя по ID хьюмана
function humanGetNameById($humanId){
    $statement = $GLOBALS['pdo']->query("SELECT `name` FROM `human_list` WHERE `id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['name'];
    }
    return "";
}
//Получить имя Оператора по IDhuman
function humanGetOperatorNameById($humanId){
    $statement = $GLOBALS['pdo']->query("SELECT `operator` FROM `human_list` WHERE `id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return operatorGetNameById($row['operator']);
    }
    return "";
}

//Получить id родителя
function humanGetParentId($humanId){
    $statement = $GLOBALS['pdo']->query("SELECT `parent` FROM `human_list` WHERE `id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['parent'];
    }
    return '';
}

//Получить дни пребывания по ID хьюмана
function humanGetDatesById($humanId) {
    // $statement = $GLOBALS['pdo']->query("SELECT `dates_of_stay` FROM `human_list` WHERE `id` = " . $humanId);

    // while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    //     return $row['dates_of_stay'];
    // }
    // return "";
    $statement = $GLOBALS['pdo']->query("SELECT `dates_of_stay` FROM `human_list` WHERE `id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $array = str_split($row['dates_of_stay']);
        $i = 1;
        $k = 0;
        foreach ($array as $value) {
            if ($value == 0) {
                $k += 1;
                if ($k == 4) {
                    $dates = 0000;
                };
                continue;   
            } elseif ($value == 1 && $i == 1) {
                $dates = "22";
            } elseif ($value == 1 && $i == 2) {
                ($dates != "") ? $dates .= ", 23" : "23";
            } elseif ($value == 1 && $i == 3) {
                ($dates != "") ? $dates .= ", 24" : "24";
            } elseif ($value == 1 && $i == 4) {
                ($dates != "") ? $dates .= ", 25" : "25";
                break;
            };
            $i += 1;
        };
        return $dates;
    }
    return "";
}

//Получить кол-во свободных мест в палатке по ID хьюмана
function humanGetTentPlacesById($humanId) {
    $statement = $GLOBALS['pdo']->query("SELECT `tent_places` FROM `human_list` WHERE `id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['tent_places'];
    }
    return "";
}



//Получить общее кол-во мест в машине по ID хьюмана
function humanGetCarPlacesById($humanId) {
    $statement = $GLOBALS['pdo']->query("SELECT `car_places` FROM `human_list` WHERE `id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['car_places'];
    }
    return "";
}


//Получить количество людей, которые едут с хьюманом по ID хьюмана
function humanGetBusyCarPlacesById($humanId) {
    $statement = $GLOBALS['pdo']->query("SELECT `id` FROM `human_list` WHERE `car_use_id` = " . $humanId);

    $i = 0; 
    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $i++;
    }
    return $i;
}

//Получить количество людей, которые уже в палатке у хьюмана по ID хьюмана
function humanGetBusyTentPlacesById($humanId) {
    $statement = $GLOBALS['pdo']->query("SELECT `id` FROM `human_list` WHERE `tent_use_id` = " . $humanId);

    $i = 0;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $i++;
        }

    return $i;
}

function humanGetStatusCarById($humanId) {
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `id` = " . $humanId);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $row['car_status'];
        }

    return '';
}
function humanGetStatusTentById($humanId) {
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `id` = " . $humanId);

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $row['tent_status'];
        }

    return '';
}

//Получить статус CAR
function humanGetStatusCar($humanId) {
    if(humanGetStatusCarById($humanId) == "PROVIDES"){
        CAR_USE_ID_for_CAR_PROVIDES($humanId,$humanId);
    }
    $res = "Места: ".humanGetBusyCarPlacesById($humanId)." из ".humanGetCarPlacesById($humanId)."<br>Имена занявших:";
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `car_use_id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $res .= "<br>[id ".$row['id']."] ".$row['name'];
    }
    return $res;
}
//Получить статус TENT
function humanGetStatusTent($humanId) {
    if(humanGetStatusTentById($humanId) == "PROVIDES"){
        TENT_USE_ID_for_TENT_PROVIDES($humanId,$humanId);
    }
    $res = "Места: ".humanGetBusyTentPlacesById($humanId)." из ".humanGetTentPlacesById($humanId)."<br>Имена занявших:";
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `human_list` WHERE `tent_use_id` = " . $humanId);

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $res .= "<br>[id ".$row['id']."] ".$row['name'];
    }
    return $res;
}

//Получаем массив human в JSON
function getJsonHumanArray($humanId){
    //Если CHILD, получаем паранта
    $humanId = (humanGetParentId($humanId)!=0)?humanGetParentId($humanId):$humanId;

    $humanArray = array();
    $humanArray[] = humanGetDataById($humanId);
    $humanArray[0]['phone'] = humanGetArrayPhoneList($humanId);
    $humanArray = array_merge($humanArray, humanGetArrayChild($humanId));
    return json_encode($humanArray);
}

//Устанавливаем значение для CAR USE ID ДЛЯ PROVIDIES
function CAR_USE_ID_for_CAR_PROVIDES($humanID, $value){
    $sql = "UPDATE `human_list` SET `car_use_id` = '".$value."' WHERE `human_list`.`id` = ".$humanID;
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();
}
//Устанавливаем значение для TENT USE ID ДЛЯ PROVIDIES
function TENT_USE_ID_for_TENT_PROVIDES($humanID, $value){
    $sql = "UPDATE `human_list` SET `tent_use_id` = '".$value."' WHERE `human_list`.`id` = ".$humanID;
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();
}

//Создать пустого хьюмана
function addHuman($name = ""){
    $sql = "INSERT INTO `human_list` (`id`, `name`,`dates_of_stay`, `church`) VALUES (NULL, '".$name."', '1111', 'Не выбрана/нет в списке');";
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();

    return humanGetMaxId();
}
?>