<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor logout.php je určen pro odhlášení z webové aplikace
 * */
$myfile = fopen("log.txt", "a") or die("Soubor nelze otevřít!");
require_once 'inc/userRequired.php';
if (!empty($_SESSION['user_id'])) {
    $txt = "[" . date("Y-m-d") . " " . date("h:i:sa") . "]\t" . strtolower($_SESSION['user_name']) . "\todhlášení\n";
    fwrite($myfile, $txt);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
}
fclose($myfile);
header('Location: index.php');