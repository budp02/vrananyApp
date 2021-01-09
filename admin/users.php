<?
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor users.php je určený pro administraci uživatelů přistupujích k webové aplikaci
 * */
setlocale(LC_TIME, 'cs_CZ.UTF-8');
require '../inc/db.php';
require '../inc/userRequired.php';
if ((empty($currentUser)) || (($currentUser['ADMIN'] == '0'))) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../logout.php');
    exit();
}
$pageTitle = "Uživatelé - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php"; ?>
<body onload="show('','PRAVA')"><!--scriptSelectAJAX.php-->
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="uzivatele adminPart">
    <h3>Vložení nového uživatele aplikace</h3>
    <form id="formPRAVA" method="post" enctype="multipart/form-data">
        <table class="table users">
            <thead>
            <tr>
                <th>USERNAME</th>
                <th>EMAIL</th>
            </tr>
            </thead>
            <tr>
                <input type="hidden" id="ID_1" aria-label="ID uživatele">
                <input type="hidden" value="PRAVA" name="type">
            </tr>
            <tr>
                <td><input type="text" class="form-control" id="username" aria-label="Uživatelské jméno"></td>
                <td><input type="text" class="form-control" id="email" aria-label="E-mail"></td>
            </tr>
        </table>
        <div style="overflow-x: auto">
            <table class="table users">
                <thead>
                <tr>
                    <th>AKTIVNÍ</th>
                    <th>ADMIN</th>
                    <th>ÚVOD</th>
                    <th>ROK</th>
                    <th>FOTO</th>
                    <th>TŘÍDY</th>
                    <th>DOC</th>
                    <th>JÍDELNA</th>
                </tr>
                </thead>
                <tr>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="active">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="admin" name="admin">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="uvod">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="skolni_rok">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="fotogalerie">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="tridy">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="dokumenty">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                    <td>
                        <label class="switcher">
                            <input type="checkbox" class="custom-control-input" id="jidelna">
                            <div class="switcher__indicator"></div>
                        </label>
                    </td>
                </tr>
            </table>
        </div>
        <input type="button" id="submitPRAVA" class="btn btn-primary" value='Vložit'><!--scriptInsertAJAX.js-->
        <input type="button" id="updatePRAVA" class="btn btn-warning" value='Aktualizovat'><!--scriptUpdateAJAX.js-->
        <input type="button" class="btn btn-light"
               onclick="$('#formPRAVA')[0].reset();$('#submitPRAVA').show();$('#updatePRAVA').hide();" value='Zrušit'>
    </form>
    <br>
    <span id="message-PRAVA"></span>
    <h4>Uživatelé aplikace</h4>
    <div style="overflow-x: auto">
        <table class="table table-striped users">
            <thead>
            <tr>
                <th>USERNAME</th>
                <th>EMAIL</th>
                <th>AKTIVNÍ</th>
                <th>ADMIN</th>
                <th>ÚVOD</th>
                <th>ROK</th>
                <th>FOTO</th>
                <th>TŘÍDY</th>
                <th>DOC</th>
                <th>JÍDELNA</th>
                <th>Upravit</th>
            </tr>
            </thead>
            <tbody id="load-PRAVA"><!--scriptSelectAJAX-->
            </tbody>
        </table>
    </div>
</main>
<footer>
    <?php include "../inc/footerAdmin.php" ?>
</footer>
<script>
    $("header nav a:nth-child(7)").addClass("active");
</script>
<?php include "../inc/scriptsAdmin.php" ?>
</body>
</html>