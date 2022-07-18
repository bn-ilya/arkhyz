<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Главная - Архыз</title>

	<!-- fonts -->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
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
	<?php require 'bd-con.php'; ?>
<div class="container">

	<div class="header">
		<a href="add.php"><div class="header__add-btn title">Добавить человека +</div></a>
		<a href="waste-pay.php"><div class="waste-btn header__add-btn title">Растрата +</div></a>
	</div>

    <div class="select-wrapper_margin select-wrapper">
        <div class="car-title title">Выбери оператора по умолчанию:</div>
        <div class="operator-wrapper">
        	<select name="operator" id="operator" class="select title" onchange="window.top.localStorage['operator']=this.value;">
        	    <option></option>
        	    <?php
        	        $operatorArray = operatorGetArray();
        	        foreach ($operatorArray as $value) {
        	            echo "<option id='".$value["id"]. "' value='".$value["name"]. "'>" . $value["name"] . "</option>\n";
        	        }
        	    ?>
        	</select>
    	</div>
    </div>

	<div class="statistic">
<!-- 		<div class="statistic__list title">
			<div class="statistic__title">Всего:</div>
			<div class="statistic__title">Осталось:</div>
			<div class="statistic__title">Найти места:</div>
		</div> -->
		<div class="statistic__mn title">
			<a href="list.php?where=" class="statistic__btn">Весь список [<?=getResultCountHuman()?> штук]</a>
			<a href="waste-list.php" class="statistic__btn">Список растрат</a>
			<a href="list.php?where=where `church` = 'Кропоткин'" class="statistic__btn">С Кропоткина [<?=getResultCountHuman("Кропоткин")?> штук]</a>
			<a href="list.php?where=where `church` = 'Кавказская'" class="statistic__btn">С Кавказской [<?=getResultCountHuman("Кавказская")?> штук]</a>
			<a href="list.php?where=where `church` != 'Кавказская' AND `church` != 'Кропоткин' AND `parent` = 0" class="statistic__btn">С другого города [<?=getResultCountHuman()-getResultCountHuman("Кропоткин")-getResultCountHuman("Кавказская")?> штук]</a>
			<a href="list.php?where=" class="statistic__btn">Не оплатившие (в разработке)</a>
			<a href="list.php?where=where `problem` = 1" class="statistic__btn">Проблемные</a>
			<a href="list.php?where=where `car_places` > 0" class="statistic__btn">Машины</a>
			<a href="list.php?where=where `age` <= 2" class="statistic__btn">0-2 года</a>
			<a href="list.php?where=where `age` >= 2 AND `age` <= 5" class="statistic__btn">2-5 лет</a>
			<a href="list.php?where=where `age` >= 6 AND `age` <= 12" class="statistic__btn">6-12 лет</a>
			<a href="list.php?where=where `age` >= 13" class="statistic__btn">13+ лет</a>
		</div>
	</div>

	<div class="list"></div>
</div>
    <?php
    require_once 'js/connect_js.php';
    ?>

<script>
  document.getElementById("operator").value = window.top.localStorage['operator'];
</script>
</body>
</html>