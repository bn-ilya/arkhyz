<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Архыз</title>

    <script language="JavaScript" type="text/javascript"
            src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php

require 'bd-con.php';
//ЕСЛИ ЕСТЬ ПРЕДОПРЕДЕЛЕННОЕ ИМЯ
$preName="";
if (array_key_exists('preName', $_GET)) {
    $preName =  $_GET['preName'];
}
//КОНЕЦ ПРЕДОПРЕДЕЛЕННОЕ ИМЯ

$data = array();
$data['id'] = 0;
$phoneArray = array();
$childArray = array();
if (array_key_exists('id', $_GET)) {
    $data = humanGetDataById($_GET['id']);
    $phoneArray = humanGetArrayPhoneList($data['id']);
    $childArray = humanGetArrayChild($data['id']);
}
?>
<div class="container">
    <div class="header">
        <a href="<?= (strpos($_SERVER['REQUEST_URI'], "?") == true) ? "/r/list.php?where=" : "/r"?>" class="back title">Назад</a>
    </div>

    <form action="handler.php" id="addHumanForm" class="reg title" method="GET">
        <div id="inputContent"></div>
        <div class="reg__phone">
            <div class="phone-dlc"></div>
            <input type="button" class="reg-phone title" onclick="ajaxAddPhone(<?= $data['id'] ?>)" value="+ телефон">
        </div>

        <div class="reg-dlc" id="reg-dlc"></div>
        <input type="button" class="reg-add title" onclick="ajaxAddChild(<?= $data['id'] ?>)" value="+ человек">

        <div class="reg-addition">
            <input  type="number" placeholder="Пожертвование" class="reg-txt" name="donation_0" id="donation_0"
                    value="<?= ($data['id'] != 0) ? $data['donation'] : "" ?>"
                    oninput="donationLimiter(this);ajaxChange('HUMAN','CHANGE',<?= $data['id'] ?>,'donation',this.value); creditCalculator()">
    
            <textarea  id="last" placeholder="Комментарий" class="reg-area reg-txt" name="note_0" id="note_0"
                      onchange="ajaxChange('HUMAN','CHANGE',<?= $data['id'] ?>,'note',this.value)"
            ><?= ($data['id'] != 0) ? $data['note'] : "" ?></textarea>
            <input type="checkbox" class="check__default_car check__default" id="problem_0" name="problem_0"
                onchange="ajaxChange('HUMAN','CHANGE',<?= $data['id'] ?>,'problem',(this.checked)?'1':'0')" <?= ($data['id'] != 0 && $data['problem'] == "1") ? " checked " : "" ?>>
            <label for="problem_0" class="problem__check check">Добавить к проблемным</label>
        </div>

        <div class="select-wrapper">
            <div class="car-title">Церковь:</div>
            <div class="operator-wrapper">
                <select name="church_0"  id="church_0" class="select title" onchange="ajaxChange('HUMAN','CHANGE',<?= $data['id'] ?>,'church',this.value)">
                    <?=($data['id'] != 0) ? "<option>".$data['church']."</option>" : ""  ?>
                    <option>Не выбрана/нет в списке</option>
                    <option>Кропоткин</option>
                    <option>Кавказская</option>
                    <option>Верхнерусское</option>
                    <option>Тбилсская</option>
                    <option>Краснодар</option>
                    <option>Церковь Святого Арсения</option>
                </select>
            </div>
        </div>

        <div class="select-wrapper">
            <div class="car-title">Оператор:</div>
            <div class="operator-wrapper">
                <select name="operator_0"  id="operator_0" class="select title">
                    <?php
                    if ($data['id'] != 0) {
                        echo "<option>" . operatorGetNameById($data["operator"]) . "</option>\n";
                    }else {
                        $operatorArray = operatorGetArray();
                        foreach ($operatorArray as $value) {
                            echo "<option value='".$value["name"]. "'>" . $value["name"] . "</option>\n";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>


        <div class="reg-total">ИТОГО: <p id="total"><?=humanGetCreditById($data['id'])?></p> руб.</div>
        <input type="button" class="reg-sub title <?= ($data['id'] != 0) ? "hidden": "" ?>" onclick="addHumanCheckAndSubmit(this)" value="Сохранить">
        <div id="here_payment_history"></div>

    </form>
</div>
<?php require_once 'js/connect_js.php';?>
<script>
    addInputHuman(document.getElementById("inputContent"),0,<?= $data['id']?>,'<?=($data['id']!=0)?$data['name']:$preName?>',
        '<?= ($data['id']!=0)?$data['age']:""?>','<?= ($data['id']!=0)?$data['dates_of_stay']:""?>',
        '<?= ($data['id']!=0)?$data['gender']:""?>','<?= ($data['id']!=0)?$data['car_status']:""?>','<?= ($data['id']!=0)?$data['car_places']:""?>',
        '<?= ($data['id']!=0)?humanGetNameById($data['car_use_id']):""?>','<?= ($data['id']!=0)?$data['tent_status']:""?>','<?= ($data['id']!=0)?$data['tent_places']:""?>','<?= ($data['id']!=0)?humanGetNameById($data['tent_use_id']):""?>')
    //addInputHuman(document.getElementById("addHumanForm"),0,,<?=($data['id']!=0)?$data['name']:""?>,<?= ($data['id']!=0)?$data['id']:""?>)
    <?php
    foreach ($phoneArray as $key => $value) {
            echo "\n addPhone('" . $value['id'] . "','" . $value['phone'] . "','" . $value['note'] . "') \n";
    }

    foreach ($childArray as $key => $value) {
        echo "\n addChild('" . $value['id'] . "','" . $value['name'] . "','" . $value['age'] . "','" . $value['dates_of_stay'] . "','" . $value['gender'] . "','" . $value['car_status'] . "','" . $value['car_places'] . "','" . humanGetNameById($value['car_use_id']) . "','" . $value['tent_status'] . "','" . $value['tent_places'] . "','" . humanGetNameById($value['tent_use_id']) . "') \n";
    }

    if($data['id']==0)
        echo "\n document.getElementById('operator_0').value = window.top.localStorage['operator'];"

    ?>
    checkListen()
    setTimeout(function (){checkListen()},2000)
</script>



</body>
</html>