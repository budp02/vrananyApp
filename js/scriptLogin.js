/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptLogin.js obstarává přihlašování uživatelů
 * přihlašovací formulář je na loginPage.php
 * data se odesílájí pomocí AJAX do PHP scriptu scriptLogin.php
 * */
function checkLogin() {
    var jmeno =$("#user_id").val();
    var heslo =$("#user_pass").val();
   $.ajax({
        type: "POST",
        data: "jmeno=" + jmeno + "&heslo=" + heslo+ "&action=verify",
        url: "php/scriptLogin.php",
        success: function (result) {
            var resultObj = JSON.parse(result);
            $("#message-users").html(resultObj.message);
           if (resultObj.status === 1) {
               $("#message-users").css("color", "green");
               window.location.href='admin/';
               return false;
            }
           else if(resultObj.status === 2){
               $("#message-users").css("color", "green");
               $("#user_id").prop("disabled", true);
               $("#user_pass").prop("disabled", true);
               $("#changePassword").show();
               $("#ID_1").val(resultObj.ID);
           }
           else{
               $("#message-users").css("color", "red");
               clearData();
           }

       }
    });
}

function newPass(){
    var ID = $("#ID_1").val();
    var jmeno =$("#user_id").val();
    var heslo =$("#user_pass").val();
    var hesloNew1 =$("#user_pass_new1").val();
    var hesloNew2 =$("#user_pass_new2").val();
    $.ajax({
        type: "POST",
        data: "ID=" + ID + "&jmeno=" + jmeno + "&heslo=" + heslo+ "&hesloNew1=" + hesloNew1+ "&hesloNew2=" + hesloNew2+ "&action=changePass",
        url: "php/scriptLogin.php",
        success: function (result) {
            var resultObj = JSON.parse(result);
            $("#message-changePass").html(resultObj.message);
            if (resultObj.status === 1) {
                $("#message-changePass").css("color", "green");
                location.href="admin/";
            }
            else{
                $("#message-changePass").css("color", "red");
                clearDataNewPass();
            }

        }
    });

}

function forgotPass_link(){
    $("#forgotPassword").show();
}

function forgotPass(){
    var email =$("#email").val();
    $.ajax({
        type: "POST",
        data: "email=" + email + "&action=forgotPass",
        url: "php/scriptLogin.php",
        success: function (result) {
            var resultObj = JSON.parse(result);
            $("#message-forgotPass").html(resultObj.message);
            if (resultObj.status === 1) {
                $("#message-forgotPass").css("color", "green");
                $("#email").val("");
            }
            else{
                $("#message-forgotPass").css("color", "red");
            }

        }
    });
}

function  clearData(){
    $("#user_id").val("");
    $("#user_pass").val("");
}

function  clearDataNewPass(){
    $("#user_pass_new1").val("");
    $("#user_pass_new2").val("");

}

$(document).ready(function() {
    $("#user_id").bind("keyup", function(event) {
        if (event.keyCode === 13) {
            $( "#buttonLogin" ).click();
            return false;
        }
    });
$("#user_pass").bind("keyup", function(event) {
    if (event.keyCode === 13) {
        $( "#buttonLogin" ).click();
        return false;
    }
});
});