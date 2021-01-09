<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptDeleteAJAX.php zpracovává mazání záznamů
 * data jsou přijata z scriptDeleteAJAX.js
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * jsou zde zpracovávány všechny soubory ze složky admin
 * */
require('../inc/db.php');
require '../inc/userRequired.php';
setlocale(LC_TIME, 'cs_CZ.UTF-8');
$type = $_POST['type'];
switch ($type) {
    case 'NOTIFIKACE':
        $deleteQuery = $db->prepare('DELETE FROM 2020_NOTIFICATION WHERE ID_NOTICE=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $result["message"] = 'Záznam úspěšně odstraněn';
        $result["status"] = 1;
        echo json_encode($result);
        break;
    case 'USERS':
        $deleteQuery = $db->prepare('DELETE FROM 2020_EMPLOYEES WHERE ID=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $result["message"] = 'Záznam úspěšně odstraněn';
        $result["status"] = 1;
        echo json_encode($result);
        break;
    case 'ZVONENI':
        $deleteQuery = $db->prepare('DELETE FROM 2020_RINGING WHERE ID=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $result["message"] = 'Záznam úspěšně odstraněn';
        $result["status"] = 1;
        echo json_encode($result);
        break;
    case 'UDALOSTI':
        $deleteQuery = $db->prepare('DELETE FROM 2020_EVENTS WHERE ID=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $result["message"] = 'Záznam úspěšně odstraněn';
        $result["status"] = 1;
        echo json_encode($result);
        break;
    case 'FOTO':
        $query = $db->prepare('SELECT * FROM 2020_FOTOGALERY WHERE ID=:id;');
        $query->execute([
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $routeMIN = '../fotogalery/mini/' . $data['CATEGORY_ID'] . '/' . $data['ROUTE'];
        $routeMAX = '../fotogalery/maxi/' . $data['CATEGORY_ID'] . '/' . $data['ROUTE'];
        $routeORIGINAL = '../fotogalery/original/' . $data['CATEGORY_ID'] . '/' . $data['ROUTE'];
        if (file_exists($routeMIN)) {
            unlink($routeMIN);
        }
        if (file_exists($routeMAX)) {
            unlink($routeMAX);
        }
        if (file_exists($routeORIGINAL)) {
            unlink($routeORIGINAL);
        }
        $deleteQuery = $db->prepare('DELETE FROM 2020_FOTOGALERY WHERE ID=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        break;
}