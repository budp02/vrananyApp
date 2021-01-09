/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptInsertAJAX.js obstarává vkládání záznamů
 * script obstarává všechny soubory obsažené ve složce admin
 * pro rozlišení jednotlivých funkcí je použití ID tlačítka odesílající událost onclick
 * data se odesílájí pomocí AJAX do PHP scriptu scriptInsertAJAX.php
 * */
$(document).ready(function () {
    /*indexAdmin.php, schoolClassesAdmin.php*/
    $('#submitNotification').click(function (e) {
        var ID = $("#ID").val();
        var ed = tinyMCE.get('popis');
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: "header=" + $("#nadpis").val() + "&text=" + ed.getContent() + "&category=" + $("#ID").val() + "&border=" + $("#favcolor").val() + "&type=" + "NOTIFIKACE",
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Uložit");
                show(ID, 'NOTIFIKACE');
                if (response.status === 1) {
                    $('#formNotification')[0].reset();
                    $('#message-NOTIFIKACE').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-NOTIFIKACE').html('<p class="bad">' + response.message + '</p>');
                }
            }
        });
    });
    /*users.php*/
    $('#submitPRAVA').click(function (e) {
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
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: "jmeno=" + jmeno + "&email=" + email + "&active=" + active + "&admin=" + admin + "&uvod=" + uvod + "&skolni_rok=" + skolni_rok + "&fotogalerie=" + fotogalerie + "&tridy=" + tridy + "&dokumenty=" + dokumenty + "&jidelna=" + jidelna + "&type=PRAVA",
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Vložit");
                show(ID, 'PRAVA');
                if (response.status === 1) {
                    $('#formPRAVA')[0].reset();
                    $('#message-PRAVA').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-PRAVA').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#submitUSERS').click(function (e) {
        var ID = $("#position").val();
        var form = $("#formUSERS");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Vložit");
                if (response.status === 1) {
                    $('#formUSERS')[0].reset();
                    $('#message-USERS').html('<p class="good">' + response.message + '</p>');
                    show(ID, 'USERS');
                } else {
                    $('#message-USERS').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#submitZVONENI').click(function (e) {
        var form = $("#formZVONENI");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Vložit");
                if (response.status === 1) {
                    $('#formZVONENI')[0].reset();
                    $('#message-ZVONENI').html('<p class="good">' + response.message + '</p>');
                    show('', 'ZVONENI');
                } else {
                    $('#message-ZVONENI').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*schoolYearAdmin.php*/
    $('#submitUDALOSTI').click(function (e) {
        var ID = $("#event").val();
        var form = $("#formUDALOSTI");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Vložit");
                if (response.status === 1) {
                    $('#formUDALOSTI')[0].reset();
                    $('#message-UDALOSTI').html('<p class="good">' + response.message + '</p>');
                    show(ID, 'UDALOSTI');
                } else {
                    $('#message-UDALOSTI').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*photogaleryAdmin.php*/
    $('#submitKATEGORIEFOTO').click(function (e) {
        var form = $("#formKATEGORIEFOTO");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Vložit");
                if (response.status === 1) {
                    $('#formKATEGORIEFOTO')[0].reset();
                    show('', 'KATEGORIEFOTO');
                    show('', 'KATEGORIEFOTOPRESENT');
                    show('', 'KATEGORIEFOTOARCHIV');
                    $('#message-KATEGORIEFOTO').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-KATEGORIEFOTO').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*photogaleryAdmin.php*/
    $('#submitPHOTOS').click(function (e) {
        var ID = $("#category").val();
        var form = $("#formPHOTOS");
        var params = form.serializeArray(); /*jen vstupy*/
        var files = $("#filesPHOTOS")[0].files; /*jen soubory*/
        var formData = new FormData();
        for (var i = 0; i < files.length; i++) {
            formData.append(files[i].name, files[i]);
        }
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        var totalfiles = document.getElementById('filesPHOTOS').files.length;
        for (var index = 0; index < totalfiles; index++) {
            formData.append("filesPHOTOS[]", document.getElementById('filesPHOTOS').files[index]);
        }
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptInsertAJAX.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Vložit");
                if (response.status === 1) {
                    $('#formPHOTOS')[0].reset();
                    $('#message-PHOTOS').html('<p class="good">' + response.message + '</p>');
                    show(ID, 'PHOTOGALERY');
                    $("#photogalery").val(ID);
                } else {
                    $('#message-PHOTOS').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
    /*photogaleryAdmin.php*/
    $('#submitPHOTOGALERYARCHIV').click(function (e) {
        var confirmation = confirm("Opravdu si přejete archivovat fotogalerii? Zpětné obnovení může provést pouze Webmaster!");
        if (confirmation == true) {
            var form = $("#formPHOTOGALERYARCHIV");
            var params = form.serializeArray(); /*jen vstupy*/
            var formData = new FormData();
            $(params).each(function (index, element) {
                formData.append(element.name, element.value);
            });
            var btn = $(this);
            btn.val("Nahrávám...");
            btn.prop("disabled", true);
            $.ajax({
                url: '../php/scriptInsertAJAX.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    btn.prop("disabled", false);
                    btn.val("Archivovat");
                    if (response.status === 1) {
                        $('#formPHOTOGALERYARCHIV')[0].reset();
                        show('', 'KATEGORIEFOTO');
                        show('', 'KATEGORIEFOTOPRESENT');
                        show('', 'KATEGORIEFOTOARCHIV');
                        $('#message-PHOTOGALERYARCHIV').html('<p class="good">' + response.message + '</p>');
                    } else {
                        $('#message-PHOTOGALERYARCHIV').html('<p class="bad">' + response.message + '</p>');
                    }
                },
            });
        }
    });
});