<?
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
  * Soubor indexAdmin.php je určený pro administraci webové prezentace index.php
 * */
require '../inc/db.php';
require '../inc/userRequired.php';
if ((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['UVOD'] == '0'))) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../logout.php');
    exit();
}
$fotografieCat = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY')->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php"; ?>
<body onload="show('1','SOUBOR'),show('UVOD','NOTIFIKACE'),show('2','FOTO');insertIntoForm('12','SOUBOR');">
<!--scriptSelectAJAX.js,scriptInsertIntoFormAJAX.js-->
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="uvod adminPart">
    <h2> Základní škola Vraňany</h2>
    <p>
        <strong> Vítáme Vás na stránkách Základní školy Vraňany. </strong>
        <br>Historie naší školy sahá až do 60. let 19. století. Objekt školy se postupně rozrůstal, dnes se
        zde nachází také mateřská škola a školní jídelna. Škola je málotřídní, disponuje moderními
        vyučovacími pomůckami i technikou, prostornými učebnami, velkou zahradou a tělocvičnou. Individuální
        a přátelský přístup, rodinné a podnětné prostředí a společné soužití je to, co dělá naši školu tím
        správným místem pro výchovu a vzdělávání dětí od 1. do 5. ročníku ZŠ.
    </p>
    <h3>Nahrání souboru</h3>
    <div class="container">
        <form id="formDoc" method='post' enctype="multipart/form-data">
            <input type="hidden" value="1" name="ID_1" id="ID_1">
            <input type="hidden" value="12" name="ID_DOC" id="ID_DOC">
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
    <h2> Aktuality</h2><br>
    <h3>Nový příspěvek</h3>
    <div class="container">
        <form id="formNotification" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ID" id="ID" value="ÚVOD"> <!-- Třída -->
            <input type="hidden" value="NOTIFIKACE" name="type">
            <input type="hidden" name="ID_NOTIFIKACE" id="ID_NOTIFIKACE"> <!-- ID příspěvku-->
            <div class="form-group">
                <input type="text" aria-label="Nadpis" placeholder="Nadpis:" name="nadpis" id="nadpis" required
                       class="form-control">
            </div>
            <div class="form-group">
                <br>
                <div class="form-group">
                    <textarea name="popis" id="popis"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="favcolor">Vyberte barvu formuláře:</label>
                <input type="color" required id="favcolor" name="borderColor">
            </div>
            <br>
            <input type="button" id="submitNotification" class="btn btn-primary" value='Uložit'>
            <!--scriptInsertAJAX.js-->
            <input type="button" id="updateNotification" class="btn btn-warning" value='Aktualizovat'>
            <!--scriptUpdateAJAX.js-->
            <input type="button"
                   onclick="$('#formNotification')[0].reset();$('#submitNotification').show();$('#updateNotification').hide();$('#fileUpload').show();"
                   class="btn btn-light" value='Zrušit'>
        </form>
        <div id="message-NOTIFIKACE">
        </div>
        <br>
        <div id="load-NOTIFIKACE"></div><!--scriptSelectAJAX.js-->
    </div>
    <br>
    <h3>Výběr fotogalerie</h3>
    <div class="container">
        <form id="formPic" method='post' enctype="multipart/form-data">
            <input type="hidden" value="FOTO" name="type">
            <div class="categoryFoto">
                <select style="width: 250px;" name="category_fotoID" aria-label="Foto kategorie" required
                        class="form-control custom-select">
                    <option value="">--Vyberte foto kategorii--</option>
                    <?php
                    if (!empty($fotografieCat)) {
                        foreach ($fotografieCat as $category) {
                            echo '<option value="' . $category['CATEGORY_ID'] . '" ' . '>' . htmlspecialchars($category['NAME']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <br>
            <input type="button" id="submitFoto" class="btn btn-primary" value='Uložit'><!--scriptInsertAJAX.js-->
        </form>
        <div id="message-FOTO"></div>
        <br>
        <h2>Náhled do fotogalerie</h2>
        <div id="load-FOTO"></div><!--scriptSelect.js-->
        <br>
    </div>
    </div>
</main>
<footer>
    <?php include "../inc/footerAdmin.php" ?>
</footer>
<script>
    $("header nav a:nth-child(1)").addClass("active");
</script>
<script>
    tinymce.init({
        selector: '#popis',
        plugins: 'autolink lists media table save tinydrive link image',
        toolbar: 'insertfile image| styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | removeformat | link tinydrive',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        entity_encoding: "raw",
        tinydrive_token_provider: 'jwt.php',
        image_title: true,
        language: 'cs'
    });
</script>
<script>
    tinymce.init({
        selector: '#documents',
        plugins: 'tinydrive link image',
        toolbar: 'insertfile image| link tinydrive',
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