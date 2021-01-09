/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptInsertIntoFormAJAX.js obstarává vkládání záznamů do formuláře
 * script obstarává všechny soubory obsažené ve složce admin
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * data se odesílájí pomocí AJAX do PHP scriptu scriptInsertIntoFormAJAX.php
 * */
function insertIntoForm(ID, type) {
    switch (type) {
        /*indexAdmin.php, documentsAdmin.php*/
        case 'SOUBOR':
            var edDoc = tinyMCE.get('documents');
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                dataType: 'json',
                success: function (response) {
                    edDoc.setContent(response.DESCRIPTION)
                }
            });
            break;
        /*indexAdmin.php, schoolClassesAdmin.php*/
        case 'NOTIFIKACE':
            $("#updateNotification").show();
            $("#submitNotification").hide();
            var ed = tinyMCE.get('popis');
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                dataType: 'json',
                success: function (response) {
                    $("#ID_NOTIFIKACE").val(response.ID_NOTICE);
                    $("#nadpis").val(response.TITLE);
                    ed.setContent(response.DESCRIPTION)
                    $("#favcolor").val(response.BORDER_COLOR);
                }
            });
            break;
        /*users.php*/
        case 'PRAVA':
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    $("#submitPRAVA").hide();
                    $("#updatePRAVA").show();
                    $("#deletePRAVA").show();
                    $("#message-PRAVA").html("");
                    var resultObj = JSON.parse(result);
                    $("#ID_1").val(resultObj.ID);
                    $("#username").val(resultObj.USERNAME);
                    $("#email").val(resultObj.MAIL);
                    /*JQuery mi nefunguje s .prop(checked,false)*/
                    document.getElementById("active").checked = (resultObj.ACTIVE == 1 ? true : false);
                    document.getElementById("admin").checked = (resultObj.ADMIN == 1 ? true : false);
                    document.getElementById("uvod").checked = (resultObj.UVOD == 1 ? true : false);
                    document.getElementById("skolni_rok").checked = (resultObj.SKOLNI_ROK == 1 ? true : false);
                    document.getElementById("fotogalerie").checked = (resultObj.FOTKY == 1 ? true : false);
                    document.getElementById("tridy").checked = (resultObj.TRIDY == 1 ? true : false);
                    document.getElementById("dokumenty").checked = (resultObj.DOKUMENTY == 1 ? true : false);
                    document.getElementById("jidelna").checked = (resultObj.JIDELNA == 1 ? true : false);
                }
            });
            break;
        /*schoolYearAdmin.php*/
        case 'SKOLNIROK':
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#skolniRok").val(resultObj.NAME);
                }
            });
            break;
        /*schoolCanteenAdmin.php*/
        case 'MENULISTEK':
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#menuDatum").val(resultObj.NAME);
                }
            });
            break;
        /*schoolYearAdmin.php*/
        case 'USERS':
            $("#submitUSERS").hide();
            $("#updateUSERS").show();
            $("#deleteUSERS").show();
            $("#message-USERS").html("");
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#ID1").val(resultObj.ID);
                    $("#position").val(resultObj.POSITION);
                    $("#jmeno").val(resultObj.NAME);
                    $("#email").val(resultObj.EMAIL);
                    $("#popis").val(resultObj.DESCRIPTION);
                }
            });
            break;
        /*schoolYearAdmin.php*/
        case 'ZVONENI':
            $("#submitZVONENI").hide();
            $("#updateZVONENI").show();
            $("#deleteZVONENI").show();
            $("#message-ZVONENI").html("");
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#ID2").val(resultObj.ID);
                    $("#hodina").val(resultObj.HOUR);
                    $("#odHodina").val(resultObj.START);
                    $("#doHodina").val(resultObj.END);
                }
            });
            break;
        /*schoolYearAdmin.php*/
        case 'UDALOSTI':
            $("#submitUDALOSTI").hide();
            $("#updateUDALOSTI").show();
            $("#deleteUDALOSTI").show();
            $("#message-UDALOSTI").html("");
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#ID3").val(resultObj.ID);
                    $("#event").val(resultObj.EVENT_ID);
                    $("#typ").val(resultObj.typ);
                    $("#odTyp").val(resultObj.od);
                    $("#doTyp").val(resultObj.do);
                }
            });
            break;
        /*schoolYearAdmin.php*/
        case 'ROZVRH':
            $("#updateROZVRH").show();
            $("#message-ROZVRH").html("");
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#ID4").val(resultObj.ID);
                    $("#schedules").val(resultObj.CLASS);
                    $("#den").val(resultObj.DAY);
                    $("#hodina1").val(resultObj.FIRST);
                    $("#hodina2").val(resultObj.SECOND);
                    $("#hodina3").val(resultObj.THIRD);
                    $("#hodina4").val(resultObj.FOURTH);
                    $("#hodina5").val(resultObj.FIFTH);
                    $("#hodina6").val(resultObj.SIXTH);
                    $("#hodina7").val(resultObj.SEVENTH);
                    $("#hodina8").val(resultObj.EIGHTH);
                }
            });
            break;
        /*schoolCanteenAdmin.php*/
        case 'LISTEK':
            $("#updateLISTEK").show();
            $("#message-LISTEK").html("");
            $.ajax({
                type: "POST",
                data: "ID=" + ID + "&type=" + type,
                url: "../php/scriptInsertIntoFormAJAX.php",
                success: function (result) {
                    var resultObj = JSON.parse(result);
                    $("#ID").val(resultObj.ID);
                    $("#polevka").val(resultObj.SOUP);
                    $("#hlavniPokrm").val(resultObj.MAIN_MEAL);
                    $("#priloha").val(resultObj.DESSERT);
                    $("#napoje").val(resultObj.DRINKS);
                }
            });
            break;
    }
}