<?php
require 'bd-con.php';
$getArray = $_GET;

humanAddPaymentById($getArray['id'], $getArray['sum'], $getArray['note'], operatorGetIdByName($getArray['operator']));
//Перенаправляем на главную
header('Location: /r');
?>