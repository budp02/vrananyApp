<?php session_start();

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor documents.php slouží pro zobrazení aktuálních dokumentů školy

 * */

require 'inc/db.php';
$query = $db->prepare('SELECT * FROM 2020_PDF_FILES JOIN 2020_CATEGORIES USING (CATEGORY) WHERE CATEGORY_NAME=:name ORDER BY CREATED desc');
$query->execute([
    'name' => 'DOKUMENTY'
]);
$documents = $query->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Dokumenty - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "inc/head.php" ?>
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="dokumenty">
    <h2>Oficiální dokumenty školy</h2>
    <?php
    foreach ($documents as $recordQuery) {
        echo '<div>';
        echo $recordQuery['DESCRIPTION'];
        echo '</div>';
    }
    ?>
</main>
<footer>
    <?php include "inc/footer.php" ?>
</footer>
<script>
    $("header nav a:nth-child(5)").addClass("active");
</script>
</body>
</html>