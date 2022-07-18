<?php
function fillList($where)
{
    $parId = 0;
    $humanArray = humanGetAllSortArray($where);
    foreach ($humanArray as $row) {
        //while($row = $query->fetch(PDO::FETCH_OBJ)) {
        if ($row['parent'] == 0) {
            ?>
            <div class="list__btn " onclick='humanListOnClick(<?= $row['id'] ?>)'>
                <div class="list__id title"><?= $row['id'] ?></div>
                <div>
                    <div class="list__name title"><?= $row['name'] ?></div>
                    <div class="list__sumChild title <?= (count(humanGetArrayChild($row['id'])) == 0) ? "hidden" : ""; ?>">
                        Кол-во подчинённых: <?= count(humanGetArrayChild($row['id'])) ?></div>
                </div>
                <div class="list__icons title">
                    <div class="list__row-item list__row-item_padding">
                        <div class="list__column <?= (humanGetDatesById($row['id']) == "0000") ? "hidden" : ""; ?>">
                            <img src="img/sun.svg" class="list__icon-item">
                            <div class="list__icon-title"><?= humanGetDatesById($row['id']) ?></div>
                        </div>
                        <div class="list__column <?= (humanGetTentPlacesById($row['id']) == "0") ? "hidden" : ""; ?>">
                            <img src="img/tent.svg" class="list__icon-item">
                            <div class="list__icon-title"><?= humanGetBusyTentPlacesById($row['id']) ?>/<?= (humanGetTentPlacesById($row['id'])) ?></div>
                        </div>
                    </div>
                    <div class="list__row-item">
                        <div class="list__column <?= (humanGetCreditById($row['id']) == "0") ? "hidden" : ""; ?>">
                            <img src="img/dollar.svg" class="list__icon-item">
                            <div class="list__icon-title"><?= humanGetSumPaymentById($row['id']) ?>
                                /<?= (humanGetCreditById($row['id'])) ?></div>
                        </div>
                        <div class="list__column <?= (humanGetCarPlacesById($row['id']) == "0") ? "hidden" : ""; ?>">
                            <img src="img/car.svg" class="list__icon-item">
                            <div class="list__icon-title"><?= humanGetBusyCarPlacesById($row['id']) ?>/<?= (humanGetCarPlacesById($row['id'])) ?></div>
                        </div>
                    </div>
                </div>
                <?php
                if (humanGetSumPaymentById($row['id']) != (humanGetCreditById($row['id']))) {
                    ?>
                    <a href="fast-pay.php?id=<?= $row['id'] ?>" class="list__btn-pay"></a>
                <?php } ?>
            </div>
            <?PHP
            $parId = $row['id'];
        } elseif ($row['parent'] != "" && $parId == $row['parent']) {
            ?>
            <div class="parent">
            <div class="parent__btn" onclick='humanListOnClick(<?= $row['parent'] ?>)'>
                <div class="list__id title"><?= $row['id'] ?></div>
                <div>
                    <div class="list__name title"><?= $row['name'] ?></div>
                    <div class="list__parent title">Родитель: <?= humanGetNameById($row['parent']) ?> </div>
                </div>
            </div>
            </div>
            <?php
        } elseif ($row['parent'] != "" && $parId != $row['parent']) {
            ?>
            <div class="no-parent" onclick='humanListOnClick(<?= $row['parent'] ?>)'>
                <div class="parent__btn">
                    <div class="list__id title"><?= $row['id'] ?></div>
                    <div>
                        <div class="list__name title"><?= $row['name'] ?></div>
                        <div class="list__parent title">Родитель: <?= humanGetNameById($row['parent']) ?></div>
                    </div>
                </div>
            </div>
            <?php
        }

    }
    //return $res;
}

?>