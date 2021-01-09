<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptContact.js zpracovává kontaktní formulář
 * data jsou přijata z scriptContact.js
 * kontaktní formulář je na contact.php
 * */
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

$name = $_POST['firstName'];
$who = $_POST['email'];
$msg = $_POST['message'];
$where_mail = "zs.vranany@seznam.cz";
empty($_POST['firstName']) ? array_push($errors, 'Prosím vložte své jméno.') : '';
empty($_POST['email']) ? array_push($errors, 'Prosím zadejte svůj email.') : '';
empty($_POST['message']) ? array_push($errors, 'Prosím vložte svou zprávu.') : '';
(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? array_push($errors, "Email neodpovídá zadanému formátu") : '';
if (empty($errors)) {
    $body = "Jméno: " . $name . "<br>E-mail: " . $who . "<br>" . $msg;
    CZMail($where_mail, "Zpráva z webových stránek", $body, "$name <$who>");
    $response["message"] = 'Zpráva byla odeslána.';
    $response['status'] = 1;
} else {
    $response['status'] = 0;
    $response["message"] = implode("<br>", $errors);
}
echo json_encode($response);
