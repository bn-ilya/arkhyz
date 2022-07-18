"use strict"

//Созднаие и удаление доп. поля 'phone'
let phoneNum = 1;

function addPhone(phoneId = "", phoneNumber = "", note = "") {
    //wrap для инпута и вызова.
    let wrapInp = document.createElement("div");
    wrapInp.setAttribute('class', 'phone-input');
    wrapInp.setAttribute('id', `phone-input-${phoneNum}`)
    //создание инпуиа
    let phone = document.createElement("div");
    phone.setAttribute('id', `phone-${phoneNum}`);
    phone.setAttribute('class', `phone-wrapper`);
    document.querySelector('.phone-dlc').append(phone);
    //title создание
    let titlePh = document.createElement("div");
    titlePh.innerHTML = 'Телефон №' + `${phoneNum}`;
    titlePh.classList.add('reg-title');
    //wrap создание
    let wrap = document.createElement("div");
    wrap.setAttribute('class', `input-wrap`);
    wrap.setAttribute('id', `input-wrap-phone-${phoneNum}`);
    //Numbers создание
    let NumberPhone = document.createElement("input");
    NumberPhone.classList.add('reg-txt');
    NumberPhone.setAttribute('type', 'text');
    NumberPhone.setAttribute('value', phoneNumber);
    NumberPhone.setAttribute('onchange', "phoneOnBlur(this); ajaxChange('PHONE','CHANGE','" + phoneId + "',\'phone\',this.value)");
    NumberPhone.setAttribute('name', `phone-${phoneNum}`);
    NumberPhone.placeholder = "Номер телефона";
    //idPhone создание
    let idPhone = document.createElement("input");
    idPhone.classList.add('reg-txt');
    idPhone.setAttribute('type', 'hidden');
    idPhone.setAttribute('value', phoneId);
    idPhone.setAttribute('name', `phone-id-${phoneNum}`);
    idPhone.placeholder = "PHONE ID (ИЛЬЯ ЭТО НАДО СКРЫТЬ)";
    //PhoneNote создание
    let PhoneNote = document.createElement("input");
    PhoneNote.classList.add('reg-txt');
    PhoneNote.setAttribute('type', 'text');
    PhoneNote.setAttribute("value", note);
    PhoneNote.setAttribute('onchange', "ajaxChange('PHONE','CHANGE'," + phoneId + ",\'note\',this.value)");
    PhoneNote.setAttribute('name', `phone-note-${phoneNum}`);
    PhoneNote.placeholder = "Комментарий к телефону";
    //call создание
    let call = document.createElement("input");
    call.setAttribute('type', 'button');
    call.setAttribute('onclick', 'phoneCall(\'' + NumberPhone.name + '\')');
    call.setAttribute('id', `call-${phoneNum}`);
    call.setAttribute('value', '');
    call.setAttribute('class', 'phone-input__call title');
    //del создание
    let del = document.createElement("input");
    del.setAttribute('type', 'button');
    del.setAttribute('onclick', "ajaxChange(\'PHONE\',\'DELETE\'," + phoneId + "); delPhone(this)");
    del.setAttribute('id', `${phoneNum}`);
    del.setAttribute('class', 'delete-btn');
    //размещение созданных тегов

    document.querySelector(`#phone-${phoneNum}`).append(titlePh);
    document.querySelector(`#phone-${phoneNum}`).append(wrapInp);
    document.querySelector(`#phone-input-${phoneNum}`).append(NumberPhone);
    document.querySelector(`#phone-input-${phoneNum}`).append(idPhone);
    document.querySelector(`#phone-input-${phoneNum}`).append(call);
    document.querySelector(`#phone-${phoneNum}`).append(wrap);
    document.querySelector(`#input-wrap-phone-${phoneNum}`).append(PhoneNote);
    document.querySelector(`#input-wrap-phone-${phoneNum}`).append(del);

    phoneNum += 1;
}

function delPhone(button) {
    let parentElem = document.querySelector(`#phone-${button.id}`);
    parentElem.parentNode.removeChild(parentElem);
}

//Преобразует номер в формат 7ХХХХХХХХХХ (и убирает от мусора)
function phoneStandardView(phone) {
    if (phone.length == 0) //Если пришло пустое значение, возвращаем пустоту
        return ""
    phone = phone.replace(/\D+/g, "") //оставляем только цифры
    if (phone.length == 10 && phone.charAt(0) == "9") //добовляем 7
        phone = "7" + phone
    if (phone.charAt(0) != "7") //Если начинается не с 7
        phone = "7" + phone.substr(1, 10)
    if (phone.length != 11) //Не верная длинна номера
        phone = "ERROR"
    return phone
}

//Преобразует номер в формат +7 (ХХХ) ХХХ-ХХ-ХХ
function phoneBeautifulView(phone) {
    let result = ""
    phone = phoneStandardView(phone)
    if (phone.length != 11) {
        return phone
    } else {
        result += "+7 ("
        result += phone.substr(1, 3) + ") "
        result += phone.substr(4, 3) + "-"
        result += phone.substr(7, 2) + "-"
        result += phone.substr(9, 2)
        return result
    }
}

//Проверяет номер при редактировании
function phoneOnBlur(input) {
    let phone = phoneBeautifulView(input.value)
    if (phone == "ERROR") {
        alert("Недопустимый номер! Пожалуйста исправьте!")
    } else {
        input.value = phone
    }
}

//Вызов номера
function phoneCall(namePhone) {
    let form = document.getElementById("addHumanForm") //Получаем форму

    let phone = form.elements[namePhone].value
    document.location.href = "tel:+" + phoneStandardView(phone)
}

function ajaxAddPhone(human = "", phone = "", note = "") {
    if (parseInt(human) == '0') {
        addPhone()
    } else {
        $.ajax({
            url: "handler_change.php",
            type: "POST",
            data: {type: "PHONE", action: "ADD", phone: phone, note: note, human: human},
            success: function (data) {
                addPhone("" + parseInt(data));
            }
        });
    }
}