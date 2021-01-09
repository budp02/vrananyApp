<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptUpdateAJAX.php zpracovává aktualizaci záznamů
 * data jsou přijata z scriptUpdateAJAX.js
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * jsou zde zpracovávány všechny soubory ze složky admin
 * */
require('../inc/db.php');
require '../inc/userRequired.php';
$errors = array();
$type = $_POST['type'];
switch ($type){
    case 'FOTO':
        (empty($_POST['category_fotoID'])?array_push($errors,"Vyber kategorii fotogalery"):'');
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_OTHERS SET NAME=:name WHERE ID=2;');
            $updateQuery->execute([
                ':name' => htmlspecialchars($_POST['category_fotoID'])
            ]);
            $response['status'] = 1;
            $response['message'] = 'Kategorie zaktualizována';
        } else {
            $response['status'] = 0;
            $response["message"] = implode("<br>", $errors);
        }
        echo json_encode($response);
        break;
    case 'SOUBOR':
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_PDF_FILES SET DESCRIPTION=:popis WHERE ID=:id;');
            $updateQuery->execute([
                ':popis' => $_POST['text'],
                ':id' => $_POST['ID']
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'NOTIFIKACE':
        empty($_POST['header']) ? array_push($errors, "Nadpis musí být vyplněn!") : '';
        if (empty($errors)) {

            $updateQuery = $db->prepare('UPDATE 2020_NOTIFICATION SET TITLE=:nadpis, DESCRIPTION=:popis, BORDER_COLOR=:ramecek WHERE ID_NOTICE=:id;');
            $updateQuery->execute([
                ':nadpis' => htmlspecialchars($_POST['header']),
                ':popis' => $_POST['text'],
                ':ramecek' => htmlspecialchars($_POST['border']),
                ':id' => $_POST['ID']
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'PRAVA':
        $query = $db->prepare('SELECT COUNT(*) FROM 2020_USERS where USERNAME=:username AND NOT ID=:id');/*potřeba vyloučit vybraný záznam*/
        $query->execute([
            ':username' => htmlspecialchars(strtolower($_POST['jmeno'])),
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $num_rowsName = $query->fetchColumn();
        $query = $db->prepare('SELECT COUNT(*) FROM 2020_USERS where MAIL=:mail AND NOT ID=:id');/*potřeba vyloučit vybraný záznam*/
        $query->execute([
            ':mail' => htmlspecialchars(strtolower($_POST['email'])),
            ':id' => htmlspecialchars($_POST['ID'])
        ]);
        $num_rowsMail = $query->fetchColumn();
        if(!empty($_POST['jmeno'])){
            ($num_rowsName !=0) ? array_push($errors, "Jméno uživatele již existuje!") : '';
            (!preg_match('/^[a-z]{1,}[.][a-z]{1,}$/', $_POST['jmeno']))?array_push($errors, "Jméno uživatele neodpovídá vzoru jmeno.prijmeni!") : '';
        }
        else{
            array_push($errors, "Jméno uživatele musí být vyplněno!");
        }
        if(!empty($_POST['email'])){
            ($num_rowsMail !=0) ? array_push($errors, "Uživatel se zadaným mailem již existuje!") : '';
            (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? array_push($errors, "Email neodpovídá zadanému formátu") : '';
        }
        else{
            array_push($errors, "Email uživatele musí být vyplněn!");
        }
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_USERS SET USERNAME=:username, MAIL =:email,ACTIVE=:active,ADMIN=:admin,UVOD=:uvod,SKOLNI_ROK=:skolni_rok,FOTKY=:fotky,TRIDY=:tridy,DOKUMENTY=:dokumenty,JIDELNA=:jidelna WHERE ID=:id;');
            $updateQuery->execute([
                ':username' => htmlspecialchars($_POST['jmeno']),
                ':email' => htmlspecialchars($_POST['email']),
                ':active' => htmlspecialchars($_POST['active']),
                ':admin' => htmlspecialchars($_POST['admin']),
                ':uvod' => htmlspecialchars($_POST['uvod']),
                ':skolni_rok' => htmlspecialchars($_POST['skolni_rok']),
                ':fotky' => htmlspecialchars($_POST['fotogalerie']),
                ':tridy' => htmlspecialchars($_POST['tridy']),
                ':dokumenty' => htmlspecialchars($_POST['dokumenty']),
                ':jidelna' => htmlspecialchars($_POST['jidelna']),
                ':id' => htmlspecialchars($_POST['ID'])
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'SKOLNIROK':
        empty($_POST['skolniRok']) ? array_push($errors, "Školní rok musí být vyplněn!") : '';
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_OTHERS SET NAME=:name WHERE ID=:id;');
            $updateQuery->execute([
                ':name' => htmlspecialchars($_POST['skolniRok']),
                ':id' => 1
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'MENULISTEK':
        empty($_POST['menuDatum']) ? array_push($errors, "Počátek platnosti musí být vyplněn!") : '';
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_OTHERS SET NAME=:name WHERE ID=:id;');
            $updateQuery->execute([
                ':name' => htmlspecialchars($_POST['menuDatum']),
                ':id' => 3
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'USERS':
        empty($_POST['jmeno']) ? array_push($errors, "Jméno musí být vyplněno!") : '';
        empty($_POST['position']) ? array_push($errors, "Musí být vybrána pozice!") : '';
        (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? array_push($errors, "Email neodpovídá zadanému formátu") : '';
        empty($_POST['popis']) ? array_push($errors, "Musí být vyplněn popis osoby!") : '';
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_EMPLOYEES SET NAME=:name,EMAIL=:email,DESCRIPTION=:description, POSITION=:position WHERE ID=:id;');
            $updateQuery->execute([
                ':name' => htmlspecialchars($_POST['jmeno']),
                ':email' => htmlspecialchars($_POST['email']),
                ':position' => htmlspecialchars($_POST['position']),
                ':description' => htmlspecialchars($_POST['popis']),
                ':position' => htmlspecialchars($_POST['position']),
                ':id' => htmlspecialchars($_POST['ID1'])
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'ZVONENI':
        empty($_POST['hodina']) ? array_push($errors, "Musíte zadat název hodiny!") : '';
        empty(strtotime($_POST['odHodina'])) ? array_push($errors, "Musíte zadat začátek hodiny!") : '';
        empty(strtotime($_POST['doHodina'])) ? array_push($errors, "Musíte zadat konec hodiny!") : '';
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_RINGING SET HOUR=:hodina,START=:od,END=:do WHERE ID=:id;');
            $updateQuery->execute([
                ':hodina' => htmlspecialchars($_POST['hodina']),
                ':od' => htmlspecialchars($_POST['odHodina']),
                ':do' => htmlspecialchars($_POST['doHodina']),
                ':id' => htmlspecialchars($_POST['ID2'])
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'UDALOSTI':
        empty($_POST['event']) ? array_push($errors, "Musí být vybrán druh akce!") : '';
        empty(strtotime($_POST['odTyp'])) ? array_push($errors, "Musíte vybrat začátek akce!") : '';
        if ($_POST['event'] == 2) {
            empty($_POST['typ']) ? array_push($errors, "Musí být vyplněn název akce!") : '';
            empty(strtotime($_POST['doTyp'])) ? array_push($errors, "Musíte vybrat konec akce!") : '';
            if (empty($errors)) {
                $saveQuery = $db->prepare('UPDATE 2020_EVENTS SET TYPE=:type,START=:od,END=:do, EVENT_ID=:event WHERE ID=:id;');
                $saveQuery->execute([
                    ':type' => htmlspecialchars($_POST['typ']),
                    ':od' => htmlspecialchars(date('Y-m-d H:i', strtotime($_POST['odTyp']))),
                    ':do' => htmlspecialchars(date('Y-m-d H:i', strtotime($_POST['doTyp']))),
                    ':event' => htmlspecialchars($_POST['event']),
                    ':id' => htmlspecialchars($_POST['ID3'])
                ]);
                $result["message"] = 'Záznam úspěšně zaktualizován';
                $result["status"] = 1;
            } else {
                $result["message"] = implode("<br>", $errors);
                $result["status"] = 0;
            }
        } else {
            if (empty($errors)) {
                $saveQuery = $db->prepare('UPDATE 2020_EVENTS SET TYPE=:type,START=:od,END=:do, EVENT_ID=:event WHERE ID=:id;');
                $saveQuery->execute([
                    ':type' => NULL,
                    ':od' => htmlspecialchars(date('Y-m-d H:i', strtotime($_POST['odTyp']))),
                    ':do' => NULL,
                    ':event' => htmlspecialchars($_POST['event']),
                    ':id' => htmlspecialchars($_POST['ID3'])
                ]);
                $result["message"] = 'Záznam úspěšně zaktualizován';
                $result["status"] = 1;
            } else {
                $result["message"] = implode("<br>", $errors);
                $result["status"] = 0;
            }
        }
        echo json_encode($result);
        break;
    case 'ROZVRH':
        empty($_POST['den']) ? array_push($errors, "Den v týdnu musí být vyplněn!") : '';
        empty($_POST['schedules']) ? array_push($errors, "Musíte vybrat ročník!") : '';
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_SCHEDULES SET DAY=:day,FIRST=:first,SECOND=:second, THIRD=:third, FOURTH=:fourth, FIFTH=:fifth, SIXTH=:sixth, SEVENTH=:seventh, EIGHTH=:eighth WHERE ID=:id;');
            $updateQuery->execute([
                ':day' => htmlspecialchars($_POST['den']),
                ':first' => htmlspecialchars($_POST['hodina1']),
                ':second' => htmlspecialchars($_POST['hodina2']),
                ':third' => htmlspecialchars($_POST['hodina3']),
                ':fourth' => htmlspecialchars($_POST['hodina4']),
                ':fifth' => htmlspecialchars($_POST['hodina5']),
                ':sixth' => htmlspecialchars($_POST['hodina6']),
                ':seventh' => htmlspecialchars($_POST['hodina7']),
                ':eighth' => htmlspecialchars($_POST['hodina8']),
                ':id' => htmlspecialchars($_POST['ID4'])
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'LISTEK':
        if (empty($errors)) {
            $updateQuery = $db->prepare('UPDATE 2020_MENU SET SOUP=:soup,MAIN_MEAL=:mainMeal, DESSERT=:dessert, DRINKS=:drinks WHERE ID=:id;');
            $updateQuery->execute([
                ':soup' => htmlspecialchars($_POST['polevka']),
                ':mainMeal' => htmlspecialchars($_POST['hlavniPokrm']),
                ':dessert' => htmlspecialchars($_POST['priloha']),
                ':drinks' => htmlspecialchars($_POST['napoje']),
                ':id' => htmlspecialchars($_POST['ID'])
            ]);
            $result["message"] = 'Záznam úspěšně zaktualizován';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
}