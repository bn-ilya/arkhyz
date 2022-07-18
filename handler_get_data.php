<?php
require 'bd-con.php';

if($_POST['type']=="CAR_PROVIDES"){
    $humanArray = humanGetAllSortArray("WHERE `car_status` = 'PROVIDES'");
    foreach ($humanArray as $human){
        if($_POST['value'] == "")
            echo "\n<option selected></option>>";
        echo "<option ".(($human['name'] == $_POST['value'])?" selected ":" ")." id='".$human['name']."' name='".$human['name']."'>".$human['name']."</option>";

    }
}elseif($_POST['type']=="TENT_PROVIDES"){
    $humanArray = humanGetAllSortArray("WHERE `tent_status` = 'PROVIDES'");
    foreach ($humanArray as $human){
        if($_POST['value'] == "")
            echo "\n<option selected></option>>";
        echo "<option ".(($human['name'] == $_POST['value'])?" selected ":" ")." id='".$human['name']."' name='".$human['name']."'>".$human['name']."</option>";
    }
}elseif($_POST['type']=="GET_HTML_PAY_HISTORY" && $_POST['id']!= "0" && $_POST['id']!= 0){
    getHtmlHistoryPayment($_POST['id']);
}elseif($_POST['type']=="GET_STATUS_CAR" && $_POST['name']!= ""){
    echo humanGetStatusCar(humanGetIdByName($_POST['name']));
}elseif($_POST['type']=="GET_STATUS_TENT" && $_POST['name']!= ""){
    echo humanGetStatusTent(humanGetIdByName($_POST['name']));
}
?>
