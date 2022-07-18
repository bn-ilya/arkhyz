<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Растраты - Архыз</title>

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
    ?>

    <div class="container">

        <div class="header">
            <a href="<?= (strpos($_SERVER['REQUEST_URI'], "?") == true) ? "/r/waste-list.php" : "/r" ?>"
               class="back title">Назад</a>
        </div>


        <form class="waste-pay__wrapeer" method="POST" action="handler_send_data.php">
            <div class="waste-pay__item">
                <input type="number" name="sum" id="sum" class="waste-pay__input reg-txt title" placeholder="Сумма" onchange="" value="">
                <textarea name="note" id="note" class="waste-pay__textarea reg-area reg-txt title" placeholder="Комментарий"></textarea>
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <!-- <input type="textarea" name="note" class="waste-pay__textarea reg-area reg-txt title" placeholder="Комментарий" onchange=""> -->
            </div>

        <?php if (isset($_GET['id'])) { ?>
            <div class="select-wrapper">
                <div class="car-title title">Оператор: <p id="operator"></p></div>
            </div>
            
        <?php } else { ?>

        

            <div class="select-wrapper">
                <div class="car-title title">Оператор:</div>
                <div class="operator-wrapper">
                    <select name="operator" class="select title" id="operator" 
                            onchange="">
                        <?php
    
                            $operatorArray = operatorGetArray();
                            echo "\n<option selected></option>";
                            foreach ($operatorArray as $value) {
                                echo "<option  id='" . $value["name"] . "' value='" . $value["name"] . "'>" . $value["name"] . "</option>\n";
                            }

                        ?>
                    </select>
                </div>
            </div>
        <?php }; ?>


            <input type="submit" class="waste-pay__btn reg-sub title" value="Сохранить">
        </form>
    </div>

<?php require_once 'js/connect_js.php'; ?>
<script src="js/common.js"></script>
<script>
    document.getElementById("operator").value = window.top.localStorage['operator'];
    let wasteArray = null
    <?php if(isset($_GET['id'])) {
        $preparingArray = getWasteByWasteId($_GET['id']);
        $preparingArray[0]['operator'] = operatorGetNameById($preparingArray[0]['operator']);
        $preparingArray = json_encode($preparingArray);
        echo "\nwasteArray = " . $preparingArray . ";\n" ?>
        document.getElementById('sum').value = wasteArray[0]['sum']
        document.getElementById('note').value = wasteArray[0]['note']
        document.getElementById('operator').innerHTML = wasteArray[0]['operator']
    <?php }; ?>

</script>
</body>
</html>