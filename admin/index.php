<?php

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor index.php je jako základní rozcestník po přihlášení do webové aplikace, které probělo v scriptLogin.php

 * */

session_start();

require '../inc/db.php';
require '../inc/userRequired.php';
$pageTitle = "";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php" ?>
<body>
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="uvod adminPart">
</main>
<footer>
</footer>
</body>
</html>

