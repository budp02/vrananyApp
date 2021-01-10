<?php
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor photogalery.php slouží k zobrazení všech nahraných fotogalerií školy
 * */
require 'inc/db.php';
$photoArray = array();
$query = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY')->fetchAll(PDO::FETCH_ASSOC);
foreach ($query as $recordQuery) {
    array_push($photoArray, $recordQuery['CATEGORY_ID']);
}

if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
} else {
    $offset = sizeof($photoArray) - 1;
    $_GET['offset'] = $offset;
}

$fotografie = $db->prepare('SELECT * FROM 2020_FOTOGALERY_CATEGORY JOIN 2020_FOTOGALERY USING (CATEGORY_ID) WHERE CATEGORY_ID=:id');
$fotografie->execute([
    ':id' => $photoArray[$offset]
]);
$resultFotogalerie = $fotografie->fetchAll(PDO::FETCH_ASSOC);

$fotografieHeader = $db->prepare('SELECT * FROM 2020_FOTOGALERY_CATEGORY JOIN 2020_FOTOGALERY USING (CATEGORY_ID) WHERE CATEGORY_ID=:id');
$fotografieHeader->execute([
    ':id' => $photoArray[$offset]
]);
$resultFotogalerieHeader = $fotografieHeader->fetch(PDO::FETCH_ASSOC);
$pageTitle = "Fotky akcí školy - ";

$error = "";
if (isset($_POST['createpdf'])) {
    $file_folder = "fotogalery/original/" . $resultFotogalerieHeader['CATEGORY_ID'] . "/";
    if (extension_loaded('zip')) {
        $zip = new ZipArchive();
        $zip_name = time() . ".zip";
        if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
            $error .= "Stahování selhalo, zkuste to prosím znovu";
        }
        foreach ($resultFotogalerie as $photo) {
            $zip->addFile($file_folder . $photo['ROUTE']);
        }
        $zip->close();
        if (file_exists($zip_name)) {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment;filename="' . $zip_name . '"');
            readfile($zip_name);
            unlink($zip_name);
        }
    } else {
        $error .= "Není nainstalováno ZIP rozšíření";
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "inc/headFoto.php" ?>
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="fotogalerie">
    <h2>Fotky akcí školy</h2>
    <?
    echo '<h3>';
    echo $resultFotogalerieHeader['NAME'];
    echo '</h3>';
    echo $error;
    echo '<form name="zips" method="post">';
    echo '<input type="submit" class="download" name="createpdf" value="Stáhnout fotogalerii">';
    echo '</form>';
    foreach ($resultFotogalerie as $photo) {
        if ($photo['poloha'] == '1') {
            echo "<a class='grouped_elements' rel='photogalery' href=" . 'fotogalery/maxi/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . 'fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='vodorovne'>" . "</a>";
        } else {
            echo "<a class='grouped_elements' rel='photogalery' href=" . 'fotogalery/maxi/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . 'fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='svisle'>" . "</a>";
        }
    }
    echo '<div class="ownpagination">';
    echo($_GET['offset'] > 9 ? '<a href="photogalery.php?offset=' . ($_GET['offset'] - 10) . '">&lt;&lt;</a>' : '');
    echo($_GET['offset'] > 0 ? '<a href="photogalery.php?offset=' . ($_GET['offset'] - 1) . '">&lt;</a>' : '');
    for ($i = $_GET['offset']; $i <= sizeof($photoArray) - 1; $i++) {
        echo '<a class="' . ($_GET['offset'] == $i ? 'active' : '') . '" href="photogalery.php?offset=' . ($i) . '">' . $i . '</a>';
    }
    echo($_GET['offset'] <= sizeof($photoArray) - 2 ? '<a href="photogalery.php?offset=' . ($_GET['offset'] + 1) . '">&gt;</a>' : '');
    echo($_GET['offset'] <= sizeof($photoArray) - 11 ? '<a href="photogalery.php?offset=' . ($_GET['offset'] + 10) . '">&gt;&gt;</a>' : '');
    echo '</div>';
    ?>
</main>
<footer>
    <?php include "inc/footer.php" ?>
</footer>
<script>
    $("header nav a:nth-child(3)").addClass("active");
</script>
<script>
    $("a.grouped_elements").fancybox();
</script>
</body>
</html>
