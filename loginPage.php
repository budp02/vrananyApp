<?php

session_start();

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor loginPage.php slouží pro přihlášení d oWebové aplikace

 * */

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Přihlašovací stránka - ZŠ Vraňany</title>
    <meta charset=utf-8>
    <meta name=description
          content="Základní škola Vraňany v okrese Mělník je malotřídní školou pro vzdělávání dětí od 1. do 5. ročníku.">
    <meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=5">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/menu.js?v=20"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.min.js?v=1"></script>
    <script src="js/scriptLogin.js?v=19"></script>
    <link rel="shortcut icon" href=favicon.ico>
    <link rel="stylesheet" href="css/bootstrap.min.css?v=14">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css?v=4">
    <link rel="stylesheet" type="text/css" href="css/styles_min.css?v=94">
</head>
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="login">
    <h2>Přihlášení do aplikace</h2>
    <div class="login_form">
        <div id="login" style="width: 300px">
            <div class="form-group">
                <label for="user_id">Jméno:</label>
                <input type="text" class="form-control" aria-label="Jméno" placeholder="Jméno:" id="user_id">
            </div>
            <div class="form-group">
                <label for="user_pass">Heslo:</label>
                <input type="password" class="form-control" aria-label="Heslo" placeholder="Heslo:" id="user_pass">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" id="buttonLogin" onclick="checkLogin()">Přihlásit se</button>
                <!--scriptLogin.js-->
            </div>
            <a onclick="forgotPass_link()">Zapomenuté heslo?</a><!--scriptLogin.js-->
            <br>
            <span id="message-users"></span><br>
        </div>
        <div id="changePassword" style="display: none">
            <input type="hidden" id="ID_1">
            <div class="form-group">
                <label for="user_pass_new1">Nové heslo:</label>
                <input type="password" aria-label="Heslo" class="form-control" placeholder="Heslo #1"
                       id="user_pass_new1">
            </div>
            <div class="form-group">
                <label for="user_pass_new2">Zopakujte heslo:</label>
                <input type="password" aria-label="Heslo k zopakování" class="form-control" placeholder="Heslo #2"
                       id="user_pass_new2">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" onclick="newPass()">Změnit heslo</button><!--scriptLogin.js-->
            </div>
            <br>
            <span id="message-changePass"></span>
        </div>
        <div id="forgotPassword" style="display: none">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" aria-label="email" class="form-control" placeholder="Email:" id="email">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" onclick="forgotPass()">Resetovat heslo</button><!--scriptLogin.js-->
            </div>
            <br>
            <span id="message-forgotPass"></span>
        </div>
    </div>
</main>
</body>
</html>

