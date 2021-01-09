<?php
require 'userRequired.php';
if (empty($currentUser) || ($currentUser['ADMIN'] != '1')) {
    die('Tato stránka je dostupná pouze administrátorům.');
}