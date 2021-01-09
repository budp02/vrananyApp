<?php session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor schoolClassesAdmin.php je určený pro administraci webové prezentace schoolClasses.php
 * */
require '../inc/db.php';
require '../inc/userRequired.php';
if ((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['DOKUMENTY'] == '0'))) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../logout.php');
    exit();
}
$class = $_GET['class'] . '. třída';
$pageTitle = "Třídy - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php"; ?>
<body onload="show('<?php echo $class?>','NOTIFIKACE');">
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="tridy adminPart">
    <h2>Třídy</h2>
    <div class="bags">
        <a href="schoolClassesAdmin.php?class=1" title=1.Třída><img src="../img/blue.jpg" alt="prnaci"></a>
        <a href="schoolClassesAdmin.php?class=2" title=2.Třída><img src="../img/green.jpg" alt="druhaci"></a>
        <a href="schoolClassesAdmin.php?class=3" title=3.Třída><img src="../img/red.jpg" alt="tretaci"></a>
        <a href="schoolClassesAdmin.php?class=4" title=4.Třída><img src="../img/yellow.jpg" alt="ctvrtaci"></a>
        <a href="schoolClassesAdmin.php?class=5" title=5.Třída><img src="../img/purple.jpg" alt="pataci"></a>
    </div>
    <?php
    if (!empty($_GET['class'])) {
        echo '<h2>' . $class . '</h2>';
        ?>
        <div class="container">
            <form id="formNotification" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ID" id="ID" value="<?php echo $class; ?>"> <!-- Třída -->
                <input type="hidden" value="NOTIFIKACE" name="type">
                <input type="hidden" name="ID_NOTIFIKACE" id="ID_NOTIFIKACE"> <!-- ID příspěvku-->
                <div class="form-group">
                    <input type="text" aria-label="Nadpis" placeholder="Nadpis:" name="nadpis" id="nadpis" required
                           class="form-control">
                </div>
                <div class="form-group">
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
                <input type="button" class="btn btn-light"
                       onclick="$('#formNotification')[0].reset();$('#submitNotification').show();$('#fileUpload').show();$('#updateNotification').hide();"
                       value='Zrušit'>
            </form>
            <div id="message-NOTIFIKACE">
            </div>
            <br>
            <div id="load-NOTIFIKACE"></div><!--scriptSelectAJAX.js-->
        </div>
        <?php
    } ?>
</main>
<footer>
    <?php include "inc/footerAdmin.php" ?>
</footer>
<script>
    $("header nav a:nth-child(4)").addClass("active");
</script>
<script>
    tinymce.init({
        selector: '#popis',
        plugins: 'autolink lists table save tinydrive link image',
        toolbar: 'insertfile image| styleselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | removeformat | link tinydrive',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        save_onsavecallback: "save",
        entity_encoding: "raw",
        tinydrive_token_provider: 'jwt.php',
        image_title: true,
        language: 'cs'
    });
</script>
<?php include "../inc/scriptsAdmin.php" ?>
</body>
</html>

