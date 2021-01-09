<?php

session_start();

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor schoolClasses.php obsahuje všechny možné školní třídy a příslušné aktuální informace k nim

 * */

require 'inc/db.php';
if (!empty($_GET['class'])) {
    $class = $_GET['class'] . ". " . "třída";
    $query = $db->prepare('SELECT * FROM 2020_NOTIFICATION INNER JOIN 2020_CATEGORIES USING (CATEGORY) WHERE CATEGORY_NAME=:podminka ORDER BY CREATED DESC;');
    $query->execute([
        'podminka' => $class
    ]);
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
}
$pageTitle = "Třídy - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "inc/head.php" ?>
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="tridy">
    <h2>Třídy</h2>
    <div class="bags">
        <a href="schoolClasses.php?class=1" title="1.Třída"><img src="img/blue.jpg" alt="prnaci"></a>
        <a href="schoolClasses.php?class=2" title="2.Třída"><img src="img/green.jpg" alt="druhaci"></a>
        <a href="schoolClasses.php?class=3" title="3.Třída"><img src="img/red.jpg" alt="tretaci"></a>
        <a href="schoolClasses.php?class=4" title="4.Třída"><img src="img/yellow.jpg" alt="ctvrtaci"></a>
        <a href="schoolClasses.php?class=5" title="5.Třída"><img src="img/purple.jpg" alt="pataci"></a>
    </div>
    <?php
    echo '<h2>' . $class . '</h2>';
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
    if ($class == "1. třída") {
        ?>
        </div>
        <h2>Informace pro rodiče a prvňáčky</h2>
        <p>Touto cestou chceme Vám a dětem zjednodušit a zpříjemnit jinak nelehkou pouť první třídou.</p> <br>
        <h3>Co by měl prvňáček trénovat</h3>
        <ul class=list-1>
            <li>znát své jméno, příjmení a svoji adresu</li>
            <li>obléknout se i převléknout, zavázat si tkaničky</li>
            <li>uklidit po sobě nepořádek</li>
            <li>kreslit tužkou a pastelkami i malovat barvami</li>
            <li>poznávat základní barvy</li>
            <li>vystřihnout obrázek podle okraje</li>
            <li>vyslechnout krátké vyprávění nebo pohádku</li>
            <li>umět rozlišit pravou a levou stranu</li>
            <li>sám pohovořit o příběhu, který se mu líbil</li>
        </ul>
        <br>
        <a href=pdf/psani.pdf title="Nácvik psaní" style=margin-left:10px><img src=img/pencil.jpg alt="psani"></a>
        <a href=pdf/cteni.pdf title="Nácvik čtení"><img src=img/book.jpg alt="cteni"></a>
        <h3>Několik rad pro rodiče prvňáčků</h3>
        <p>Umožnit dítěti klidné místo pro přípravu do školy. Každý den provádět kontrolu školní tašky a penálu
            (ořezané tužky, pastelky mít do zásoby). Pomáhat dítěti v přípravě do školy a ze začátku společně
            ukládat věci do tašky. Rozdělit si přípravu do školy na kratší časové úseky (nepřetěžovat prvňáčka).</p>
        <p>Povídat si s dítětem o tom, co ve škole prožilo. Pohladit a pochválit svého prvňáčka, nestrašit jej
            školou. Spolu s dítětem prožívat dění ve škole a účastnit se akcí pořádaných školou a třídou. Školní
            věci koupit až po informativní schůzce.</p>
        <h3>Seznam potřebných pomůcek</h3>
        <h4>Do penálu:</h4>
        <ul class=list-1>
            <li>ořezané tužky /3ks/</li>
            <li>nůžky /leváci nůžky pro leváky/</li>
            <li>pastelky /hrubé, alespoň 12 barev/</li>
            <li>gumu</li>
            <li>ořezávátko</li>
        </ul>
        <h4>Věci na tělesnou výchovu</h4>
        <ul class=list-1>
            <li>nyní probíhá místo tělesné výchovy plavání /ručník, plavky, koupací čepice, hřeben, tekuté mýdlo/
            </li>
            <li>cvičební úbor</li>
            <li>tričko, tepláky, mikina /vše pohodlné/</li>
            <li>cvičky s bílou podrážkou</li>
        </ul>
        <h4>Další</h4>
        <ul class=list-1>
            <li>přezůvky /klasické bačkory/</li>
            <li>ručník s poutkem</li>
            <li>stírací tabulka</li>
            <li>kufřík na pomůcky k výtvarné výchově a pracovním činnostem</li>
            <li>látkový ubrousek na prostírání svačiny</li>
        </ul>
    <?php } ?>
</main>
<footer>
    <?php include "inc/footer.php" ?>
</footer>
<script>
    $("header nav a:nth-child(4)").addClass("active");
</script>
</body>
</html>

