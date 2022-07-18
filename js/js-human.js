"use strict"

//Создание информационных полей для ХЬЮМАНА
function addInputHuman(parent_div, humanData, humNum) {
    //id создание
    let id_input = createElement(parent_div, 'input', 'reg-txt', "id_" + humNum, "id_" + humNum, humanData['id'], 'hidden');
    //name создание
    let name_input = createElement(parent_div, 'input', 'reg-txt', "name_" + humNum, "name_" + humNum,
        humanData['name'], 'text', "this.value = this.value.replace(/\\s+/g, ' ').trim();humanArray["+humNum+"]['name']=this.value; humanArraySendOnServer()", )
    name_input.placeholder = "Имя, фамилия";
    //ВОЗРАСТ СОЗДАНИЕ
    let age_input = createElement(parent_div, 'input', 'reg-txt', "age_" + humNum, "age_" + humNum,
        humanData['age'], 'number', "humanArray["+humNum+"]['age']=this.value; humanArraySendOnServer(), creditCalculator();", "ageLimiter(this);");
    age_input.placeholder = "Возраст";
    //CREDIT
    let credit_input = createElement(parent_div, 'input', "", "credit_" + humNum, "credit_" + humNum, "", 'hidden')

    //БЛОК ЧЕКБОКСОВ
    let div_checkbox = createElement(parent_div, 'div', 'reg__checkbox')
    //ДОБАВЛЕНИЕ ЧЕКБОКСОВ ДНИ
    let div_checkbox_dayofstay = createElement(div_checkbox, 'div', 'reg__check-item')
    //title day of stay
    let div_dayofstay_title = createElement(div_checkbox_dayofstay, 'div', 'reg__check-title title')
    div_dayofstay_title.innerHTML = 'Дни:';
    //группа для двух чекбоксов дат
    let div_group_dateofstay_checkbox = createElement(div_checkbox_dayofstay, 'div', 'reg__date-of-stay')

    //ДАТЫ
    for (let i = 1; i <= 4; i++) {
        let input_checkbox_date = createElement(div_group_dateofstay_checkbox, 'input', 'check__default',
            'check_date' + i + '_' + humNum, 'check_date' + i + '_' + humNum, '1', 'checkbox',
            "OnChange_datesOfStay(this);")
        if (humanData['dates_of_stay'].charAt(i - 1) == "0")
            input_checkbox_date.checked = false
        else
            input_checkbox_date.checked = true

        let label_checkbox_date = createElement(div_group_dateofstay_checkbox, 'label', 'check')
        label_checkbox_date.setAttribute('for', 'check_date' + i + '_' + humNum)
        label_checkbox_date.innerHTML += 21 + i
    }
    if (humanData['dates_of_stay'].length == 4) {
        for (let i = 1; i <= 4; i++) {
            if (humanData['dates_of_stay'].charAt(i - 1) == "0") {
                document.getElementById('check_date' + i + '_' + humNum).checked = false
            }
        }
    }
    //ДОБОВЛЕНИЕ ЧЕКБОКСОВ ПОЛ
    let div_checkbox_gender = createElement(div_checkbox, 'div', 'reg__check-item')
    //title МЖ
    let div_gender_title = createElement(div_checkbox_gender, 'div', 'reg__check-title title')
    div_gender_title.innerHTML = 'М/Ж:';
    //группа для двух чекбоксов м/ж
    let div_group_gender_checkbox = createElement(div_checkbox_gender, 'div', 'reg__gender')

    //MALE CHECKBOX
    let input_checkbox_male = createElement(
        div_group_gender_checkbox, 'input', 'check__default_male', 'checkbox_gender_' + humNum,
        'checkbox_gender_male_' + humNum, 'MALE', 'radio',
        "humanArray["+humNum+"]['gender']=this.value; humanArraySendOnServer()")
    if (humanData['gender'] == "MALE" || humanData['gender'] == "")
        input_checkbox_male.checked = true;

    let label_checkbox_male = createElement(div_group_gender_checkbox, 'label', 'check')
    label_checkbox_male.setAttribute('for', 'checkbox_gender_male_' + humNum)

    //FEMALE CHECKBOX
    let input_checkbox_female = createElement(div_group_gender_checkbox, 'input', 'check__default_female',
        'checkbox_gender_' + humNum, 'checkbox_gender_female_' + humNum,
        'FEMALE', 'radio', "humanArray["+humNum+"]['gender']=this.value; humanArraySendOnServer()")
    if (humanData['gender'] == "FEMALE")
        input_checkbox_female.checked = true;

    let label_checkbox_female = createElement(div_group_gender_checkbox, 'label', 'check')
    label_checkbox_female.setAttribute('for', 'checkbox_gender_female_' + humNum)


    //МАШИНЫ!!!
    //Основная группа
    let carGroup = createElement(parent_div, 'div', "check-car title");
    //Заголовок
    let titleCar = createElement(carGroup, 'div', "car-title title");
    titleCar.innerHTML = "Машина"

    //Группа первая колонка чекбоксов
    let oneColumnCar = createElement(carGroup, 'div', "check-column")

    //Группа для чекбокса НЕ НУЖДАЕТСЯ
    let checkContainerCar_DOES_NOT_NEED = createElement(oneColumnCar, 'div', "check-container")
    //чекбокс НЕ НУЖДАЕТСЯ
    let checkboxCar_DOES_NOT_NEED = createElement(checkContainerCar_DOES_NOT_NEED, 'input', "check__default_car check__default",
        "car_status_" + humNum, "checkCar_DOES_NOT_NEED_" + humNum, "DOES_NOT_NEED", "radio",
        "checkListen()")
    checkboxCar_DOES_NOT_NEED.checked = (humanData['car_status'] == "" || humanData['car_status'] == "DOES_NOT_NEED") ? true : false;
    let labelCar_DOES_NOT_NEED = createElement(checkContainerCar_DOES_NOT_NEED, 'label', "title__check check")
    labelCar_DOES_NOT_NEED.setAttribute('for', "checkCar_DOES_NOT_NEED_" + humNum)
    labelCar_DOES_NOT_NEED.innerHTML = "Не нуждается"

    //Группа для чекбокса НУЖДАЕТСЯ
    let checkContainerCar_NEED = createElement(oneColumnCar, 'div', "check-container")
    //чекбокс НУЖДАЕТСЯ
    let checkboxCar_NEED = createElement(checkContainerCar_NEED, 'input', "check__default_car check__default",
        "car_status_" + humNum, "checkCar_NEED_" + humNum, "NEED", "radio",
        "checkListen()")
    checkboxCar_NEED.checked = (humanData['car_status'] == "NEED") ? true : false;
    let labelCar_NEED = createElement(checkContainerCar_NEED, 'label', "title__check check")
    labelCar_NEED.setAttribute('for', "checkCar_NEED_" + humNum)
    labelCar_NEED.innerHTML = "Нуждается"

    //Группа первая колонка чекбоксов
    let twoColumnCar = createElement(carGroup, 'div', "check-column")

    //Группа для чекбокса ИСПОЛЬЗУЕТ
    let checkContainerCar_USE = createElement(twoColumnCar, 'div', "check-container")
    //чекбокс ИСПОЛЬЗУЕТ
    let checkboxCar_USE = createElement(checkContainerCar_USE, 'input', "check__default_car check__default",
        "car_status_" + humNum, "checkCar_USE_" + humNum, "USE", "radio",
        "checkListen()")
    checkboxCar_USE.checked = (humanData['car_status'] == "USE") ? true : false;
    let labelCar_USE = createElement(checkContainerCar_USE, 'label', "title__check check")
    labelCar_USE.setAttribute('for', "checkCar_USE_" + humNum)
    labelCar_USE.innerHTML = "Использует"

    //Группа для чекбокса ПРЕДОСТАВЛЯЕТ
    let checkContainerCar_PROVIDES = createElement(twoColumnCar, 'div', "check-container")
    //чекбокс НУЖДАЕТСЯ
    let checkboxCar_PROVIDES = createElement(checkContainerCar_PROVIDES, 'input', "check__default_car check__default",
        "car_status_" + humNum, "checkCar_PROVIDES_" + humNum, "PROVIDES", "radio",
        "checkListen()")
    checkboxCar_PROVIDES.checked = (humanData['car_status'] == "PROVIDES") ? true : false;
    let labelCar_PROVIDES = createElement(checkContainerCar_PROVIDES, 'label', "title__check check")
    labelCar_PROVIDES.setAttribute('for', "checkCar_PROVIDES_" + humNum)
    labelCar_PROVIDES.innerHTML = "Водитель"

    //Поле количество мест
    let car_places_input = createElement(carGroup, 'input', "reg-txt", "car_places_" + humNum,
        "car_places_" + humNum, humanData['car_places'], "", "checkListen()","", "", true)
    car_places_input.setAttribute('placeholder', "Кол-во свободных мест")

    //Поле с кем едет
    let car_use_wrapper = createElement(carGroup, 'div', 'operator-wrapper')
    let car_use_id = createElement(car_use_wrapper, "select", "select title", "car_use_id_" + humNum,
        "car_use_id_" + humNum, humanData['car_use_id'], "", "checkListen()", "", "", true)
    //car инфо
    let titleCarInfo = createElement(carGroup, 'div', 'reg-title', "titleCarInfo_" + humNum, "titleCarInfo_" + humNum)
    //ЧЕКБОКС НЕ ПЛАТИТ ЗА БЕНЗ
    let check_car_not_pay = createElement(parent_div,"input", "check__default_car check__default", "car_not_pay_"+humNum,
        "car_not_pay_"+humNum,'','checkbox',"humanArray["+humNum+"]['car_not_pay']=(this.checked)?'1':'0'; creditCalculator();")
    check_car_not_pay.checked = humanData["car_not_pay"] == "1"
    let labelСheck_car_not_pay = createElement(parent_div, 'label', "problem__check check", "labelСheck_car_not_pay_"+humNum, "labelСheck_car_not_pay_"+humNum)
    labelСheck_car_not_pay.setAttribute('for', "car_not_pay_"+humNum)
    labelСheck_car_not_pay.innerHTML = "Не платит за бенз (-500 руб.)"

//////////////////////////////////////////////////////////////////
    //ПАЛАТКИ!!!
    //Основная группа
    let tentGroup = createElement(parent_div, 'div', "check-car title");
    //Заголовок
    let titleTent = createElement(tentGroup, 'div', "car-title title");
    titleTent.innerHTML = "Палатка"

    //Группа первая колонка чекбоксов
    let oneColumnTent = createElement(tentGroup, 'div', "check-column")

    //Группа для чекбокса НЕ НУЖДАЕТСЯ
    let checkContainerTent_DOES_NOT_NEED = createElement(oneColumnTent, 'div', "check-container")
    //чекбокс НЕ НУЖДАЕТСЯ
    let checkboxTent_DOES_NOT_NEED = createElement(checkContainerTent_DOES_NOT_NEED, 'input', "check__default_car check__default",
        "tent_status_" + humNum, "checkTent_DOES_NOT_NEED_" + humNum, "DOES_NOT_NEED", "radio",
        "checkListen()")
    checkboxTent_DOES_NOT_NEED.checked = (humanData['tent_status'] == "" || humanData['tent_status'] == "DOES_NOT_NEED") ? true : false;
    let labelTent_DOES_NOT_NEED = createElement(checkContainerTent_DOES_NOT_NEED, 'label', "title__check check")
    labelTent_DOES_NOT_NEED.setAttribute('for', "checkTent_DOES_NOT_NEED_" + humNum)
    labelTent_DOES_NOT_NEED.innerHTML = "Не нуждается"

    //Группа для чекбокса НУЖДАЕТСЯ
    let checkContainerTent_NEED = createElement(oneColumnTent, 'div', "check-container")
    //чекбокс НУЖДАЕТСЯ
    let checkboxTent_NEED = createElement(checkContainerTent_NEED, 'input', "check__default_car check__default",
        "tent_status_" + humNum, "checkTent_NEED_" + humNum, "NEED", "radio",
        "checkListen()")
    checkboxTent_NEED.checked = (humanData['tent_status'] == "NEED") ? true : false;
    let labelTent_NEED = createElement(checkContainerTent_NEED, 'label', "title__check check")
    labelTent_NEED.setAttribute('for', "checkTent_NEED_" + humNum)
    labelTent_NEED.innerHTML = "Нуждается"

    //Группа первая колонка чекбоксов
    let twoColumnTent = createElement(tentGroup, 'div', "check-column")

    //Группа для чекбокса ИСПОЛЬЗУЕТ
    let checkContainerTent_USE = createElement(twoColumnTent, 'div', "check-container")
    //чекбокс ИСПОЛЬЗУЕТ
    let checkboxTent_USE = createElement(checkContainerTent_USE, 'input', "check__default_car check__default",
        "tent_status_" + humNum, "checkTent_USE_" + humNum, "USE", "radio",
        "checkListen()")
    checkboxTent_USE.checked = (humanData['tent_status'] == "USE") ? true : false;
    let labelTent_USE = createElement(checkContainerTent_USE, 'label', "title__check check")
    labelTent_USE.setAttribute('for', "checkTent_USE_" + humNum)
    labelTent_USE.innerHTML = "Использует"

    //Группа для чекбокса ПРЕДОСТАВЛЯЕТ
    let checkContainerTent_PROVIDES = createElement(twoColumnTent, 'div', "check-container")
    //чекбокс НУЖДАЕТСЯ
    let checkboxTent_PROVIDES = createElement(checkContainerTent_PROVIDES, 'input', "check__default_car check__default",
        "tent_status_" + humNum, "checkTent_PROVIDES_" + humNum, "PROVIDES", "radio",
        "checkListen()")
    checkboxTent_PROVIDES.checked = (humanData['tent_status'] == "PROVIDES") ? true : false;
    let labelTent_PROVIDES = createElement(checkContainerTent_PROVIDES, 'label', "title__check check")
    labelTent_PROVIDES.setAttribute('for', "checkTent_PROVIDES_" + humNum)
    labelTent_PROVIDES.innerHTML = "Есть палатка"

    //Поле количество мест
    let tent_places_input = createElement(tentGroup, 'input', "reg-txt", "tent_places_" + humNum,
        "tent_places_" + humNum, humanData['tent_places'], "",  "checkListen();", "","", true)
    tent_places_input.setAttribute('placeholder', "Кол-во свободных мест")
    //Поле с кем в палатке
    let tent_use_wrapper = createElement(tentGroup, 'div', 'operator-wrapper')
    let tent_use_id = createElement(tent_use_wrapper, "select", "select title", "tent_use_id_" + humNum,
        "tent_use_id_" + humNum, humanData['tent_use'], "", "checkListen();", "", "", true)
    //tent инфо
    let titleTentInfo = createElement(tentGroup, 'div', 'reg-title', "titleTentInfo_" + humNum, "titleTentInfo_" + humNum)


}


let rBefore = document.querySelector('.reg-dlc');
let humNum = 1;

//Создание ЧАЙЛДА
function addChild(humanData) {
    let divAllChild = document.getElementById('reg-dlc');
    //Основная группа для чайлда
    let child = createElement(divAllChild, 'div', 'reg-human', "", "child_" + humNum, "human-" + humNum)

    //Заголовок
    let title = createElement(child, 'div', 'reg-title')
    title.innerHTML = 'Подчиненный участник';

    //Добавление стандартных инпутов
    addInputHuman(child, humanData, humNum)
    checkListen() //Обновляем чекбоксы
    //Кнопка удаления
    let del = createElement(child, 'input',
        'delete-btn_long', "", humNum, 'Удалить', 'button')
    del.setAttribute('onclick', "ajaxChange(\'HUMAN\',\'DELETE\'," + humanData['id'] + "); delHuman('" + humNum + "');")

    //wrap создание
    let wrap = createElement(child, 'div',
        `input-wrap`, "", "input-wrap-human-" + humNum)

    humNum++
}


//проверка заполнения и отправка на сервер
function addHumanCheckAndSubmit(element) {
    let error = ""; //Здесь будут ошибки
    let form = document.getElementById("addHumanForm") //Получаем форму

    for (let i = 0; i <= 100; i++) {
        if (form.elements["name_" + i] != null && form.elements["name_" + i].value.length == 0) //проверка имени
            error += "Имя не заполнено\n"
        if (form.elements["age_" + i] != null && form.elements["age_" + i].value.length == 0) //проверка возраста
            error += "Возраст не заполнен\n"
    }

    //Проверка телефонов
    let phoneName = "phone";
    for (let i = 1; i < 100; i++) {
        let phoneElement = form.elements[phoneName];//Получаем элемент
        if (phoneElement != undefined) {//Если элемент существует
            let phone = phoneBeautifulView(phoneElement.value)//Придаем стандартный вид номеру
            if (phone == "ERROR") { //Если не удалось привести к станддартному виду
                error += "Ошибка в " + i + " номере телефона\n"
            } else if (phone == "" && i > 1) { //Если доп.номер пустой
                error += i + " номер телефона пустой!\n"
            } else //заменяем некрасивый номер на стандартный
                phoneElement.value = phone
            phoneName = "phone-" + i

        } else break //Если элемент не существуем цикл прерывается
    }//Проверка телефонов окончена


    if (error == "") { //ОШИБОК НЕТ
        element.setAttribute('onclick', '');
        form.submit()
    } else { //В СЛУЧАЕ ОШИБОК
        alert(error)
    }
}

//Удаление чайлда
function delHuman(num) {
    let parentElem = document.getElementById("child_" + num);
    parentElem.parentNode.removeChild(parentElem);
    creditCalculator()
}


function ajaxAddChild(parent = 0, name = "", age = "") {

        $.ajax({
            url: "handler_change.php",
            type: "POST",
            data: {type: "HUMAN", action: "ADD_CHILD", parent: parent, name: name, age: age},
            success: function (data) {
                humanArray = JSON.parse(data)
                addChild(humanArray[humanArray.length - 1]);
            }
        });
}

function changeInputFromAllChild(element) {
    if (element.name.substr(element.name.length - 2, 2) == "_0") {
        let form = document.getElementById("addHumanForm") //Получаем форму
        for (let i = 1; i < 100; i++) {
            let searchElement = form.elements[element.name.substr(0, element.name.length - 1) + i]
            if (searchElement != undefined) {
                if (element.type == "checkbox")
                    searchElement.checked = element.checked
                else
                    searchElement.value = element.value
                searchElement.onchange();
            }
        }
    }
}

function getBlankHumanArray() {
    let humanArray = new Array(1);
    humanArray[0] = {
        'id': '0', 'name': '', 'age': '', 'gender': '', 'note': '', 'parent': '',
        'credit': '', 'donation': '', 'car_status': '', 'car_places': '', 'car_use_id': '', 'tent_status': '',
        'tent_places': '', 'tent_use_id': '', 'church': '', 'problem': '', 'operator': '',
        'dates_of_stay': '1111', 'phone': new Array()
    };
    return humanArray
}


function getTentProvides(tent_use_id, value, numHum) {
    console.log("!!!!!!!!!!!!!!!" +value)

    $.ajax({
        url: "handler_get_data.php",
        type: "POST",
        data: {type: "TENT_PROVIDES", value: value},
        success: function (data) {
            //     let form = document.getElementById("addHumanForm") //Получаем форму
            tent_use_id.innerHTML = data
            getStatusTent(document.getElementById("tent_use_id_" + numHum).value, numHum)

        }
    });
}

function getCarProvides(car_use_id, value, numHum) {
    $.ajax({
        url: "handler_get_data.php",
        type: "POST",
        data: {type: "CAR_PROVIDES", value: value},
        success: function (data) {
            car_use_id.innerHTML = data
            getStatusCar(document.getElementById("car_use_id_" + numHum).value, numHum)

        }
    });
}

let thread = 0;
function humanArraySendOnServer(){
    thread++;
    let threadText = "[Поток №"+thread+"] ";
    console.log(threadText + "Отправка данных на сервер...") //humanArray = data;
    $.ajax({
        url: "handler_send_data.php",
        type: "POST",
        data: {data: JSON.stringify(humanArray)},
        success: function (data) {
            if(data.lastIndexOf("<br />") == -1) //Если нет PHP ошибок
               console.log(threadText+"Данные успешно отправлены!")
            else {
                console.log(threadText+"ОШИБКА ОТПРАВКИ ДАННЫХ!!!")
                console.log(data)
            }
        }
    });
}

