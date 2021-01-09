<?php session_start();

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor contact.php obsahuje kontaktní formulář pro okamžité kontaktování personálu školy

 * */
require 'inc/db.php';
$pageTitle = "Kontakty - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "inc/head.php" ?>
<link rel="stylesheet" href="css/bootstrap.min.css?v=16">
<link rel="stylesheet" href="css/bootstrap-reboot.min.css?v=3">
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="kontakt">
    <div class="contactList">
        <div class="contactInfo">
            <div>
                <h3>Adresa školy</h3>
                <span>
                    Vraňany 67, Vraňany <br> 277 07<br>
                    <a style="color: red"
                       href="https://www.google.cz/maps/place/Z%C3%A1kladn%C3%AD+%C5%A0kola/@50.3200812,14.3623582,361m/data=!3m2!1e3!4b1!4m2!3m1!1s0x470bdc8fcdd9863f:0xeb275185655ed2c8"
                       target="_blank">MAPA</a>
                </span>
            </div>
            <div>
                <h3>Telefon</h3>
                <span>+420 315 691 086</span>
            </div>
            <div>
                <h3>Email</h3>
                <span>zs.vranany@seznam.cz</span>
            </div>
        </div>
        <div class="contactForm">
            <div class="container">
                <h3>Napište nám</h3>
                <form id="formMail" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" aria-label="Jméno a příjmení" placeholder="Jméno a příjmení:"
                               name="firstName" id="firstName" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" aria-label="Email" placeholder="Email:" name="email" id="email" required
                               class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea style="resize: none;height: 100px;" name="message" id="message"
                                  aria-label="Text emaiu" placeholder="Zpráva:" class="form-control"></textarea>
                    </div>
                    <div style="text-align: center">
                        <input type="button" id="submitEmail" class="btn btn-primary" value='Odeslat zprávu'><!--scriptContact.js-->
                    </div>
                </form>
            </div>
            <br>
            <div id="message-MAIL"></div>
        </div>
    </div>
</main>
<footer>
    <?php include "inc/footer.php" ?>
</footer>
<script>
    $("header nav a:nth-child(7)").addClass("active");
</script>
</body>
</html>