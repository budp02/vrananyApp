<?php
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor schoolCanteenMenu.php obsahuje jídelní lístek školy
 * */
setlocale(LC_TIME, 'cs_CZ.UTF-8');
require 'inc/db.php';
$query = $db->query('SELECT * FROM 2020_MENU')->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Jídelní lístek";
?>
<!DOCTYPE html>
<html lang="cs">
<?php
include 'inc/headCanteen.php';
?>
<body>
<main class="jidelniListekMenu">
    <div class="container">
        <img class="center" alt="jidelní lístek" src="img/listek.png">
        <?php foreach ($query as $recordQuery) {
            $day = $db->query('SELECT NAME FROM 2020_OTHERS WHERE ID=3')->fetchColumn();
            $date = date_create($day);
            echo '<div class="newItemMenu">';
            echo '<div class="important day">';
            switch ($recordQuery['DAY']) {
                case'Pondělí':
                    break;
                case'Úterý':
                    date_add($date, date_interval_create_from_date_string("1 days"));
                    break;
                case'Středa':
                    date_add($date, date_interval_create_from_date_string("2 days"));
                    break;
                case'Čtvrtek':
                    date_add($date, date_interval_create_from_date_string("3 days"));
                    break;
                case'Pátek':
                    date_add($date, date_interval_create_from_date_string("4 days"));
                    break;
            }
            $dayMonth = date_format($date, "Y-m-d");
            echo strftime('%A', strtotime($dayMonth)) . ' ' . strftime('%d. %B %G', strtotime($dayMonth));
            echo '</div>';
            echo '<div>';
            echo '<table>';
            echo !empty($recordQuery['SOUP']) ? ('<tr>' . '<td class="important">' . 'Polévka' . '</td>' . '<td>' . $recordQuery['SOUP'] . '</td>' . '</tr>') : '';
            echo !empty($recordQuery['MAIN_MEAL']) ? ('<tr>' . '<td class="important">' . 'Hlavní pokrm' . '</td>' . '<td>' . $recordQuery['MAIN_MEAL'] . '</td>' . '</tr>') : '';
            echo !empty($recordQuery['DESSERT']) ? ('<tr>' . '<td class="important">' . 'Ovoce a zelenina' . '</td>' . '<td>' . $recordQuery['DESSERT'] . '</td>' . '</tr>') : '';
            echo !empty($recordQuery['DRINKS']) ? ('<tr>' . '<td class="important">' . 'Nápoje' . '</td>' . '<td>' . $recordQuery['DRINKS'] . '</td>' . '</tr>') : '';
            echo '</table>';
            echo '</div>';
            echo '</div>';
        } ?>
        <hr>
        <span style="font-weight: bold;font-size: larger">*A-Pokrm obsahuje alergeny!!!</span> <span
                style="font-size: small">Informaci o konkrétní látce vyvolávající alergie nebo nesnášenlivost, Vám na vyžádání sdělí personál kuchyně.<br>
    Pitný režim pro ZŠ a MŠ zajištěn.<br>
    Ovoce a zelenina dle nabídky,(každý den voda + další nápoje dle nabídky).<br>
        <strong>Pokrm je určen k okamžité spotřebě!!!</strong><br>
        Změna jídelního lístku vyhrazena!</span>
    </div>
</main>
</body>
</html>
