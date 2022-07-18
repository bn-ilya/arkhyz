<?php
//Получить максимальный id phone_list
function phoneGetMaxId(){
    $statement = $GLOBALS['pdo']->query("SELECT MAX(`id`) AS \"result\" FROM `phone_list`");

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['result'];
    }
    return 0;
}

//Добавить номер телефона для хьюмана
function humanAddPhone($humanId, $phone, $note)
{
    $sql = 'INSERT INTO phone_list(human, phone, note) VALUES(:human, :phone, :note)';
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute(['human' => $humanId, 'phone' => $phone, 'note' => $note]);
}

//Получить массив номеров телефонов для хьюмана
function humanGetArrayPhoneList($humanId)
{
    $result = array();

    $statement = $GLOBALS['pdo']->query("SELECT * FROM `phone_list` WHERE `human` = " . $humanId);

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}

//Извлечь из GET массив телефонов
function getArrayToArrayPhone($getArray)
{
    $result = array();

    for ($i = 0; $i <= 100; $i++) {
        $phoneName = "phone-" . $i;
        $phoneNoteName = "phone-note-" . $i;
        $phoneIdName = "phone-id-" . $i;

        $row = array();
        if (array_key_exists($phoneName, $getArray) && $getArray[$phoneName] <> "") {
            if((int)$getArray[$phoneIdName] == 0){ //Если новый номер телефона
                $getArray[$phoneIdName] = phoneGetMaxId()+1+count($result); //Прибавляем 1 к максимальному id phone, потому что именное его займет новый номер
            }
            $row['human'] = $getArray['id_0'];
            $row['id'] = $getArray[$phoneIdName];
            $row['phone'] = $getArray[$phoneName];
            $row['note'] = $getArray[$phoneNoteName];
            $result[] = $row;
        }


    } //КОНЕЦ добавления номеров телефонов
    return $result;
}

//Преобразует номер в формат 7ХХХХХХХХХХ (и убирает от мусора)
function phoneStandardView($phone)
{
    $phone == "" . $phone; //Переобразование в массимв для уверенности
    if (strlen($phone) == 0) //Если пришло пустое значение, возвращаем пустоту
        return "";
    $phone = preg_replace("/[^0-9]/", '', $phone); //оставляем только цифры
    if (strlen($phone) == 10 && $phone[0] == '9') //добовляем 7
        $phone = "7" . $phone;
    if ($phone[0] != '7') //Если начинается не с 7
        $phone = "7" . substr($phone, 1, 10);
    if (strlen($phone) != 11) //Не верная длинна номера
        $phone == "ERROR";
    return $phone;
}


?>