<?php
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor db.php slouží pro připojení k databázi MySQL
 * */
$servername = "****";
$username = "****";
$password = "****";
$dbname = "****";
$db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>