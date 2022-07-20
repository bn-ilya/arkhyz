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
<script>
    <?php

    require 'bd-con.php';

    ?>

</script>

<div class="container">
    <div class="header">
        <a href="<?= (strpos($_SERVER['REQUEST_URI'], "?") == true) ? "/r/list.php?where=" : "/r" ?>"
           class="back title">Назад</a>
    </div>

    <form action="handler.php" id="addHumanForm" class="reg title" method="GET">
        <div id="inputContent"></div>
        <div class="reg__phone">
            <div class="phone-dlc"></div>
            <input type="button" class="reg-phone title" onclick="ajaxAddPhone(humanArray[0]['id'])" value="+ телефон">
        </div>

        <div class="reg-dlc" id="reg-dlc"></div>
        <input type="button" class="reg-phone title" onclick="ajaxAddChild(humanArray[0]['id'])" value="+ человек">

        <div class="reg-addition">
            <input type="number" placeholder="Пожертвование" class="reg-txt" name="donation_0" id="donation_0"
                   value=""
                   onchange="humanArray[0]['donation']=this.value; humanArraySendOnServer(); creditCalculator()"
                   oninput="donationLimiter(this)">

            <textarea placeholder="Комментарий" class="reg-area reg-txt" name="note_0" id="note_0"
                      onchange="humanArray[0]['note']=this.value; humanArraySendOnServer()"
            ></textarea>
            <input type="checkbox" class="check__default_car check__default" id="problem_0" name="problem_0"
                   onchange="humanArray[0]['problem']=(this.value == 'on')?1:0; humanArraySendOnServer()">
            <label for="problem_0" class="problem__check check">Добавить к проблемным</label>
        </div>

        <div class="select-wrapper">
            <div class="car-title">Церковь:</div>
            <div class="operator-wrapper">
                <select name="church_0" id="church_0" class="select title"
                        onchange="humanArray[0]['church']=this.value; humanArraySendOnServer()">
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
                <select name="operator_0" id="operator_0" class="select title"
                        onchange="humanArray[0]['operator']=this.value; humanArraySendOnServer();">
                    <?php
                    if (array_key_exists('id', $_GET)) {

                        $operatorArray = operatorGetArray();
                        echo "\n<option selected></option>";
                        foreach ($operatorArray as $value) {
                            echo "<option  id='" . $value["name"] . "' value='" . $value["name"] . "'>" . $value["name"] . "</option>\n";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>


        <div class="reg-total">ИТОГО: <p id="total"></p> руб.</div>
        <input type="button"  class="reg-sub title" onclick="document.location.href = 'https://hmk-life.ru/r/fast-pay.php?id=' + humanArray[0]['id']"
               value="Оплата/История">


    </form>
</div>
<?php require_once 'js/connect_js.php'; ?>
<script>

    
    //Создаем пустой humanArray для нормальной работы функций
    let humanArray = null;

    <?php
    //ВСТАВЛЯЕМ ДАННЫЕ JS HUMAN ARRAY
    if (array_key_exists('id', $_GET)) {
        echo "\nhumanArray = " . getJsonHumanArray($_GET['id']) . ";\n";
    } else {
        $newId = addHuman((array_key_exists('preName', $_GET)) ? $_GET['preName'] : "");
        echo "\ndocument.location.href = 'https://hmk-life.ru/r/add.php?id=$newId'\n";
    }
    ?>
    addInputHuman(document.getElementById('inputContent'), humanArray[0],0)
    let form = document.getElementById("addHumanForm") //Получаем форму
    document.getElementById('note_0').innerHTML = humanArray[0]['note']
    document.getElementById('donation_0').value = humanArray[0]['donation']
    document.getElementById('operator_0').value = humanArray[0]['operator']
    document.getElementById('church_0').value = humanArray[0]['church']
    document.getElementById('problem_0').checked = humanArray[0]['problem'] == "1"
    if (humanArray[0]['operator']=="")
        humanArray[0]['operator']= window.top.localStorage['operator'];
    for (let i = 0; i <  document.getElementById('operator_0').options.length; i++) {
        let optionOperator = document.getElementById('operator_0').options.item(i);
        if (optionOperator.value == humanArray[0]['operator']) {
            optionOperator.selected = true
        }
    }

    for (let i = 1; i < humanArray.length; i++) {
        addChild(humanArray[i])
    }
    for (let i = 0; i < humanArray[0]['phone'].length; i++) {
        addPhone(humanArray[0]['phone'][i]['id'], humanArray[0]['phone'][i]['phone'], humanArray[0]['phone'][i]['note'])
    }
    // if (humanArray['id'] == 0)
    // document.getElementById('operator_0').value = window.top.localStorage['operator']


    checkListen()
    //setTimeout(function (){checkListen()},1000)

</script>


</body>
</html>