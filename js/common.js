"use strict"


//проверка заполнения и отправка на сервер

function addPaymentCheckAndSubmit(element) {
    let error = ""; //Здесь будут ошибки
    let form = document.getElementById("formFastPayment") //Получаем форму
    if (parseInt(form.elements["sum"].value) <= 0 || form.elements["sum"].value == "") //проверка суммы
        error += "Сумма не может быть пустой или меньше нуля\n"
    if (parseInt(form.elements["sum"].value) > parseInt(form.elements["balanceCredit"].value))
        error += "Сумма не может быть больше долга!!!\n"
    if (error == "") { //ОШИБОК НЕТ
        element.setAttribute('onclick', '');
        form.submit()

    } else { //В СЛУЧАЕ ОШИБОК
        alert(error)
    }
}


function submitCancel() {
    return false
}

function humanListOnClick(id) {
    document.location.href = "https://hmk-life.ru/r/add.php?id=" + id
}

function wasteListOnClick(id) {
    document.location.href = "https://hmk-life.ru/r/waste-pay.php?id=" + id
}

//Обработка ajax
//Виды типов type = "HUMAN", "PHONE"
//Виды action = "DELETE", "CHANGE", "ADD_CHILD"
function ajaxChange(type, action, id = "", key = "", value = "", oldValue = "", numHum = null) {

        $.ajax({
            url: "handler_change.php",
            type: "POST",
            data: {type: type, action: action, id: id, key: key, value: value},
            success: function (data) {
                humanArray = JSON.parse(data)

                // if (key == 'tent_status' && numHum != '') {
                //     if (document.getElementById("id_" + numHum).value != "")
                //         getStatusTent(document.getElementById("name_" + numHum).value, numHum)
                // }
                // if (key == 'car_status' && numHum != '') {
                //     if (document.getElementById("id_" + numHum).value != "")
                //         getStatusCar(document.getElementById("name_" + numHum).value, numHum)
                // }
            }
        });
}


function ageLimiter(element) {
    element.value = element.value.replace(/\D+/g, "") //оставляем только цифры

    if (parseInt(element.value) > 99) {
        element.value = 99;
    } else if (parseInt(element.value) < 0) {
        element.value = 0;
    }
    if (element.value.substr(0, 1) == "0" && element.value.length > 1) {
        element.value = element.value.substr(1, 1)
    }
}

function OnChange_datesOfStay(element, id) {
    //НОВЫЕ ДАННЫЕ ИЗ ЧЕК БОКСОВ
    let res = ""
    let numHum = element.name.substr(12, element.name.length - 12);
    for (let i = 1; i <= 4; i++) {
        let elCheckbox = document.getElementById(element.name.substr(0, 10) + i + "_" + numHum)
        if (elCheckbox.checked) {
            res += "1"
        } else {
            res += "0"
        }
    }

    humanArray[numHum]['dates_of_stay'] = res;
    creditCalculator()

}

//Запись куки КЛЮЧ ЗНАЧЕНИЕ ЧИСЛО_ДНЕЙ
function writeCookie(name, val, expires) {
    var date = new Date;
    date.setDate(date.getDate() + expires);
    document.cookie = name + "=" + val + "; path=/; expires=" + date.toUTCString();
}

//ПОЛУЧИТЬ КУКИ
function readCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function selectDefaultOperator(el) {
    if (el.id != "") {
        writeCookie('operator', el.id, 90)
    }
}

//Определяю какой чекбокс активен
function checkListen() {
    let form = document.getElementById("addHumanForm") //Получаем форму

    for (let i = 0; i <= 100; i++) {
        if (document.getElementById('name_' + i) != null) {
            //CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR//CAR

            //Получаем чекбоксы
            let CAR_USE = document.getElementById("checkCar_USE_" + i)
            let CAR_NEED = document.getElementById("checkCar_NEED_" + i)
            let CAR_DOES_NOT_NEED = document.getElementById("checkCar_DOES_NOT_NEED_" + i)
            let CAR_PROVIDES = document.getElementById("checkCar_PROVIDES_" + i)

            //CAR Чекбокс использует
            if (CAR_USE.checked) {
                CAR_NEED.checked = false
                CAR_DOES_NOT_NEED.checked = false
                CAR_PROVIDES.checked = false

                document.getElementById("labelСheck_car_not_pay_" + i).classList.remove('hidden');

                humanArray[i]["car_status"] = "USE";
                humanArray[i]["car_places"] = 0;
                if(document.getElementById("car_use_id_" + i).value != '')
                    humanArray[i]["car_use_id"] = document.getElementById("car_use_id_" + i).value;

                document.getElementById("car_use_id_" + i).hidden = false
                document.getElementById("car_places_" + i).hidden = true
                getCarProvides(document.getElementById("car_use_id_" + i),humanArray[i]['car_use_id'], i)
            }

            //CAR Чекбокс предоставляет
            else if (CAR_PROVIDES.checked) {
                CAR_NEED.checked = false
                CAR_DOES_NOT_NEED.checked = false
                CAR_USE.checked = false

                document.getElementById("labelСheck_car_not_pay_" + i).classList.remove('hidden');

                humanArray[i]["car_status"] = "PROVIDES";
                humanArray[i]["car_use_id"] = humanArray[i]["name"];
                humanArray[i]["car_places"] = document.getElementById("car_places_" + i).value;

                document.getElementById("car_use_id_" + i).hidden = true
                document.getElementById("car_places_" + i).hidden = false
                getStatusCar(document.getElementById("name_" + i).value, i)
            }
            //CAR Чекбокс нуждается
            else if (CAR_NEED.checked) {
                CAR_PROVIDES.checked = false
                CAR_DOES_NOT_NEED.checked = false
                CAR_USE.checked = false

                document.getElementById("labelСheck_car_not_pay_" + i).classList.remove('hidden');

                humanArray[i]["car_status"] = "NEED";
                humanArray[i]["car_places"] = 0;
                humanArray[i]["car_use_id"] = "";

                document.getElementById("car_use_id_" + i).hidden = true
                document.getElementById("car_places_" + i).hidden = true

                document.getElementById("titleCarInfo_" + i).innerHTML = "";
            }
            //CAR Чекбокс не нуждается
            else if (CAR_DOES_NOT_NEED.checked) {
                CAR_NEED.checked = false
                CAR_PROVIDES.checked = false
                CAR_USE.checked = false

                document.getElementById("labelСheck_car_not_pay_" + i).classList.add('hidden');
                document.getElementById("car_not_pay_" + i).checked = false
                humanArray[i]["car_not_pay"] = '1';

                humanArray[i]["car_status"] = "DOES_NOT_NEED";
                humanArray[i]["car_places"] = 0;
                humanArray[i]["car_use_id"] = "";

                document.getElementById("car_use_id_" + i).hidden = true
                document.getElementById("car_places_" + i).hidden = true

                document.getElementById("titleCarInfo_" + i).innerHTML = "";
            }

            console.log(humanArray[i]["car_status"])


            //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT //TENT


            //Получаем чекбоксы
            let TENT_USE = document.getElementById("checkTent_USE_" + i)
            let TENT_NEED = document.getElementById("checkTent_NEED_" + i)
            let TENT_DOES_NOT_NEED = document.getElementById("checkTent_DOES_NOT_NEED_" + i)
            let TENT_PROVIDES = document.getElementById("checkTent_PROVIDES_" + i)


            //TENT Чекбокс использует
            if (TENT_USE.checked) {
                TENT_NEED.checked = false
                TENT_DOES_NOT_NEED.checked = false
                TENT_PROVIDES.checked = false

                humanArray[i]["tent_status"] = "USE";
                humanArray[i]["tent_places"] = 0;
                if(document.getElementById("tent_use_id_" + i).value != ''){
                    humanArray[i]["tent_use_id"] = document.getElementById("tent_use_id_" + i).value;
                }

                document.getElementById("tent_use_id_" + i).hidden = false
                document.getElementById("tent_places_" + i).hidden = true
                getTentProvides(document.getElementById("tent_use_id_" + i),humanArray[i]['tent_use_id'], i)
            }
            //TENT Чекбокс предоставляет
            else if (TENT_PROVIDES.checked) {
                TENT_NEED.checked = false
                TENT_DOES_NOT_NEED.checked = false
                TENT_USE.checked = false

                humanArray[i]["tent_status"] = "PROVIDES";
                humanArray[i]["tent_use_id"] = humanArray[i]["name"];
                humanArray[i]["tent_places"] = document.getElementById("tent_places_" + i).value;

                document.getElementById("tent_use_id_" + i).hidden = true
                document.getElementById("tent_places_" + i).hidden = false

                getStatusTent(document.getElementById("name_" + i).value, i)

            }
            //TENT Чекбокс нуждается
            else if (TENT_NEED.checked) {
                TENT_PROVIDES.checked = false
                TENT_DOES_NOT_NEED.checked = false
                TENT_USE.checked = false

                humanArray[i]["tent_status"] = "NEED";
                humanArray[i]["tent_use_id"] = "";
                humanArray[i]["tent_places"] = 0;

                document.getElementById("tent_use_id_" + i).hidden = true
                document.getElementById("tent_places_" + i).hidden = true

                document.getElementById("titleTentInfo_" + i).innerHTML = "";
            }
            //TENT Чекбокс не нуждается
            else if (TENT_DOES_NOT_NEED.checked) {
                TENT_NEED.checked = false
                TENT_PROVIDES.checked = false
                TENT_USE.checked = false

                humanArray[i]["tent_status"] = "DOES_NOT_NEED";
                humanArray[i]["tent_use_id"] = "";
                humanArray[i]["tent_places"] = 0;

                document.getElementById("tent_use_id_" + i).hidden = true
                document.getElementById("tent_places_" + i).hidden = true

                document.getElementById("titleTentInfo_" + i).innerHTML = "";
            }
            creditCalculator()

        }

    }
}

function getStatusCar(humanName, humNum) {
    if (humanName != "") {
        //document.getElementById("titleCarInfo_" + humNum).innerHTML = "Загрузка информации..."
        $.ajax({
            url: "handler_get_data.php",
            type: "POST",
            data: {type: "GET_STATUS_CAR", name: humanName},
            success: function (data) {
                document.getElementById("titleCarInfo_" + humNum).innerHTML = data;
            }
        });
    }
}

function getStatusTent(humanName, humNum) {
    if (humanName != "") {
        //document.getElementById("titleTentInfo_" + humNum).innerHTML = "Загрузка информации..."
        $.ajax({
            url: "handler_get_data.php",
            type: "POST",
            data: {type: "GET_STATUS_TENT", name: humanName},
            success: function (data) {
                document.getElementById("titleTentInfo_" + humNum).innerHTML = data;
            }
        });
    }
}

function createElement(placePaste = null, tagEl = "", classEl = "", nameEl = "", idEl = "", valueEl = "", typeEl = "", onchangeEl = "", oninputEl = "", onclickEl = "", hiddenEl = false) {
    let resElement = document.createElement(tagEl)
    if (classEl != "")
        resElement.setAttribute('class', classEl)
    if (nameEl != "")
        resElement.setAttribute('name', nameEl)
    if (idEl != "")
        resElement.setAttribute('id', idEl)
    if (valueEl != "")
        resElement.setAttribute('value', valueEl)
    if (typeEl != "")
        resElement.setAttribute('type', typeEl)
    if (onchangeEl != "")
        resElement.setAttribute('onchange', onchangeEl)
    if (oninputEl != "")
        resElement.setAttribute('oninput', oninputEl)
    if (onclickEl != "")
        resElement.setAttribute('onclick', onclickEl)
    resElement.hidden = hiddenEl

    if (placePaste != null)
        placePaste.append(resElement)

    return resElement

}

