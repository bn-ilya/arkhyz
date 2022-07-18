<?php
//Получить массив операторов
function operatorGetArray(){
    $result = array();
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `operator_list`");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}

//Получить ID оператора по его NAME
function operatorGetIdByName($name){
    $statement = $GLOBALS['pdo']->query("SELECT `id` FROM `operator_list` WHERE `name` = '$name'");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['id'];
    }
    return "";
}

//Получить NAME оператора по его ID
function operatorGetNameById($id){
    $statement = $GLOBALS['pdo']->query("SELECT `name` FROM `operator_list` WHERE `id` = '$id'");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['name'];
    }
    return "";
}
?>