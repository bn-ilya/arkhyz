"use strict"
function searchAjax(where) {
    $.ajax({
        url: "handler_search.php",
        type: "POST",
        data: {where: where},
        success: function (data) {
            countSearchProcess--;
            if (countSearchProcess<=0){
            document.getElementById('gif_load').hidden = true
            }
            let list = document.getElementById('list')
            list.innerHTML=data


            if (countSearchProcess<0){
                countSearchProcess = 0
            }
            if (data.trim() ==""){
                list.innerHTML="<div class='bad__title title'>Ничего не найдено!<div>"
                list.innerHTML+="<div class='add__title title'>Добавить \""+document.getElementById('searchText').value +"\"?<div>"
                //del создание
                let btnNew = document.createElement("input");
                btnNew.setAttribute('type', 'button');
                btnNew.setAttribute('onclick', "hrefAddPhpPreName()");
                btnNew.setAttribute('id', 'btn_new');
                btnNew.setAttribute('value', 'Добавить');
                btnNew.setAttribute('class', 'delete-btn_long_margin delete-btn_long title');
                list.append(btnNew)
            }
        }
    });
}


//ПОИСК
let countSearchProcess = 0;
function searchingProcessing(text) {
    countSearchProcess++;
    document.getElementById('gif_load').hidden = false
    let where = getWhere(text)
    searchAjax(where)

    // if (text == "") {
    //     alert("Введите имя или номер участника");
    // } else {
    //     document.location.href = "https://hmk-life.ru/r/list.php?where=" + result;
    // }
}

function getWhere(text) {
    text = text.trim();
    let result = "";

    if (text == "")
        return ""

    text = text.replace(/\s+/g, ' ').trim().toUpperCase();
    if (!isNaN(Number(text))) {
        result += " WHERE `id` = " + text;
    } else {

        var arrayWorld = text.split(" ");
        arrayWorld.forEach(function (item, i, arr) {
            if (i == 0) {
                result += " WHERE `name` LIKE '%" + item + "%' ";
            } else {
                result += " AND `name` LIKE '%" + item + "%' ";
            }
        })
    }
    return result
}

function hrefAddPhpPreName() {
    document.location.href = 'https://hmk-life.ru/r/add.php?preName='+document.getElementById('searchText').value.trim()
}