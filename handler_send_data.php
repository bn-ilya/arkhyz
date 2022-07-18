<?php
require_once 'bd-con.php';
//получаем humanArray
if (isset($_POST['data'])) {
$humanArray = json_decode($_POST['data'],true);
for($i=0; $i<count($humanArray); $i++){
    $humanData = $humanArray[$i];
//ДОБАВИТЬ ОБРАБОТКУ ТЕЛЕФОНА!!!!!!
        $sql = "UPDATE `human_list` SET `name` = '".$humanData['name']
            ."', `age` = '".$humanData['age']
            ."', `gender` = '".$humanData['gender']
            ."', `note` = '".$humanData['note']
            ."', `parent` = '".$humanData['parent']
            ."', `credit` = '".$humanData['credit']
            ."', `donation` = '".$humanData['donation']
            ."', `car_status` = '".$humanData['car_status']
            ."', `car_places` = '".$humanData['car_places']
            ."', `car_use_id` = '".humanGetIdByName($humanData['car_use_id'])
            ."', `tent_status` = '".$humanData['tent_status']
            ."', `tent_places` = '".$humanData['tent_places']
            ."', `tent_use_id` = '".humanGetIdByName($humanData['tent_use_id'])
            ."', `church` = '".$humanData['church']."', `problem` = '".$humanData['problem']
            ."', `operator` = '".operatorGetIdByName($humanData['operator'])
            ."', `dates_of_stay` = '".$humanData['dates_of_stay']
            ."', `car_not_pay` = '".$humanData['car_not_pay']
            ."' WHERE `human_list`.`id` = ".$humanData['id'];
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();
}


   echo getJsonHumanArray($humanArray[0]['id']);
}
if (isset($_POST['operator'])) {
	$wasteArray = $_POST;
    $dateToday = getTodayDate();
    $operator = operatorGetIdByName($_POST['operator']);

	$sql = "INSERT INTO `waste_book` (`sum`, `note`, `operator`, `date`) VALUES ('".$wasteArray['sum']."', '".$wasteArray['note']."', '".$operator."', '".$dateToday."') ";
	$query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();
    //Перенаправляем на главную
	header('Location: /r/waste-list.php');
} elseif (isset($_POST['sum'])) {
    $wasteArray = $_POST;
    $sql = "UPDATE `waste_book` SET `sum` = '".$wasteArray['sum']."', `note` = '".$wasteArray['note']."' WHERE `waste_book`.`id` = ".$wasteArray['id'];
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();
    //Перенаправляем на главную
    header('Location: /r/waste-list.php');
}

?>