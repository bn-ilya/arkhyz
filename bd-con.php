<?php
	//подключение к бд
	$dsn = 'mysql:host=localhost;dbname=church_reg';
	$pdo = new PDO($dsn, 'root', 'robokop67');

	//После подключения к БД подключаем методы PHP
    require 'php/handlingChild.php';
    require 'php/handlingHuman.php';
    require 'php/handlingPhone.php';
    require 'php/handlingOperator.php';
    require 'php/handlingFinance.php';
    require 'php/php-functions.php';
    require 'php/blocks.php';
    require 'php/handlingList.php';
    require 'php/handlingResults.php';
?>