<?php session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor documentsAdmin.php je určený pro administraci webové prezentace documents.php
 * */
require '../inc/db.php';
require '../inc/userRequired.php';
if ((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['DOKUMENTY'] == '0'))) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../logout.php');
    exit();
}
$pageTitle = "Dokumenty - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php"; ?>
<body onload="show('7','SOUBOR');insertIntoForm('46','SOUBOR');"><!--scriptSelectAJAX.js,scriptInsertIntoFormAJAX.js-->
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="dokumenty adminPart">
    <h2>Dokumenty školy</h2>
    <div class="container">
        <form id="formDoc" method='post' enctype="multipart/form-data">
            <input type="hidden" value="7" name="ID_1" id="ID_1">
            <input type="hidden" value="46" name="ID_DOC" id="ID_DOC">
            <input type="hidden" value="SOUBOR" name="type" id="type">
            <div class="form-group">
                <textarea name="documents" id="documents"></textarea>
            </div>
            <input type="button" id="updateSOUBOR" class="btn btn-warning" value='Aktualizovat'>
            <!--scriptUpdateAJAX.js-->
        </form>
    </div>
    <div id="message-SOUBOR"></div>
    <br>
    <div id="load-SOUBOR"></div><!--scriptSelectAJAX.js-->
</main>
<footer>
    <?php include "../inc/footerAdmin.php" ?>
</footer>
<script>
    $("header nav a:nth-child(5)").addClass("active");
</script>
<script>
    tinymce.init({
        selector: '#documents',
        plugins: 'tinydrive link image',
        toolbar: 'insertfile image| link tinydrive',
        tinycomments_mode: 'embedded',
        toolbar_mode: 'floating',
        tinycomments_author: 'Author name',
        entity_encoding: "raw",
        tinydrive_token_provider: 'jwt.php',
        image_title: true,
        language: 'cs'
    });
</script>
<?php include "../inc/scriptsAdmin.php" ?>
</body>
</html>