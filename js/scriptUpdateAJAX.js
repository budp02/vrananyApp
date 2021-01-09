/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptUpdateAJAX.js obstarává aktualizaci záznamů
 * script obstarává všechny soubory obsažené ve složce admin
 * * pro rozlišení jednotlivých funkcí je použití ID tlačítka odesílající událost onclick
 * data se odesílájí pomocí AJAX do PHP scriptu scriptUpdateAJAX.php
 * */
$(document).ready(function () {
    /*indexAdmin.php*/
    $('#submitFoto').click(function (e) {
        var form = $("#formPic");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 1) {
                    $('#formPic')[0].reset();
                    $('#message-FOTO').html('<p class="good">' + response.message + '</p>');
                    show('2', 'FOTO');
                } else {
                    $('#message-FOTO').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*indexAdmin.php,documentsAdmin.php*/
    $('#updateSOUBOR').click(function (e) {
        var ID = $("#ID_1").val();
        var ed = tinyMCE.get('documents');
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: "text=" + ed.getContent() + "&type=" + "SOUBOR" + "&ID=" + $("#ID_DOC").val(),
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Aktualizovat");
                show(ID, 'SOUBOR');
                if (response.status === 1) {
                    $('#message-SOUBOR').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-SOUBOR').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*indexAdmin.php,schoolYearAdmin.php*/
    $('#updateNotification').click(function (e) {
        var ID = $("#ID").val();
        var ed = tinyMCE.get('popis');
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: "header=" + $("#nadpis").val() + "&text=" + ed.getContent() + "&category=" + $("#ID").val() + "&border=" + $("#favcolor").val() + "&type=" + "NOTIFIKACE" + "&ID=" + +$("#ID_NOTIFIKACE").val(),
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Aktualizovat");
                show(ID, 'NOTIFIKACE');
                if (response.status === 1) {
                    $('#formNotification')[0].reset();
                    $('#message-NOTIFIKACE').html('<p class="good">' + response.message + '</p>');
                    $("#updateNotification").hide();
                    $("#submitNotification").show();
                } else {
                    $('#message-NOTIFIKACE').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*users.php*/
    $('#updatePRAVA').click(function (e) {
        var ID = $("#ID_1").val();
        var jmeno = $("#username").val();
        var email = $("#email").val();
        var active = ($('#active').is(':checked') ? '1' : '0');
        var admin = ($('#admin').is(':checked') ? '1' : '0');
        var uvod = ($('#uvod').is(':checked') ? '1' : '0');
        var skolni_rok = ($('#skolni_rok').is(':checked') ? '1' : '0');
        var fotogalerie = ($('#fotogalerie').is(':checked') ? '1' : '0');
        var tridy = ($('#tridy').is(':checked') ? '1' : '0');
        var dokumenty = ($('#dokumenty').is(':checked') ? '1' : '0');
        var jidelna = ($('#jidelna').is(':checked') ? '1' : '0');
        $.ajax({
            type: "POST",
            data: "ID=" + ID + "&jmeno=" + jmeno + "&email=" + email + "&active=" + active + "&admin=" + admin + "&uvod=" + uvod + "&skolni_rok=" + skolni_rok + "&fotogalerie=" + fotogalerie + "&tridy=" + tridy + "&dokumenty=" + dokumenty + "&jidelna=" + jidelna + "&type=PRAVA",
            url: "../php/scriptUpdateAJAX.php",
            success: function (result) {
                var resultObj = JSON.parse(result);
                $("#message-PRAVA").html(resultObj.message);
                if (resultObj.status === 1) {
                    $('#formPRAVA')[0].reset();
                    $("#submitPRAVA").show();
                    $("#updatePRAVA").hide();
                    $("#deletePRAVA").hide();
                    $("#message-PRAVA").css("color", "green");
                    show('', 'PRAVA');
                } else {
                    $("#message-PRAVA").css("color", "red");
                }
            }
        });
    });
    /*schoolYearAdmin.php*/
    $('#updateSKOLNIROK').click(function (e) {
        var form = $("#formSKOLNIROK");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show('', 'SKOLNIROK');
                if (response.status === 1) {
                    $('#formSKOLNIROK')[0].reset();
                    $('#message-SKOLNIROK').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-SKOLNIROK').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolCanteenAdmin.php*/
    $('#updateMENULISTEK').click(function (e) {
        var form = $("#formMENULISTEK");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show('', 'MENULISTEK');
                if (response.status === 1) {
                    $('#message-MENULISTEK').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-MENULISTEK').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#updateUSERS').click(function (e) {
        var position = $("#position").val();
        var form = $("#formUSERS");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show(position, 'USERS');
                if (response.status === 1) {
                    $('#formUSERS')[0].reset();
                    $("#submitUSERS").show();
                    $("#updateUSERS").hide();
                    $("#deleteUSERS").hide();
                    $('#message-USERS').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-USERS').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#updateZVONENI').click(function (e) {
        var form = $("#formZVONENI");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show('', 'ZVONENI');
                if (response.status === 1) {
                    $('#formZVONENI')[0].reset();
                    $("#submitZVONENI").show();
                    $("#updateZVONENI").hide();
                    $("#deleteZVONENI").hide();
                    $('#message-ZVONENI').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-ZVONENI').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#updateUDALOSTI').click(function (e) {
        var event = $("#event").val();
        var form = $("#formUDALOSTI");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show(event, 'UDALOSTI');
                if (response.status === 1) {
                    $('#formUDALOSTI')[0].reset();
                    $("#submitUDALOSTI").show();
                    $("#updateUDALOSTI").hide();
                    $("#deleteUDALOSTI").hide();
                    $('#message-UDALOSTI').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-UDALOSTI').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#updateROZVRH').click(function (e) {
        var schedule = $("#schedules").val();
        var form = $("#formROZVRH");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show(schedule, 'ROZVRH');
                if (response.status === 1) {
                    $('#formROZVRH')[0].reset();
                    $("#updateROZVRH").hide();
                    $('#message-ROZVRH').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-ROZVRH').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolCanteenAdmin.php*/
    $('#updateLISTEK').click(function (e) {
        var form = $("#formLISTEK");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        $.ajax({
            url: '../php/scriptUpdateAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                show('', 'LISTEK');
                if (response.status === 1) {
                    $('#formLISTEK')[0].reset();
                    $("#updateLISTEK").hide();
                    $('#message-LISTEK').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-LISTEK').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
});