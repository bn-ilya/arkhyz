<?php
//Получить сумму кредита по ID хьюмана
function humanGetCreditById($humanId)
{
    $statement = $GLOBALS['pdo']->query("SELECT `credit` FROM `human_list` WHERE `id` = " . $humanId);

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['credit'];
    }
    return "";
}

//Получить сумму оплат по ID хьюмана
function humanGetSumPaymentById($humanId)
{
    $statement = $GLOBALS['pdo']->query("SELECT COALESCE(SUM(`sum`), 0) as 'sum' FROM `finance_book` WHERE `human` = " . $humanId);

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row['sum'];
    }
    return "0";
}


//Получить текущий остаток кредита по ID хьюмана
function humanGetBalanceCreditById($humanId)
{
    $credit = humanGetCreditById($humanId);
    $sumPayment = humanGetSumPaymentById($humanId);
    return $credit - $sumPayment;
}

//Оплатить долг по id
function humanAddPaymentById($humanId, $sum, $note, $operator)
{
    $dateToday = getTodayDate();

    $sql = "INSERT INTO `finance_book` (`id`, `date`, `human`, `sum`, `note`, `operator`) VALUES (NULL, '" . getTodayDate() . "', '" . $humanId . "', '" . $sum . "', '" . $note . "', '" . $operator . "');";
    $query = $GLOBALS['pdo']->prepare($sql);
    $query->execute();
}


//Получить массив оплат
function humanGetArrayPaymentByHumanId($humanId)
{
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `finance_book` WHERE `human` = " . $humanId);
    $result = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
    }
    return $result;
}

function getWasteByWasteId($wasteId) {
    $statement = $GLOBALS['pdo']->query("SELECT * FROM `waste_book` WHERE `id` = " . $wasteId);
    $result = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $result[] = $row;
        if (isset($result['operator'])) {
            $result['operator'] = 'heelo';
        };
    }
    return $result;
}


//Получить историю оплат
function getHtmlHistoryPayment($humanId)
{
    ?>
    <div class="pay_history_block">
    <div class="history-list">
        <div class="history-list__title title">История оплат:</div>
    </div>
    <div class="finance__credit">ДОЛГ: <?= humanGetCreditById($humanId) ?> руб</div>
    <div class="finance__credit">ОПЛАТИЛ: <?= humanGetSumPaymentById($humanId) ?> руб</div>
    <div class="finance__credit">ОСТАЛОСЬ ОПЛАТИТЬ: <?= humanGetBalanceCreditById($humanId) ?> руб</div>
    <?php
    $arrayPayment = humanGetArrayPaymentByHumanId($humanId);
    foreach ($arrayPayment as $value) {
        ?>
        <div class="history-list__container title">
            <div class="history-list__item">Номер операции: <p><?= $value['id'] ?></p></div>
            <div class="history-list__item">Дата: <p><?= $value['date'] ?></p></div>
            <div class="history-list__item">Сумма оплаты: <p><?= $value['sum'] ?></p></div>
            <div class="history-list__item">Заметка: <p><?= $value['note'] ?></p></div>
            <div class="history-list__item">Оператор: <p><?= operatorGetNameById($value['operator']) ?></p></div>
        </div>
    <?php } ?></div><?php } ?>
