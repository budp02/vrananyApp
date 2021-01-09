<?php
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptContact.js zpracovává přihlašování do webové aplikace
 * data jsou přijata z scriptLogin.js
 * kontaktní formulář je na loginPage.php
 * */
require('../inc/db.php');
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

$action = $_POST['action'];
$result["message"] = "";
$result["status"] = "";
$errors = array();
$myfile = fopen("../log.txt", "a") or die("Soubor nelze otevřít!");
switch ($action) {
    case 'verify':
        $query = $db->prepare('SELECT * FROM 2020_USERS WHERE USERNAME=:name AND ACTIVE=1 LIMIT 1');
        $query->execute([
            ':name' => htmlspecialchars(strtolower($_POST['jmeno']))
        ]);
        if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($_POST['heslo'], $result['PASSWORD'])) {
                if ($result['NEW_PASS'] == 0) {
                    $result["message"] = 'Před prvním přihlášením je nutné si změnit heslo!';
                    $result["status"] = 2;
                } else {
                    $_SESSION['user_id'] = $result['ID'];
                    $_SESSION['user_name'] = $result['USERNAME'];
                    $result["message"] = 'Přihlášen!';
                    $result["status"] = 1;
                    $txt = "[" . date("Y-m-d") . " " . date("h:i:sa") . "]\t" . strtolower($_POST['jmeno']) . "\tpřihlášení\n";
                    fwrite($myfile, $txt);
                }
            } else { //špatně je jen heslo
                $result["message"] = 'Uživatelské jméno a heslo se neshoduje!';
                $result["status"] = 0;
                $txt = "[" . date("Y-m-d") . " " . date("h:i:sa") . "]\t" . strtolower($_POST['jmeno']) . "\tšpatné heslo\n";
                fwrite($myfile, $txt);
            }
        } else { //špatně je i jméno
            $result["message"] = 'Uživatelské jméno a heslo se neshoduje!';
            $result["status"] = 0;
            $txt = "[" . date("Y-m-d") . " " . date("h:i:sa") . "]\t" . strtolower($_POST['jmeno']) . "\tšpatné přihlašovací jméno\n";
            fwrite($myfile, $txt);
        }
        echo json_encode($result);
        break;
    case 'changePass':
        $query = $db->prepare('SELECT * FROM 2020_USERS WHERE USERNAME=:name AND ACTIVE=1 LIMIT 1');
        $query->execute([
            ':name' => htmlspecialchars(strtolower($_POST['jmeno']))
        ]);
        if ($user = $query->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($_POST['heslo'], $user['PASSWORD'])) {
                empty($_POST['hesloNew1']) ? array_push($errors, "Heslo ke změně musí být vyplněno!") : '';
                $uppercase = preg_match('@[A-Z]@', $_POST['hesloNew1']);
                $lowercase = preg_match('@[a-z]@', $_POST['hesloNew1']);
                $number = preg_match('@[0-9]@', $_POST['hesloNew1']);
                (!$uppercase || !$lowercase || !$number || strlen($_POST['hesloNew1']) < 8) ? array_push($errors, "Heslo nesplňuje požadavky (alespoň jedna číslice, jedno velké písmeno a alespoň 8 znaků!") : '';
                ($_POST['hesloNew1'] != $_POST['hesloNew2']) ? array_push($errors, "Hesla nejsou shodná!") : '';
                if (empty($errors)) {
                    $updateQuery = $db->prepare('UPDATE 2020_USERS SET USERNAME=:username, PASSWORD=:password, NEW_PASS=:newPass WHERE ID=:id;');
                    $updateQuery->execute([
                        ':username' => htmlspecialchars(strtolower($_POST['jmeno'])),
                        ':password' => password_hash($_POST['hesloNew1'], PASSWORD_DEFAULT),
                        ':newPass' => 1,
                        ':id' => htmlspecialchars($_POST['ID'])
                    ]);
                    $_SESSION['user_id'] = $user['ID'];
                    $_SESSION['user_name'] = $user['USERNAME'];
                    $result["status"] = 1;
                    $txt = "[" . date("Y-m-d") . " " . date("h:i:sa") . "]\t" . strtolower($_POST['jmeno']) . "\theslo změněno\n";
                    fwrite($myfile, $txt);
                } else {
                    $result["message"] = implode("<br>", $errors);
                    $result["status"] = 0;
                }
            }
        }
        echo json_encode($result);
        break;
    case 'forgotPass':
        (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? array_push($errors, "Email neodpovídá zadanému formátu") : '';
        if (empty($errors)) {
            $query = $db->prepare('SELECT * FROM 2020_USERS WHERE MAIL=:mail AND ACTIVE=1 LIMIT 1');
            $query->execute([
                ':mail' => $_POST['email']
            ]);
            if ($user = $query->fetch(PDO::FETCH_ASSOC)) {
                function generateRandomString($length = 10)
                {
                    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
                }

                $password = generateRandomString();
                $body = "Dobrý den," . '<br><br>' . "pro první přihlášení do aplikace použijte tyto přihlašovací údaje:" . '<br>' . '<strong>' . "Uživatelské jméno: " . '</strong>' . $user['USERNAME'] . '<br>' . '<strong>' . "Heslo: " . '</strong>' . $password . '<br><br>' . "Po prvním přihlání budete vyzvání ke změně hesla." . '<br>' . "ZŠ Vraňany";
                CZMail($_POST['email'], "Přihlašovací údaje do aplikace", $body);
                $updateQuery = $db->prepare('UPDATE 2020_USERS SET USERNAME=:username, PASSWORD =:password, NEW_PASS=:newPass WHERE ID=:id;');
                $updateQuery->execute([
                    ':username' => htmlspecialchars($user['USERNAME']),
                    ':password' => password_hash($password, PASSWORD_DEFAULT),
                    ':newPass' => 0,
                    ':id' => htmlspecialchars($user['ID'])
                ]);
            }
            $result["message"] = 'Pokud existuje takový účet přidružené této emailové adrese, zkontrolujte emailovou schránku, kde bylo zasláno heslo. ';
            $result["status"] = 1;
            $txt = "[" . date("Y-m-d") . " " . date("h:i:sa") . "]\t" . strtolower($_POST['email']) . "\tzaslány přihlašovací údaje\n";
            fwrite($myfile, $txt);
        } else {
            $result["message"] = implode("<br>", $errors);
            $result["status"] = 0;
        }
        echo json_encode($result);
        break;
}
fclose($myfile);
?>