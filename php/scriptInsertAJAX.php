<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptInsertAJAX.php zpracovává vkládání záznamů
 * data jsou přijata z scriptInsertAJAX.js
 * je zde použita funkce switch, kde parametrem je uvedena hodnota z každého formuláře, jehož jméno je "type"
 * jsou zde zpracovávány všechny soubory ze složky admin
 * */
require('../inc/db.php');
require '../inc/userRequired.php';
$errors = array();
function CZMail($to, $subjc, $text, $headers = " ")
{
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-Type: text/html; charset=\"utf-8\"\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    $headers .= "X-mailer: PHP\n";
    $headers .= "X-Priority: 1\n";
    $headers .= "From: ZS Vranany <info@vranany.cz>\n";
    $headers .= "Reply-To: ZS Vranany <info@vranany.cz>\n";
    $headers .= "Return-Path: ZS Vranany <info@vranany.cz>\n";
    Mail($to, $subjc, $text, $headers);
}

function removeDir($target)
{
    $directory = new RecursiveDirectoryIterator($target, FilesystemIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if (is_dir($file)) {
            rmdir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($target);
}

$type = $_POST['type'];
switch ($type) {
    case 'NOTIFIKACE':
        empty($_POST['header']) ? array_push($errors, "Prosím zadejte nadpis příspěvku.") : '';
        if (empty($errors)) {
            $uzivatel = htmlspecialchars($_SESSION['user_name']);
            $jmenoprijmeni = explode(".", $uzivatel);
            $fullname = ucfirst($jmenoprijmeni[0]) . " " . ucfirst($jmenoprijmeni[1]);
            $query = $db->prepare('SELECT CATEGORY FROM 2020_CATEGORIES WHERE CATEGORY_NAME=:name');
            $query->execute([
                ':name' => $_POST['category']
            ]);
            $classID = $query->fetchColumn();
            $saveQuery = $db->prepare('INSERT INTO 2020_NOTIFICATION (TITLE, DESCRIPTION, FOUNDER, CATEGORY, BORDER_COLOR) VALUES (:nadpis, :popis, :zakladatel, :category, :border);');
            $saveQuery->execute([
                ':nadpis' => $_POST['header'],
                ':popis' => $_POST['text'],
                ':zakladatel' => $fullname,
                ':category' => $classID,
                ':border' => $_POST['border']
            ]);
            $response['status'] = 1;
            $response['message'] = 'Příspěvek úspěšně vložen.';
        } else {
            $response['status'] = 0;
            $response["message"] = implode("<br>", $errors);
        }
        echo json_encode($response);
        break;
    case 'PRAVA':
        $query = $db->prepare('SELECT COUNT(*) FROM 2020_USERS where USERNAME=:username');
        $query->execute([
            ':username' => htmlspecialchars(strtolower($_POST['jmeno']))
        ]);
        $num_rowsName = $query->fetchColumn();
        $query = $db->prepare('SELECT COUNT(*) FROM 2020_USERS where MAIL=:mail');
        $query->execute([
            ':mail' => htmlspecialchars(strtolower($_POST['email']))
        ]);
        $num_rowsMail = $query->fetchColumn();
        if (!empty($_POST['jmeno'])) {
            ($num_rowsName != 0) ? array_push($errors, "Jméno uživatele již existuje!") : '';
            (!preg_match('/^[a-z]{1,}[.][a-z]{1,}$/', $_POST['jmeno'])) ? array_push($errors, "Jméno uživatele neodpovídá vzoru jmeno.prijmeni!") : '';
        } else {
            array_push($errors, "Jméno uživatele musí být vyplněno!");
        }
        if (!empty($_POST['email'])) {
            ($num_rowsMail != 0) ? array_push($errors, "Uživatel se zadaným mailem již existuje!") : '';
            (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? array_push($errors, "Email neodpovídá zadanému formátu") : '';
        } else {
            array_push($errors, "Email uživatele musí být vyplněn!");
        }
        if (empty($errors)) {
            function generateRandomString($length = 10)
            {
                return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
            }

            $password = generateRandomString();
            $body = "Dobrý den," . '<br><br>' . "pro první přihlášení do aplikace použijte tyto přihlašovací údaje:" . '<br>' . '<strong>' . "Uživatelské jméno: " . '</strong>' . $_POST['jmeno'] . '<br>' . '<strong>' . "Heslo: " . '</strong>' . $password . '<br><br>' . "Po prvním přihlání budete vyzvání ke změně hesla." . '<br>' . "ZŠ Vraňany";
            CZMail($_POST['email'], "Přihlašovací údaje do aplikace", $body);

            $saveQuery = $db->prepare('INSERT INTO 2020_USERS (USERNAME, PASSWORD, MAIL, ADMIN, UVOD, SKOLNI_ROK, FOTKY, TRIDY, DOKUMENTY, JIDELNA, active) VALUES (:username, :password, :email, :admin, :uvod, :skolni_rok, :fotky, :tridy, :dokumenty, :jidelna, :active);');
            $saveQuery->execute([
                ':username' => htmlspecialchars(strtolower($_POST['jmeno'])),
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':email' => htmlspecialchars($_POST['email']),
                ':active' => htmlspecialchars($_POST['active']),
                ':admin' => htmlspecialchars($_POST['admin']),
                ':uvod' => htmlspecialchars($_POST['uvod']),
                ':skolni_rok' => htmlspecialchars($_POST['skolni_rok']),
                ':fotky' => htmlspecialchars($_POST['fotogalerie']),
                ':tridy' => htmlspecialchars($_POST['tridy']),
                ':dokumenty' => htmlspecialchars($_POST['dokumenty']),
                ':jidelna' => htmlspecialchars($_POST['jidelna'])
            ]);
            $result["message"] = 'Záznam úspěšně přidán';
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
            $saveQuery = $db->prepare('INSERT INTO 2020_EMPLOYEES (NAME, POSITION, EMAIL, DESCRIPTION) VALUES (:name, :position, :email, :description);');
            $saveQuery->execute([
                ':name' => htmlspecialchars($_POST['jmeno']),
                ':position' => htmlspecialchars($_POST['position']),
                ':email' => htmlspecialchars($_POST['email']),
                ':description' => htmlspecialchars($_POST['popis'])
            ]);
            $result["message"] = 'Záznam úspěšně přidán';
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
            $saveQuery = $db->prepare('INSERT INTO 2020_RINGING (HOUR, START, END) VALUES (:hodina, :od, :do);');
            $saveQuery->execute([
                ':hodina' => htmlspecialchars($_POST['hodina']),
                ':od' => htmlspecialchars($_POST['odHodina']) . ':00',
                ':do' => htmlspecialchars($_POST['doHodina']) . ':00'
            ]);
            $result["message"] = 'Záznam úspěšně přidán';
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
                $saveQuery = $db->prepare('INSERT INTO 2020_EVENTS (TYPE, START, END, EVENT_ID) VALUES (:typ, :od, :do,:event);');
                $saveQuery->execute([
                    ':typ' => htmlspecialchars($_POST['typ']),
                    ':od' => htmlspecialchars(date('Y-m-d H:i', strtotime($_POST['odTyp']))),
                    ':do' => htmlspecialchars(date('Y-m-d H:i', strtotime($_POST['doTyp']))),
                    ':event' => htmlspecialchars($_POST['event'])
                ]);
                $result["message"] = 'Záznam úspěšně přidán';
                $result["status"] = 1;
            } else {
                $result["message"] = implode("<br>", $errors);
                $result["status"] = 0;
            }
        } else {
            if (empty($errors)) {
                $saveQuery = $db->prepare('INSERT INTO 2020_EVENTS (TYPE, START, END, EVENT_ID) VALUES (:typ, :od, :do,:event);');
                $saveQuery->execute([
                    ':typ' => NULL,
                    ':od' => htmlspecialchars(date('Y-m-d H:i', strtotime($_POST['odTyp']))),
                    ':do' => NULL,
                    ':event' => htmlspecialchars($_POST['event'])
                ]);
                $result["message"] = 'Záznam úspěšně přidán';
                $result["status"] = 1;
            } else {
                $result["message"] = implode("<br>", $errors);
                $result["status"] = 0;
            }
        }
        echo json_encode($result);
        break;
    case 'KATEGORIEFOTO':
        empty($_POST['nazev']) ? array_push($errors, "Musí zadat název nové fotogalery!") : '';
        if (empty($errors)) {
            $saveQuery = $db->prepare('INSERT INTO 2020_FOTOGALERY_CATEGORY (NAME) VALUES (:nazev);');
            $saveQuery->execute([
                ':nazev' => htmlspecialchars($_POST['nazev'])
            ]);
            $result["message"] = 'Kategorie úspěšně přidána';
            $result["status"] = 1;
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
    case 'PHOTOS':
        empty($_FILES['filesPHOTOS']['name']) ? array_push($errors, 'Prosím vložte fotografii') : '';
        empty($_POST['category']) ? array_push($errors, 'Prosím vyberte kategorii.') : '';
        $countfiles = count($_FILES['filesPHOTOS']['name']);
        $old_umask = umask(0);
        $upload_locationMAX = '../fotogalery/maxi/' . $_POST['category'] . '/';
        if (!file_exists($upload_locationMAX)) {
            mkdir($upload_locationMAX, 0755);
            umask($old_umask);
        }
        $upload_locationMIN = '../fotogalery/mini/' . $_POST['category'] . '/';
        if (!file_exists($upload_locationMIN)) {
            mkdir($upload_locationMIN, 0755);
            umask($old_umask);
        }
        $upload_locationOriginal = '../fotogalery/original/' . $_POST['category'] . '/';
        if (!file_exists($upload_locationOriginal)) {
            mkdir($upload_locationOriginal, 0755);
            umask($old_umask);
        }


//kontrola koncovky u všech souborů
        for ($index = 0; $index < $countfiles; $index++) {
            $filename = $_FILES['filesPHOTOS']['name'][$index];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $valid_ext = array("jpg", "JPG");
            if (!(in_array($ext, $valid_ext))) {
                array_push($errors, "Jeden ze souborů není ve formátu JPG. Převeď soubory a nahraj je prosím znovu");
            }
        }
        if (empty($errors)) {
            for ($index = 0; $index < $countfiles; $index++) {
                $random = rand(0, 10000);
                $filename = $_FILES['filesPHOTOS']['name'][$index];/*name*/
                $fileTMP = $_FILES['filesPHOTOS']['tmp_name'][$index];
                $realname = $random . $filename;
                $pathMax = $upload_locationMAX . $realname;
                $pathMin = $upload_locationMIN . $realname;
                $pathOriginal = $upload_locationOriginal . $realname;
                $src = imagecreatefromjpeg($fileTMP);
                list($width_min, $height_min) = getimagesize($fileTMP);/**/
                if ($width_min > $height_min) {
                    $newwidth_minMAX = 800;
                    $newheight_minMAX = ($height_min / $width_min) * $newwidth_minMAX;
                    $tmp_minMAX = imagecreatetruecolor($newwidth_minMAX, $newheight_minMAX);
                    imagecopyresampled($tmp_minMAX, $src, 0, 0, 0, 0, $newwidth_minMAX, $newheight_minMAX, $width_min, $height_min);
                    $newwidth_minMIN = 150;
                    $newheight_minMIN = ($height_min / $width_min) * $newwidth_minMIN;
                    $tmp_minMIN = imagecreatetruecolor($newwidth_minMIN, $newheight_minMIN);
                    imagecopyresampled($tmp_minMIN, $src, 0, 0, 0, 0, $newwidth_minMIN, $newheight_minMIN, $width_min, $height_min);
                    imagejpeg($tmp_minMAX, $pathMax, 100);
                    imagejpeg($tmp_minMIN, $pathMin, 100);
                    move_uploaded_file($fileTMP, $pathOriginal);
                    $saveQuery = $db->prepare('INSERT INTO 2020_FOTOGALERY (ROUTE, POSITION, CATEGORY_ID) VALUES (:cesta, :poloha, :kategorie_ID);');
                    $saveQuery->execute([
                        ':cesta' => htmlspecialchars($realname),
                        ':poloha' => 1,
                        ':kategorie_ID' => htmlspecialchars($_POST['category'])
                    ]);

                } else {
                    $newwidth_minMAX = 577;
                    $newheight_minMAX = ($height_min / $width_min) * $newwidth_minMAX;
                    $tmp_minMAX = imagecreatetruecolor($newwidth_minMAX, $newheight_minMAX);
                    imagecopyresampled($tmp_minMAX, $src, 0, 0, 0, 0, $newwidth_minMAX, $newheight_minMAX, $width_min, $height_min);
                    $newwidth_minMIN = 100;
                    $newheight_minMIN = ($height_min / $width_min) * $newwidth_minMIN;
                    $tmp_minMIN = imagecreatetruecolor($newwidth_minMIN, $newheight_minMIN);
                    imagecopyresampled($tmp_minMIN, $src, 0, 0, 0, 0, $newwidth_minMIN, $newheight_minMIN, $width_min, $height_min);
                    imagejpeg($tmp_minMAX, $pathMax, 100);
                    imagejpeg($tmp_minMIN, $pathMin, 100);
                    move_uploaded_file($fileTMP, $pathOriginal);
                    $saveQuery = $db->prepare('INSERT INTO 2020_FOTOGALERY (ROUTE, POSITION, CATEGORY_ID) VALUES (:cesta, :poloha, :kategorie_ID);');
                    $saveQuery->execute([
                        ':cesta' => htmlspecialchars($realname),
                        ':poloha' => 0,
                        ':kategorie_ID' => htmlspecialchars($_POST['category'])
                    ]);
                }
            }
            $response["message"] = 'Fotografie úspěšně nahrány.';
            $response['status'] = 1;
        } else {
            $response['status'] = 0;
            $response["message"] = implode("<br>", $errors);
        }
        echo json_encode($response);
        break;
    case 'PHOTOGALERYARCHIV':
        $oldPATH = '../fotogalery/original/' . $_POST['photogaleryArchiv'] . '/';
        $newPATH = '../fotogalery/archiv/' . $_POST['photogaleryArchiv'] . '/';
        $minPATH = '../fotogalery/mini/' . $_POST['photogaleryArchiv'] . '/';
        $maxPATH = '../fotogalery/maxi/' . $_POST['photogaleryArchiv'] . '/';
        rename($oldPATH, $newPATH);
        removeDir($minPATH);
        removeDir($maxPATH);
        $deleteQuery = $db->prepare('DELETE FROM 2020_FOTOGALERY WHERE CATEGORY_ID=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['photogaleryArchiv'])
        ]);
        $deleteQuery = $db->prepare('DELETE FROM 2020_FOTOGALERY_CATEGORY WHERE CATEGORY_ID=:id;');
        $deleteQuery->execute([
            ':id' => htmlspecialchars($_POST['photogaleryArchiv'])
        ]);
        $response["message"] = 'Foto kategorie úspěšně archivována';
        $response['status'] = 1;
        echo json_encode($response);
        break;
}