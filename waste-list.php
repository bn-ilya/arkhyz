<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список затрат - Архыз</title>

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
            <a href="<?= (strpos($_SERVER['REQUEST_URI'], "?") == true) ? "/r/list.php?where=" : "/r" ?>"
               class="back title">Назад</a>
        </div>
        <?php 
            $statement = $GLOBALS['pdo']->query("SELECT * FROM `waste_book`");

            while($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="waste-list__item" onclick="wasteListOnClick(<?= $row['id']?>)">
                <div class="waste-list__title title">Затрата <?= $row['id']?></div>
                <div class="waste-list__subtitle title">Сумма затраты: <p><?= $row['sum']?> руб</p> </div>
                <div class="waste-list__subtitle title">Комментарий: <?= $row['note']?></div>
                <div class="waste-list__subtitle title">Оператор: <?= operatorGetNameById($row['operator'])?></div>
                <div class="waste-list__subtitle title">Время операции: <?= $row['date'] ?></div>
            </div>
                
        <?php }
        ?>

    </div>
    <?php require_once 'js/connect_js.php'; ?>
</body>
</html>