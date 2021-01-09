/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptDeleteAJAX.js obstarává mazání záznamů
 * script obstarává všechny soubory obsažené ve složce admin
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * data se odesílájí pomocí AJAX do PHP scriptu scriptDeleteAJAX.php
 * */
function deleteData(ID, category) {
    var confirmation = confirm("Opravdu si přejete odstranit tento záznam?");
    if (confirmation == true) {
        switch (category) {
            /*indexAdmin.php, documentsAdmin.php*/
            case 'SOUBOR':
                var ID_class = $("#ID_1").val();
                $.ajax({
                    type: "POST",
                    data: "ID=" + ID + "&type=" + category,
                    url: "../php/scriptDeleteAJAX.php",
                    success: function (result) {
                        var resultObj = JSON.parse(result);
                        $("#message-SOUBOR").html(resultObj.message);
                        if (resultObj.status === 1) {
                            $("#message-SOUBOR").css("color", "green");
                            show(ID_class, category);
                        } else {
                            $("#message-SOUBOR").css("color", "red");
                        }
                    }
                });
                break;
            /*indexAdmin.php, schoolClassesAdmin.php*/
            case 'NOTIFIKACE':
                var ID_class = $("#ID").val();
                $.ajax({
                    type: "POST",
                    data: "ID=" + ID + "&type=" + category,
                    url: "../php/scriptDeleteAJAX.php",
                    dataType: 'json',
                    success: function (response) {
                        show(ID_class, category);
                        if (response.status === 1) {
                            $("#updateNotification").hide();
                            $("#submitNotification").show();
                            $('#message-NOTIFIKACE').html('<p class="good">' + response.message + '</p>');
                        } else {
                            $('#message-NOTIFIKACE').html('<p class="bad">' + response.message + '</p>');
                        }
                    }
                });
                break;
            /*schoolYearAdmin.php*/
            case 'USERS':
                var ID = $("#ID1").val();
                var position = $("#position").val();
                $.ajax({
                    type: "POST",
                    data: "ID=" + ID + "&type=" + category,
                    url: "../php/scriptDeleteAJAX.php",
                    success: function (result) {
                        var resultObj = JSON.parse(result);
                        $("#message-USERS").html(resultObj.message);
                        if (resultObj.status === 1) {
                            $('#formUSERS')[0].reset();
                            $("#submitUSERS").show();
                            $("#updateUSERS").hide();
                            $("#deleteUSERS").hide();
                            $("#message-USERS").css("color", "green");
                            show(position, category);
                        } else {
                            $("#message-USERS").css("color", "red");
                        }
                    }
                });
                break;
            /*schoolYearAdmin.php*/
            case 'ZVONENI':
                var ID = $("#ID2").val();
                $.ajax({
                    type: "POST",
                    data: "ID=" + ID + "&type=" + category,
                    url: "../php/scriptDeleteAJAX.php",
                    success: function (result) {
                        var resultObj = JSON.parse(result);
                        $("#message-ZVONENI").html(resultObj.message);
                        if (resultObj.status === 1) {
                            $('#formZVONENI')[0].reset();
                            $("#submitZVONENI").show();
                            $("#updateZVONENI").hide();
                            $("#deleteZVONENI").hide();
                            $("#message-ZVONENI").css("color", "green");
                            show('', category);
                        } else {
                            $("#message-ZVONENI").css("color", "red");
                        }
                    }
                });
                break;
            /*schoolYearAdmin.php*/
            case 'UDALOSTI':
                var ID = $("#ID3").val();
                var druh = $("#event").val();
                $.ajax({
                    type: "POST",
                    data: "ID=" + ID + "&type=" + category,
                    url: "../php/scriptDeleteAJAX.php",
                    success: function (result) {
                        var resultObj = JSON.parse(result);
                        $("#message-UDALOSTI").html(resultObj.message);
                        if (resultObj.status === 1) {
                            $('#formUDALOSTI')[0].reset();
                            $("#submitUDALOSTI").show();
                            $("#updateUDALOSTI").hide();
                            $("#deleteUDALOSTI").hide();
                            $("#message-UDALOSTI").css("color", "green");
                            show(druh, category);
                        } else {
                            $("#message-UDALOSTI").css("color", "red");
                        }
                    }
                });
                break;
            /*photogaleryAdmin.php*/
            case 'FOTO':
                var kategorie = $("#photogalery").val();
                $.ajax({
                    type: "POST",
                    data: "ID=" + ID + "&type=" + category,
                    url: "../php/scriptDeleteAJAX.php",
                    success: function () {
                        show(kategorie, 'PHOTOGALERY');
                    }
                });
                break;
        }
    }
}