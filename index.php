<?php

session_start();

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor index.php je úvodní stránka školy, obsahující příspěvky a fotogalerii

 * */
require 'inc/db.php';
$query = $db->prepare('SELECT * FROM 2020_PDF_FILES JOIN 2020_CATEGORIES USING (CATEGORY) WHERE CATEGORY_NAME=:name ORDER BY CREATED desc');
$query->execute([
    'name' => 'ÚVOD'
]);
$documents = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $db->prepare('SELECT * FROM 2020_NOTIFICATION INNER JOIN 2020_CATEGORIES USING (CATEGORY) WHERE CATEGORY_NAME=:podminka ORDER BY CREATED DESC;');
$query->execute([
    'podminka' => 'ÚVOD'
]);
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
$fotografieID = $db->query('SELECT NAME FROM 2020_OTHERS WHERE ID=2')->fetchColumn();
$fotografie = $db->prepare('SELECT * FROM 2020_FOTOGALERY_CATEGORY JOIN 2020_FOTOGALERY USING (CATEGORY_ID) WHERE CATEGORY_ID=:id LIMIT 5');
$fotografie->execute([
    ':id' => $fotografieID
]);
$resultFotogalerie = $fotografie->fetchAll(PDO::FETCH_ASSOC);
$fotografieCategoryName = $db->prepare('SELECT * FROM 2020_FOTOGALERY_CATEGORY JOIN 2020_FOTOGALERY USING (CATEGORY_ID) WHERE CATEGORY_ID=:id LIMIT 5');
$fotografieCategoryName->execute([
    ':id' => $fotografieID
]);
$catName = $fotografieCategoryName->fetch(PDO::FETCH_ASSOC);
$pageTitle = "";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "inc/headFoto.php" ?>
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="uvod">
    <h2> Základní škola Vraňany</h2>
    <p>
        <strong> Vítáme Vás na stránkách Základní školy Vraňany. </strong>
        <br>Historie naší školy sahá až do 60. let 19. století. Objekt školy se postupně rozrůstal, dnes se
        zde nachází také mateřská škola a školní jídelna. Škola je málotřídní, disponuje moderními
        vyučovacími pomůckami i technikou, prostornými učebnami, velkou zahradou a tělocvičnou. Individuální
        a přátelský přístup, rodinné a podnětné prostředí a společné soužití je to, co dělá naši školu tím
        správným místem pro výchovu a vzdělávání dětí od 1. do 5. ročníku ZŠ.
    </p>
    <?php
    foreach ($documents as $recordQuery) {
        echo '<div>';
        echo $recordQuery['DESCRIPTION'];
        echo '</div>';
    }
    ?>
    <h2> Aktuality</h2><br>
    <?php
    if (!empty($posts)) {
        foreach ($posts as $post) {
            echo '<div class="prispevek" style="border: 2px solid' . $post['BORDER_COLOR'] . '">';
            echo '<div><u><strong>' . $post['TITLE'] . '</strong></u><br>';
            echo $post['DESCRIPTION'] . '<br>';
            if (!$post['REAL_NAME_FILES'] == "") {
                $piecesName = explode(";", $post['NAME_FILES']);
                $count = count($piecesName);
                $piecesRealName = explode(";", $post['REAL_NAME_FILES']);
                for ($i = 0; $i < $count; $i++) {
                    echo "<img alt src=img/pdf.png><a href='pdf/" . $piecesRealName[$i] . "'  target='_blank'>$piecesName[$i]</a><br>";
                }
            }
            echo '<div class=zverejneni>';
            echo $post['FOUNDER'] . " " . date('d.m.Y H:i', strtotime($post['CREATED']));
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "Žádné příspěvky se zde nenachází";
    }
    echo '<h2>Náhled do fotogalery</h2>';
    if (!empty($resultFotogalerie)) {
        echo '<h3>' . $catName['NAME'] . '</h3>';
        foreach ($resultFotogalerie as $photo) {
            if ($photo['poloha'] == '1') {
                echo "<a class='grouped_elements' rel='photogalery' href=" . 'fotogalery/maxi/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " target=" . _blank . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . 'fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='vodorovne'>" . "</a>";
            } else {
                echo "<a class='grouped_elements' rel='photogalery' href=" . 'fotogalery/maxi/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " target=" . _blank . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . 'fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='svisle'>" . "</a>";
            }
        }
    } else {
        echo "Žádné fotky se v dané kategorii nenachází";
    }
    ?>
</main>
<footer>
    <?php include "inc/footer.php" ?>
</footer>
<script>
    $("header nav a:nth-child(1)").addClass("active");
</script>
<script>
    $("a.grouped_elements").fancybox();
</script>
</body>
</html>