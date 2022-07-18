<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>

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
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require 'bd-con.php'; ?>
<div class="container">
    <div class="header">
        <a href="/r/list.php?where=" class="back title">Назад</a>
    </div>
    <form class="finance" action="handler-pay.php" method="GET" id="formFastPayment">
        <div class="finance__title title">Новая оплата</div>
        <div class="finance__info title">
            <div class="finance__human">Имя: <?= humanGetNameById($_GET["id"]) ?></div>
            <div class="finance__credit">Остаток долга: <?= humanGetBalanceCreditById($_GET["id"]) ?> руб</div>
        </div>
        <input type="number" class="input-txt" placeholder="Сумма" name="sum">
        <input type="text" class="hidden" placeholder="ID" name="id" value="<?= $_GET["id"] ?>">
        <input type="text" class="hidden" placeholder="balanceCredit" name="balanceCredit"
               value="<?= humanGetBalanceCreditById($_GET["id"]) ?>">
        <input type="text" class="input-txt" placeholder="Комментарий к платежу" name="note">
        <div class="select-wrapper">
            <div class="finance__credit title">Оператор:</div>
            <div class="operator-wrapper">
                <select name="operator" id="operator" class="select title">
                    <?php
                    $operatorArray = operatorGetArray();
                    foreach ($operatorArray as $value) {
                        echo "<option value='" . $value["name"] . "'>" . $value["name"] . "</option>\n";
                    }
                    ?>
                </select>
            </div>
        </div>
        <input type="button" class="input-sub title" value="Оплатить" onclick="addPaymentCheckAndSubmit(this)">
    </form>


    <?php
    getHtmlHistoryPayment($_GET["id"]);
    ?>

</div>
<script src="js/common.js"></script>
<script>
    document.getElementById("operator").value = window.top.localStorage['operator'];
</script>
</body>
</html>