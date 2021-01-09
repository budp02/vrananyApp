<?php

session_start();

/*

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor schoolYear.php slouží k zobrazení informací o aktuálním školním roce

 * */

setlocale(LC_TIME, 'cs_CZ.UTF-8');
require 'inc/db.php';
$skolniRok = $db->query('SELECT NAME FROM 2020_OTHERS WHERE ID=1')->fetch(PDO::FETCH_ASSOC);
$reditel = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION_NAME =:position');
$reditel->execute([
    ':position' => 'Ředitel'
]);
$resultReditel = $reditel->fetchAll(PDO::FETCH_ASSOC);
$kuchar = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION_NAME =:position');
$kuchar->execute([
    ':position' => 'Kuchař'
]);
$resultKuchar = $kuchar->fetchAll(PDO::FETCH_ASSOC);
$ucitel = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION_NAME =:position');
$ucitel->execute([
    ':position' => 'Učitel'
]);
$resultUcitel = $ucitel->fetchAll(PDO::FETCH_ASSOC);
$vychovatel = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION_NAME =:position');
$vychovatel->execute([
    ':position' => 'Vychovatel'
]);
$resultVychovatel = $vychovatel->fetchAll(PDO::FETCH_ASSOC);
$skolniRada = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION_NAME =:position');
$skolniRada->execute([
    ':position' => 'Školní rada'
]);
$resultSkolniRada = $skolniRada->fetchAll(PDO::FETCH_ASSOC);
$ostatni = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION_NAME =:position');
$ostatni->execute([
    ':position' => 'Ostatní'
]);
$resultOstatni = $ostatni->fetchAll(PDO::FETCH_ASSOC);
$zvoneni = $db->query('SELECT * FROM 2020_RINGING')->fetchAll(PDO::FETCH_ASSOC);
$prazdniny = $db->prepare('SELECT * FROM 2020_EVENTS JOIN 2020_EVENTS_TYPE USING (EVENT_ID) WHERE EVENT_NAME =:event');
$prazdniny->execute([
    ':event' => 'Prázdniny'
]);
$resultPrazdniny = $prazdniny->fetchAll(PDO::FETCH_ASSOC);
$tridniSchuzky = $db->prepare('SELECT * FROM 2020_EVENTS JOIN 2020_EVENTS_TYPE USING (EVENT_ID) WHERE EVENT_NAME =:event');
$tridniSchuzky->execute([
    ':event' => 'Třídní schůzky'
]);
$resultTridniSchuzky = $tridniSchuzky->fetchAll(PDO::FETCH_ASSOC);
$zapis = $db->prepare('SELECT * FROM 2020_EVENTS JOIN 2020_EVENTS_TYPE USING (EVENT_ID) WHERE EVENT_NAME =:event');
$zapis->execute([
    ':event' => 'Zápis'
]);
$resultZapis = $zapis->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Aktuální školní rok - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "inc/head.php" ?>
<body>
<header>
    <?php include "inc/header.php" ?>
</header>
<main class="skolni_rok">
    <h2>
        <?php echo "Aktuální školní rok" . " " . $skolniRok["NAME"]; ?>
    </h2>
    <h3>
        Zaměstnanci školy
    </h3>
    <h4>
        Pro zjištění emailové adresy vyučujícího umístěte kurzor na jeho jméno.
    </h4>
    <br>
    <div class="employee">
        <div>
            <h4>
                Ředitelka školy
            </h4>
            <?php
            foreach ($resultReditel as $recordReditel) {
                echo '<strong>';
                echo '<abbr title=' . $recordReditel['EMAIL'] . '>';
                echo $recordReditel['NAME'];
                echo '</abbr>';
                echo '</strong>';
                echo (!empty($recordReditel['DESCRIPTION'])) ? ' - ' . $recordReditel['DESCRIPTION'] : '';
                echo '<br>';
            }
            ?>
            <br>
            <h4>
                Učitelé
            </h4>
            <?php
            foreach ($resultUcitel as $recordUcitel) {
                echo '<strong>';
                echo '<abbr title=' . $recordUcitel['EMAIL'] . '>';
                echo $recordUcitel['NAME'];
                echo '</abbr>';
                echo '</strong>';
                echo ' - ' . $recordUcitel['DESCRIPTION'];
                echo '<br>';
            }
            ?>
            <br>
            <h4>
                Vychovatelé
            </h4>
            <?php
            foreach ($resultVychovatel as $recordVychovatel) {
                echo '<strong>';
                echo '<abbr title=' . $recordVychovatel['EMAIL'] . '>';
                echo $recordVychovatel['NAME'];
                echo '</abbr>';
                echo '</strong>';
                echo ' - ' . $recordVychovatel['DESCRIPTION'];
                echo '<br>';
            }
            ?>
        </div>
        <div>
            <h4>
                Kuchařky
            </h4>
            <?php
            foreach ($resultKuchar as $recordKuchar) {
                echo '<strong>';
                echo '<abbr title=' . $recordKuchar['EMAIL'] . '>';
                echo $recordKuchar['NAME'];
                echo '</abbr>';
                echo '</strong>';
                echo ' - ' . $recordKuchar['DESCRIPTION'];
                echo '<br>';
            }
            ?>
            <br>
            <h4>
                Ostatní
            </h4>
            <?php
            foreach ($resultOstatni as $recordOstatni) {
                echo '<strong>';
                echo '<abbr title=' . $recordOstatni['EMAIL'] . '>';
                echo $recordOstatni['NAME'];
                echo '</abbr>';
                echo '</strong>';
                echo ' - ' . $recordOstatni['DESCRIPTION'];
                echo '<br>';
            }
            ?>
            <br>
            <h4>
                <?php echo "Složení školské rady ve školním roce" . " " . $skolniRok["NAME"]; ?>
            </h4>
            <?php
            foreach ($resultSkolniRada as $recordSkolniRada) {
                echo '<strong>';
                echo '<abbr title=' . $recordSkolniRada['EMAIL'] . '>';
                echo $recordSkolniRada['NAME'];
                echo '</abbr>';
                echo '</strong>';
                echo ' - ' . $recordSkolniRada['DESCRIPTION'];
                echo '<br>';
            }
            ?>
        </div>
    </div>
    <h3>
        Rozpis vyučovacích hodin
    </h3>
    <p>
        <?php
        foreach ($zvoneni as $recordZvoneni) {
            echo '<span class="ident2">';
            echo '<strong>';
            echo $recordZvoneni['HOUR'];
            echo '</strong>';
            echo '</span>';
            echo ' ' . date('H:i', strtotime($recordZvoneni['START'])) . ' - ' . date('H:i', strtotime($recordZvoneni['END']));
            echo '<br>';
        }
        ?>
    </p>
    <h3>
        Prázdniny ve školním roce
    </h3>
    <p>
        <?php
        foreach ($resultPrazdniny as $recordPrazdniny) {
            echo '<span class="ident2">';
            echo '<strong>';
            echo $recordPrazdniny['TYPE'] . ' prázdniny';
            echo '</strong>';
            echo '</span>';
            echo strftime('%A', strtotime($recordPrazdniny['START'])) . ' ';
            echo '<strong>';
            echo strftime('%d. %B %G', strtotime($recordPrazdniny['START'])) . ' - ';
            echo '</strong>';
            echo strftime('%A', strtotime($recordPrazdniny['END'])) . ' ';
            echo '<strong>';
            echo strftime('%d. %B %G', strtotime($recordPrazdniny['END']));
            echo '</strong>';
            echo '<br>';
        }
        ?>
    </p>
    <h3>
        Třídní schůzky ve školním roce
    </h3>
    <p>
        <?php
        foreach ($resultTridniSchuzky as $recordTridniSchuzky) {
            echo strftime('%A', strtotime($recordTridniSchuzky['START'])) . ' ';
            echo '<strong>';
            echo strftime('%d. %B %G', strtotime($recordTridniSchuzky['START'])) . ' od ';
            echo '</strong>';
            echo date('H:i', strtotime($recordTridniSchuzky['START'])) . ' hod. ';
            echo '<br>';
        }
        ?>
    </p>
    <h3>
        Zápis do 1. třídy</h3>
    <p>
        <?php
        foreach ($resultZapis as $recordZapis) {
            echo strftime('%A', strtotime($recordZapis['START'])) . ' ';
            echo '<strong>';
            echo strftime('%d. %B %G', strtotime($recordZapis['START'])) . ' od ';
            echo '</strong>';
            echo date('H:i', strtotime($recordZapis['START'])) . ' hod. ';
            echo '<br>';
        }
        ?>
    </p>
    <h3>
        Rozvrhy hodin
    </h3>
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo '<h4>';
        echo $i . ' . třída';
        $rozvrh = $db->prepare('SELECT * FROM 2020_SCHEDULES WHERE CLASS =:class');
        $rozvrh->execute([
            ':class' => $i
        ]);
        $resultRozvrh = $rozvrh->fetchAll(PDO::FETCH_ASSOC);
        echo '</h4>';
        echo '<table class="rozvrh">';
        echo '<tr>';
        echo '<th rowspan="2" >Den</th>';
        echo '<th colspan="8">Hodina</th>';
        echo '</tr>';
        echo '<tr class="hodiny">';
        echo '<th class="hod1">1</th>';
        echo '<th class="hod2">2</th>';
        echo '<th class="hod3">3</th>';
        echo '<th class="hod4">4</th>';
        echo '<th class="hod5">5</th>';
        echo '<th class="hod6">6</th>';
        echo '<th class="hod7">7</th>';
        echo '<th class="hod8">8</th>';
        echo '</tr>';
        foreach ($resultRozvrh as $recordRozvrh) {
            echo "<tr>";
            echo "<td>" . $recordRozvrh['DAY'] . "</td>";
            echo "<td>" . $recordRozvrh['FIRST'] . "</td>";
            echo "<td>" . $recordRozvrh['SECOND'] . "</td>";
            echo "<td>" . $recordRozvrh['THIRD'] . "</td>";
            echo "<td>" . $recordRozvrh['FOURTH'] . "</td>";
            echo "<td>" . $recordRozvrh['FIFTH'] . "</td>";
            echo "<td>" . $recordRozvrh['SIXTH'] . "</td>";
            echo "<td>" . $recordRozvrh['SEVENTH'] . "</td>";
            echo "<td>" . $recordRozvrh['EIGHTH'] . "</td>";
            echo "</tr>";
        }
        echo '</table>';
        echo '<br>';
    }
    ?>
</main>
<footer>
    <?php include "inc/footer.php" ?>
</footer>
<script>
    $("header nav a:nth-child(2)").addClass("active");
</script>
</body>
</html>