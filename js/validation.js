const rObject = $("#select_r")
const xObject = $("#value_x")

function validateX() {
    let error_x = document.getElementById("text_error_x")
    error_x.textContent = "Ошибка ввода значнеия координаты X: "
    if (xObject.val()) {
        let new_x = Number.parseInt(xObject.val());
        if (!isNaN(new_x)) {
            if (new_x > -3 && new_x < 5) {
                error_x.textContent = "";
                return true;
            } else {
                error_x.textContent += "число не входит в диапозон данных"
            }
        } else {
            error_x.textContent += "введено не число"
        }
    } else {
        error_x.textContent += "данные не введены"
    }
    error_x.innerHTML += "<br>"

    return false;
}

function validateY() {
    let error_y = document.getElementById("text_error_y")
    let checkboxes = $("input[type='checkbox']:checked")
    if (checkboxes.length === 0) {
        error_y.innerHTML = "Ошибка выбора значения координаты Y: никакое из значений не выбрано <br>"
        return false
    } else {
        error_y.textContent = ""
        return true
    }
}

function validateR() {
    let error_r = document.getElementById("text_error_r")
    if (rObject.val() === null) {
        error_r.textContent = "Ошибка выбора значения параметра R: никакое из значений не выбрано"
        return false
    } else {
        error_r.textContent = ""
        return true
    }
}

//add change listener to X
xObject.change(() => {
    if(validateX()){
        xObject.removeClass("error_value")
        xObject.addClass("acceptable_value")
    } else {
        xObject.removeClass("acceptable_value")
        xObject.addClass("error_value")
    }
})

//add change listener to Y
$("input[type='checkbox']").change(() => {
    validateY()
})

//add change listener to R
rObject.change(() => {
    if(validateR()){
        rObject.removeClass("error_value")
        rObject.addClass("acceptable_value")
    } else {
        rObject.removeClass("acceptable_value")
        rObject.addClass("error_value")
    }
})

function clearTable() {
    $("#add_table").empty()
}

/*function setRowsWithinJsonString(jsonString) {
    clearRows()
    let jsonObject = JSON.parse(jsonString)
    jsonObject.forEach((element) => {
        let str = "<tr class = 'response_table_values'>"
        str += "<td>" + element.x + "</td>"
        str += "<td>" + element.y + "</td>"
        str += "<td>" + element.r + "</td>"
        if (element.hit === "true"){
            str += "<td class = 'response_table_value_hit_true'>" + "Попало" + "</td>"
        } else {
            str += "<td class = 'response_table_value_hit_false'>" + "Не попало" + "</td>"
        }
        str += "<td>" + element.date + "</td>"
        str += "<td>" + element.time + "</td>"
        str += "</tr>"
        $("#response_table").append(str)
    })

}*/

function sendRequest(y) {
    $.ajax({
        url: "php/index.php",
        type: "get",
        data: {
            xVar: xObject.val().substring(0, 10),
            yVar: y,
            rVar: rObject.val(),
        },
        success: function (data) {
            //setRowsWithinJsonString(data)
            clearTable()
            $("#add_table").html(data)
            $("#request_text").text("Данные обработаны!")
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#request_text").text("Произошла ошибка " + " " + jqXHR.status + " " + errorThrown)
        }
    })
}

function clearData() {
    $.ajax({
        url: "php/clear.php",
        type: "get",
        success: function (data) {
            if (data === "true") {
                clearTable()
                getAllData()
                $("#request_text").text("Данные очищены")
            } else {
                $("#request_text").text("Не удалось очитстить данные")
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#request_text").text("Произошла ошибка " + " " + jqXHR.status + " " + errorThrown)
        }
    })
}


function getAllData(){
    $.ajax({
        url: "php/rows.php",
        type: "get",
        success: function (data) {
            clearTable()
            $("#add_table").html(data)
            //setRowsWithinJsonString(data)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#request_text").text("Произошла ошибка " + " " + jqXHR.status + " " + errorThrown)
        }
    })
}

function clearForm(){
    xObject.val(null)
    rObject.val("undefined")
    $(':checkbox').each(function() {
        this.checked = false;
    })
    validateY()
    xObject.change()
    rObject.change()
}

$("#send_button").click(() => {
    if (validateX() && validateY() && validateR()) {
        let checkboxes = document.querySelectorAll("input[type='checkbox']")
        checkboxes.forEach((element) => {
            if (element.checked) {
                sendRequest(element.value);
            }
        })
    } else {
        $("#request_text").text("Проверьте ошибки ввода данных")
    }
})

$("#clear_button").click(() => {
    clearData()
    clearForm()
})

getAllData()