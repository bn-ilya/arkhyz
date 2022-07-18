<?php
require 'bd-con.php';


if($_POST['type'] == "HUMAN"){ //ОБРАБОТКА HUMAN
    if ($_POST['action'] == "CHANGE"){

        if($_POST['key']=="tent_use_id" || $_POST['key']=="car_use_id")
            $_POST['value'] =  humanGetIdByName($_POST['value']);

        if($_POST['key']=="car_status" && $_POST['value']=="PROVIDES")
            CAR_USE_ID_for_CAR_PROVIDES($_POST['id'],$_POST['id']);
        elseif($_POST['key']=="car_status" && ($_POST['value']!="PROVIDES" && $_POST['value']!="USE"))
            CAR_USE_ID_for_CAR_PROVIDES($_POST['id'], '0');


        if($_POST['key']=="tent_status" && $_POST['value']=="PROVIDES")
            TENT_USE_ID_for_TENT_PROVIDES($_POST['id'],$_POST['id']);
        elseif($_POST['key']=="tent_status" && ($_POST['value']!="PROVIDES" && $_POST['value']!="USE"))
            TENT_USE_ID_for_TENT_PROVIDES($_POST['id'], '0');

        $sql = "UPDATE `human_list` SET `".$_POST['key']."` = '".$_POST['value']."' WHERE `human_list`.`id` = ".$_POST['id'];
    }elseif ($_POST['action'] == "DELETE"){
        $sql = "DELETE FROM `human_list` WHERE `human_list`.`id` = ".$_POST['id'];
    }elseif ($_POST['action'] == "ADD_CHILD"){
        $sql = "INSERT INTO `human_list` (`id`, `name`, `age`, `parent`) VALUES (NULL, '".$_POST['name']."', '".$_POST['age']."', '".$_POST['parent']."');";
    }
}elseif ($_POST['type'] == "PHONE"){ //ОБРАБОТКА PHONE
    if ($_POST['action'] == "CHANGE"){
        $sql = "UPDATE `phone_list` SET `".$_POST['key']."` = '".$_POST['value']."' WHERE `phone_list`.`id` = ".$_POST['id'];
    }elseif ($_POST['action'] == "DELETE"){
        $sql = "DELETE FROM `phone_list` WHERE `phone_list`.`id` = ".$_POST['id'];
    }elseif ($_POST['action'] == "ADD"){
        $sql = "INSERT INTO `phone_list` (`id`, `phone`, `note`, `human`) VALUES (NULL, '".$_POST['phone']."', '".$_POST['note']."', '".$_POST['human']."');";
    }
}

$query = $pdo->prepare($sql);
$query->execute();

if($_POST['action'] == "ADD"){
    if ($_POST['type'] == "PHONE")
        echo phoneGetMaxId();
}
if ($_POST['type'] == "HUMAN"){
    if($_POST['action'] == "ADD_CHILD")
        echo getJsonHumanArray(humanGetMaxId());
    if($_POST['action'] == "CHANGE")
        echo getJsonHumanArray($_POST['id']);
}

?>