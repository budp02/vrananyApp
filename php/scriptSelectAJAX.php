<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptSelectAJAX.php zpracovává zobrazení záznamů
 * data jsou přijata z scriptSelectAJAX.js
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * jsou zde zpracovávány všechny soubory ze složky admin
 * */
require('../inc/db.php');
require '../inc/userRequired.php';
setlocale(LC_TIME, 'cs_CZ.UTF-8');
$type = $_POST['type'];
switch ($type) {
    case 'SOUBOR':
        $query = $db->prepare('SELECT * FROM 2020_PDF_FILES WHERE CATEGORY=:id ORDER BY CREATED desc');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultQuery as $recordQuery) {
            echo '<div>';
            echo $recordQuery['DESCRIPTION'];
            echo '</div>';
        }
        break;
    case 'NOTIFIKACE':
        $class = $_POST['ID'];
        $query = $db->prepare('SELECT * FROM 2020_NOTIFICATION INNER JOIN 2020_CATEGORIES USING (CATEGORY) WHERE CATEGORY_NAME=:podminka ORDER BY CREATED DESC;');
        $query->execute([
            'podminka' => $class
        ]);
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                echo '<div class="prispevek" style="border: 2px solid' . $post['BORDER_COLOR'] . '">';
                echo '<div class="prispevekText"><u><strong>' . $post['TITLE'] . '</strong></u><br><br>';
                echo $post['DESCRIPTION'] . '<br>';
                echo '<div class=zverejneni>';
                echo $post['FOUNDER'] . " " . date('d.m.Y H:i', strtotime($post['CREATED']));
                echo '</div>';
                echo '</div>';
                echo '<div class="prispevekEdit">';
                echo '<a onclick=insertIntoForm(' . $post['ID_NOTICE'] . ',"NOTIFIKACE")><img src="../img/edit.png" height="32px" title="Upravit"></a>';
                echo '<a onclick=deleteData(' . $post['ID_NOTICE'] . ',"NOTIFIKACE")><img src="../img/delete.png" height="32px" title="Odstranit"></a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo 'Žádné příspěvky v dané kategorii.';
        }
        break;
    case 'FOTO':
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
        if (!empty($resultFotogalerie)) {
            echo '<h3>' . $catName['NAME'] . '</h3>';
            foreach ($resultFotogalerie as $photo) {
                if ($photo['poloha'] == '1') {
                    echo "<a href=" . '../fotogalery/original/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " target=" . _blank . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . '../fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='vodorovne'>" . "</a>";
                } else {
                    echo "<a href=" . '../fotogalery/original/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " target=" . _blank . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . '../fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='svisle'>" . "</a>";
                }
            }
        } else {
            echo "Žádné fotky se v dané kategorii nenachází";
        }
        break;
    case 'PRAVA':
        $query = $db->query('SELECT * FROM 2020_USERS')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($query as $recordQuery) {
            echo '<tr>';
            echo '<td>' . $recordQuery['USERNAME'] . '</td>';
            echo '<td>' . $recordQuery['MAIL'] . '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['ACTIVE'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['ADMIN'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['UVOD'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['SKOLNI_ROK'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['FOTKY'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['TRIDY'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['DOKUMENTY'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<label class="switcher">';
            echo ($recordQuery['JIDELNA'] == 1) ? '<input type="checkbox" class="custom-control-input" id="switch' . $recordQuery['id'] . '" checked>' : '<input class="custom-control-input" id="switch' . $recordQuery['id'] . '" type="checkbox">';
            echo '<div class="switcher__indicator"></div>';
            echo '</label>';
            echo '</td>';

            echo '<td>';
            echo '<button class="btn btn-secondary" onclick=insertIntoForm(' . $recordQuery['ID'] . ',"PRAVA")>';
            echo 'Editovat';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
        break;
    case 'SKOLNIROK':
        $query = $db->prepare('SELECT * FROM 2020_OTHERS WHERE ID =:id');
        $query->execute([
            ':id' => 1
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo $resultQuery['NAME'];
        echo '<button class="btn btn-secondary" id="skolniRokButton" onclick=insertIntoForm(' . $resultQuery['ID'] . ',"' . $type . '")>';
        echo 'Editovat';
        echo '</button>';
        break;
    case 'USERS':
        $query = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE POSITION =:position');
        $query->execute([
            ':position' => $_POST['ID']
        ]);
        $resultQuery = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultQuery as $recordQuery) {
            echo '<tr>';
            echo '<td>' . $recordQuery['NAME'] . '</td>';
            echo '<td>' . $recordQuery['EMAIL'] . '</td>';
            echo '<td>' . $recordQuery['DESCRIPTION'] . '</td>';
            echo '<td>';
            echo '<button class="btn btn-secondary" onclick=insertIntoForm(' . $recordQuery['ID'] . ',"' . $type . '")>';
            echo 'Editovat';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
        break;
    case 'ZVONENI':
        $query = $db->query('SELECT * FROM 2020_RINGING')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($query as $recordQuery) {
            echo '<tr>';
            echo '<td>' . $recordQuery['HOUR'] . '</td>';
            echo '<td>' . date('H:i', strtotime($recordQuery['START'])) . '</td>';
            echo '<td>' . date('H:i', strtotime($recordQuery['END'])) . '</td>';
            echo '<td>';
            echo '<button class="btn btn-secondary" onclick=insertIntoForm(' . $recordQuery['ID'] . ',"' . $type . '")>';
            echo 'Editovat';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
        break;
    case 'UDALOSTI':
        $query = $db->prepare('SELECT * FROM 2020_EVENTS JOIN 2020_EVENTS_TYPE USING (EVENT_ID) WHERE EVENT_ID =:event');
        $query->execute([
            ':event' => $_POST['ID']
        ]);
        $resultQuery = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultQuery as $recordQuery) {
            echo '<tr>';
            echo (!empty($recordQuery['TYPE'])) ? '<td>' . $recordQuery['TYPE'] . '</td>' : '<td>' . '-' . '</td>';
            echo '<td>';
            if (!empty($recordQuery['START'])) {
                echo strftime('%A', strtotime($recordQuery['START'])) . ' ' . strftime('%d. %B %G', strtotime($recordQuery['START']));
                if ($_POST['ID'] != 2) {
                    echo ' ' . date('H:i', strtotime($recordQuery['START'])) . ' hod. ';
                }
            } else {
                echo '-';
            }
            echo '</td>';
            echo '<td>';
            if (!empty($recordQuery['END'])) {
                echo strftime('%A', strtotime($recordQuery['END'])) . ' ' . strftime('%d. %B %G', strtotime($recordQuery['END']));
                if ($_POST['ID'] != 2) {
                    echo ' ' . date('H:i', strtotime($recordQuery['END'])) . ' hod. ';
                }
            } else {
                echo '-';
            }
            echo '</td>';
            echo '<td>';
            echo '<button class="btn btn-secondary" onclick=insertIntoForm(' . $recordQuery['ID'] . ',"' . $type . '")>';
            echo 'Editovat';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
        break;
    case 'ROZVRH':
        $query = $db->prepare('SELECT * FROM 2020_SCHEDULES WHERE CLASS =:class');
        $query->execute([
            ':class' => $_POST['ID']
        ]);
        $resultQuery = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultQuery as $recordQuery) {
            echo '<tr>';
            echo '<td>' . $recordQuery['DAY'] . '</td>';
            echo '<td>' . $recordQuery['FIRST'] . '</td>';
            echo '<td>' . $recordQuery['SECOND'] . '</td>';
            echo '<td>' . $recordQuery['THIRD'] . '</td>';
            echo '<td>' . $recordQuery['FOURTH'] . '</td>';
            echo '<td>' . $recordQuery['FIFTH'] . '</td>';
            echo '<td>' . $recordQuery['SIXTH'] . '</td>';
            echo '<td>' . $recordQuery['SEVENTH'] . '</td>';
            echo '<td>' . $recordQuery['EIGHTH'] . '</td>';
            echo '<td>';
            echo '<button class="btn btn-secondary" onclick=insertIntoForm(' . $recordQuery['ID'] . ',"' . $type . '")>';
            echo 'Editovat';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
        break;
    case 'LISTEK':
        $query = $db->query('SELECT * FROM 2020_MENU')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($query as $recordQuery) {
            echo '<tr>';
            echo '<td>' . $recordQuery['DAY'] . '</td>';
            echo '<td>' . $recordQuery['SOUP'] . '</td>';
            echo '<td>' . $recordQuery['MAIN_MEAL'] . '</td>';
            echo '<td>' . $recordQuery['DESSERT'] . '</td>';
            echo '<td>' . $recordQuery['DRINKS'] . '</td>';
            echo '<td>';
            echo '<button class="btn btn-secondary" onclick=insertIntoForm(' . $recordQuery['ID'] . ',"' . $type . '")>';
            echo 'Editovat';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
        break;
    case 'KATEGORIEFOTO':
        $category = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY ORDER BY CATEGORY_ID DESC;')->fetchAll(PDO::FETCH_ASSOC);
        echo '<select aria-label="Kategorie" class="form-control custom-select" required id="category" name="category">';
        echo '<option value="">--Vyberte kategorii--</option>';
        if (!empty($category)) {
            foreach ($category as $item) {
                echo '<option value=' . $item['CATEGORY_ID'] . '>' . $item['NAME'] . '</option>';
            }
        }
        echo '</select>';
        break;
    case 'KATEGORIEFOTOPRESENT':
        $category = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY ORDER BY CATEGORY_ID DESC;')->fetchAll(PDO::FETCH_ASSOC);
        echo '<select aria-label="Kategorie" class="form-control custom-select" required id="photogalery" name="photogalery" onchange=show(this.value,"PHOTOGALERY")>';
        echo '<option value="">--Vyběrem zobrazte fotogalerii--</option>';
        if (!empty($category)) {
            foreach ($category as $item) {
                echo '<option value=' . $item['CATEGORY_ID'] . '>' . $item['NAME'] . '</option>';
            }
        }
        echo '</select>';
        break;
    case 'KATEGORIEFOTOARCHIV':
        $category = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY ORDER BY CATEGORY_ID DESC;')->fetchAll(PDO::FETCH_ASSOC);
        echo '<select aria-label="Kategorie" class="form-control custom-select" required id="photogaleryArchiv" name="photogaleryArchiv">';
        echo '<option value="">--Vyberte kategorii--</option>';
        if (!empty($category)) {
            foreach ($category as $item) {
                echo '<option value=' . $item['CATEGORY_ID'] . '>' . $item['NAME'] . '</option>';
            }
        }
        echo '</select>';
        break;
    case 'PHOTOGALERY':
        $photoArray = array();
        $query = $db->query('SELECT * FROM 2020_FOTOGALERY_CATEGORY')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($query as $recordQuery) {
            array_push($photoArray, $recordQuery['kategorie_ID']);
        }

        $fotografie = $db->prepare('SELECT * FROM 2020_FOTOGALERY_CATEGORY JOIN 2020_FOTOGALERY USING (CATEGORY_ID) WHERE CATEGORY_ID=:id');
        $fotografie->execute([
            ':id' => $_POST['ID']
        ]);
        $resultFotogalerie = $fotografie->fetchAll(PDO::FETCH_ASSOC);

        $fotografieHeader = $db->prepare('SELECT * FROM 2020_FOTOGALERY_CATEGORY JOIN 2020_FOTOGALERY USING (CATEGORY_ID) WHERE CATEGORY_ID=:id');
        $fotografieHeader->execute([
            ':id' => $_POST['ID']
        ]);
        $resultFotogalerieHeader = $fotografieHeader->fetch(PDO::FETCH_ASSOC);
        echo '<h3>';
        echo $resultFotogalerieHeader['NAME'];
        echo '</h3>';
        echo "<div class='foto'>";
        foreach ($resultFotogalerie as $photo) {
            if ($photo['poloha'] == '1') {
                echo "<div class='img-wrap'>";
                echo '<span onclick=deleteData(' . $photo['ID'] . ',"FOTO") class="close">&times;</span>';
                echo "<a href=" . '../fotogalery/maxi/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " target=" . _blank . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . '../fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='vodorovne'>" . "</a>";
                echo "</div>";
            } else {
                echo "<div class='img-wrap'>";
                echo '<span onclick=deleteData(' . $photo['ID'] . ',"FOTO") class="close">&times;</span>';
                echo "<a href=" . '../fotogalery/maxi/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " target=" . _blank . " title='" . $photo['NAME'] . "'>" . "<img alt='photoMin' src=" . '../fotogalery/mini/' . $photo['CATEGORY_ID'] . '/' . $photo['ROUTE'] . " class='svisle'>" . "</a>";
                echo "</div>";
            }
        }
        echo "</div>";
        break;
}
?>
