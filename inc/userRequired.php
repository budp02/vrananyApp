<?php
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor userRequired.php obsahuje ověření přihlášeného uživatele
 * */
require_once 'db.php';
if (!empty($_SESSION['user_id'])) {
    $userQuery = $db->prepare('SELECT * FROM 2020_USERS WHERE ID=:id AND ACTIVE=1 LIMIT 1;');
    $userQuery->execute([
        ':id' => $_SESSION['user_id']
    ]);
    $currentUser = $userQuery->fetch(PDO::FETCH_ASSOC);
    if ($userQuery->rowCount() != 1) {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        header('Location: ../logout.php');
        exit();
    }
}
else{
    /*uživatel není přihlášen*/
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../index.php');
    exit();
}
