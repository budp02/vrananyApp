<?php session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor photogaleryAdmin.php je určený pro administraci webové prezentace photogalery.php
 * */
require '../inc/db.php';
require '../inc/userRequired.php';
if ((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['FOTKY'] == '0'))) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../logout.php');
    exit();
}
$photoArray = array();
$query = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY')->fetchAll(PDO::FETCH_ASSOC);
foreach ($query as $recordQuery) {
    array_push($photoArray, $recordQuery['CATEGORY_ID']);
}
$category = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY ORDER BY CATEGORY_ID DESC ;')->fetchAll(PDO::FETCH_ASSOC);
$categoryArchiv = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY ORDER BY CATEGORY_ID DESC ;')->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Fotogalerie - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php"; ?>
<body onload="show('','KATEGORIEFOTO'),show('','KATEGORIEFOTOPRESENT'),show('','KATEGORIEFOTOARCHIV')">
<!--scriptSelectAJAX.js-->
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="fotogalerie adminPart">
    <h3>Nová kategorie</h3>
    <div class="container">
        <form id="formKATEGORIEFOTO" method="post" enctype="multipart/form-data">
            <input type="hidden" value="KATEGORIEFOTO" name="type">
            <div class="form-group">
                <input type="text" aria-label="Název fotogalerie" placeholder="Název fotogalerie:" name="nazev"
                       id="nazev" required class="form-control">
            </div>
            <br>
            <input type="button" id="submitKATEGORIEFOTO" class="btn btn-primary" value='Vložit'>
            <!--scriptInsertAJAX.js-->
            <input type="button" onclick="$('#formKATEGORIEFOTO')[0].reset();" class="btn btn-light" value='Zrušit'>
        </form>
        <div id="message-KATEGORIEFOTO">
        </div>
        <br>
    </div>
    <h3>Nahrávání fotografií</h3>
    <div class="container">
        <form id="formPHOTOS" method="post" enctype="multipart/form-data">
            <input type="hidden" value="PHOTOS" name="type">
            <div class="form-group" id="load-KATEGORIEFOTO"></div><!--scriptSelectAJAX.js-->
            <div class="fileUpload" id="fileUpload">
                <div class="custom-file">
                    <label for="filesFoto" class="custom-file-label">Soubory:</label>
                    <input aria-label="Soubory" type=file id="filesPHOTOS" name=filesPHOTOS[] multiple
                           class="custom-file-input">
                </div>
            </div>
            <br>
            <input type="button" id="submitPHOTOS" class="btn btn-primary" value='Vložit'><!--scriptInsertAJAX.js-->
            <input type="button" onclick="$('#formPHOTOS')[0].reset();" class="btn btn-light" value='Zrušit'>
        </form>
        <div id="message-PHOTOS">
        </div>
        <br>
    </div>
    <h3>Zobrazení fotogalerie</h3>
    <div class="container">
        <div id="load-PHOTOGALERY"></div><!--scriptSelectAJAX.js-->
        <div class="form-group" id="load-KATEGORIEFOTOPRESENT"></div><!--scriptSelectAJAX.js-->
    </div>
    <h3>Archivace fotogalerie</h3>
    <div class="container">
        <form id="formPHOTOGALERYARCHIV" method="post" enctype="multipart/form-data">
            <input type="hidden" value="PHOTOGALERYARCHIV" name="type">
            <div class="form-group" id="load-KATEGORIEFOTOARCHIV"></div><!--scriptSelectAJAX.js-->
            <br>
            <input type="button" id="submitPHOTOGALERYARCHIV" class="btn btn-primary" value='Archivovat'>
            <!--scriptInsertAJAX.js-->
        </form>
        <div id="message-PHOTOGALERYARCHIV">
        </div>
</main>
<footer>
    <?php include "../inc/footerAdmin.php" ?>
</footer>
<script>
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    $('.img-wrap .close').on('click', function () {
        var id = $(this).closest('.img-wrap').find('img').data('id');
        alert('remove picture: ' + id);
    });
</script>
<script>
    $("header nav a:nth-child(3)").addClass("active");
</script>
<?php include "../inc/scriptsAdmin.php" ?>
</body>

</html>