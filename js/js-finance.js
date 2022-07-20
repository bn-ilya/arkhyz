"use strict"

function creditCalculator() {
    let totalCredit = 0;
    for (let i = 0; i < 100; i++) {
        let creditElement = document.getElementById("credit_" + i);
        if (creditElement != null) {
            let thisTotalCredit = 0;

            let date1 = document.getElementById("check_date1_" + i).checked;
            let date2 = document.getElementById("check_date2_" + i).checked;
            let date3 = document.getElementById("check_date3_" + i).checked;
            let date4 = document.getElementById("check_date4_" + i).checked;


            let age = parseInt(document.getElementById("age_" + i).value);
            if (age >= 0 && age < 2)
                thisTotalCredit += 0
            else if (age >= 2 && age <= 5) {
                if (date1 == true)
                    thisTotalCredit += 175
                if (date2 == true)
                    thisTotalCredit += 175
                if (date3 == true)
                    thisTotalCredit += 175
                if (date4 == true)
                    thisTotalCredit += 175
            } else if (age >= 6 && age <= 12) {
                if (date1 == true)
                    thisTotalCredit += 300
                if (date2 == true)
                    thisTotalCredit += 300
                if (date3 == true)
                    thisTotalCredit += 300
                if (date4 == true)
                    thisTotalCredit += 300
            } else if (age >= 13) {
                if (date1 == true)
                    thisTotalCredit += 375
                if (date2 == true)
                    thisTotalCredit += 375
                if (date3 == true)
                    thisTotalCredit += 375
                if (date4 == true)
                    thisTotalCredit += 375
            } else {
                thisTotalCredit += 99999
            }

            //БЕНЗ
            if(document.getElementById("checkCar_USE_" + i).checked || document.getElementById("checkCar_NEED_" + i).checked || document.getElementById("checkCar_PROVIDES_" + i).checked){
                if(document.getElementById("car_not_pay_" + i).checked == false)
                thisTotalCredit += 500
            }
            creditElement.value = thisTotalCredit;
            totalCredit += thisTotalCredit;
        }
    }
    if (totalCredit < 99999 && totalCredit >= 0) {
        let donation = parseInt(document.getElementById("donation_0" ).value)
        if(isNaN(donation)){
        }else {
            totalCredit += donation
        }
        document.getElementById("credit_0").value = totalCredit
        humanArray[0]['credit'] = totalCredit
        document.getElementById("total").innerHTML = totalCredit;
    } else {
        document.getElementById("total").innerHTML = " error ";
    }

    //Отправляем данные на сервер
    humanArraySendOnServer()

}

function donationLimiter(element) {
    element.value = element.value.replace(/\D+/g, "") //оставляем только цифры

    if (parseInt(element.value) > 100000) {
        element.value = 100000;
    } else if (parseInt(element.value) < 0) {
        element.value = 0;
    }
    if (element.value.substr(0, 1) == "0" && element.value.length > 1) {
        element.value = element.value.substr(1, 1)
    }
}
