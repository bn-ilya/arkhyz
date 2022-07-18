<?php
function getResultCountHuman($church = null){

    $statement = $GLOBALS['pdo']->query("SELECT `id` FROM `human_list` WHERE `parent` = 0 ".(($church != null)?" AND `church` = '".$church."'":""));
    $result = 0;

    while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result++;
        $result += getCountChild($row['id']);
    }
    return $result;

}
?>