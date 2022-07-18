<?php
require 'bd-con.php';
$getArray = $_GET;

// //Формирую кол-во днй поездки
// $i = 1;
// $datesOfStay = "";
// while ($i <= 4) {
//     if (isset($getArray["check-date" . $i])) {
//         ($getArray["check-date" . $i] == 1) ? $datesOfStay .= 1 : $datesOfStay .= 0;
//     }
//     $i ++;
// };

// echo $datesOfStay;
//Новый элемент в Human_list
if ((int)$getArray['id_0'] == 0) { //Если новый элемент


    //заполняем данные
    $arrayHuman = getArrayToArrayHuman($getArray);
    $parentNewId = humanGetMaxId() + 1; // Получаем максимальный id и прибавляем 1, потому что новый хьман займет именно его
    $getArray['id_0'] = $parentNewId;

    foreach ($arrayHuman as $key => $row) {
        $sql = 'INSERT INTO human_list() VALUES()';
        $queryKey = "";
        $queryValue = "";
            $sql = sqlAddKeyAndValue("human_list", $sql, 'name', $row['name']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'age', $row['age']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'gender', $row['gender']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'tent_status', $row['tent_status']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'tent_use_id', $row['tent_use_id']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'tent_places', $row['tent_places']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'car_status', $row['car_status']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'car_use_id', $row['car_use_id']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'car_places', $row['car_places']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'dates_of_stay', $row['dates_of_stay']);
        if ($key == 0) {//ЕСЛИ РОДИТЕЛЬ

            $sql = sqlAddKeyAndValue("human_list", $sql, 'credit', $getArray['credit_0']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'operator', operatorGetIdByName($getArray['operator_0']));
            $sql = sqlAddKeyAndValue("human_list", $sql, 'note', $getArray['note_0']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'donation', $getArray['donation_0']);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'problem', (array_key_exists('problem_0',$getArray) && $getArray['problem_0'] != "")?1:0);
            $sql = sqlAddKeyAndValue("human_list", $sql, 'church', $getArray['church_0']);

        } else { //ЕСЛИ CHILD
            $sql = sqlAddKeyAndValue("human_list", $sql, 'parent', $parentNewId);
        }

        $query = $pdo->prepare($sql);
        $query->execute();
    }

    //Добавляем номера телефонов
    $arrayPhone = getArrayToArrayPhone($getArray);
    foreach ($arrayPhone as $row)
        humanAddPhone($row['human'], $row['phone'], $row['note']);
}

//Перенаправляем на главную
header('Location: /r');
?>

