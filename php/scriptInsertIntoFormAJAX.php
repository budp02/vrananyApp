<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptInsertIntoFormAJAX.php zpracovává vkládání záznamů do formulářů
 * data jsou přijata z scriptInsertIntoFormAJAX.js
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * jsou zde zpracovávány všechny soubory ze složky admin
 * */
require('../inc/db.php');
require '../inc/userRequired.php';
$type = $_POST['type'];
switch ($type) {
    case 'SOUBOR':
        $query = $db->prepare('SELECT * FROM 2020_PDF_FILES WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'NOTIFIKACE':
        $query = $db->prepare('SELECT * FROM 2020_NOTIFICATION WHERE ID_NOTICE =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'PRAVA':
        $query = $db->prepare('SELECT * FROM 2020_USERS WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'SKOLNIROK':
        $query = $db->prepare('SELECT * FROM 2020_OTHERS WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'MENULISTEK':
        $query = $db->prepare('SELECT * FROM 2020_OTHERS WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'USERS':
        $query = $db->prepare('SELECT * FROM 2020_EMPLOYEES JOIN 2020_POSITIONS USING (POSITION) WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'ZVONENI':
        $query = $db->prepare('SELECT * FROM 2020_RINGING WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'UDALOSTI':
        $query = $db->prepare('SELECT * FROM 2020_EVENTS WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        $resultQuery = array('ID' => $resultQuery['ID'], 'EVENT_ID'=>$resultQuery['EVENT_ID'], 'typ' => $resultQuery['TYPE'], 'od' => (date('Y-m-d', strtotime($resultQuery['START']))) . 'T' . date('H:i', strtotime($resultQuery['START'])), 'do' => (date('Y-m-d', strtotime($resultQuery['END']))) . 'T' . date('H:i', strtotime($resultQuery['END'])));
        echo json_encode($resultQuery);
        break;
    case 'ROZVRH':
        $query = $db->prepare('SELECT * FROM 2020_SCHEDULES WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
    case 'LISTEK':
        $query = $db->prepare('SELECT * FROM 2020_MENU WHERE ID =:id');
        $query->execute([
            ':id' => $_POST['ID']
        ]);
        $resultQuery = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode($resultQuery);
        break;
}
