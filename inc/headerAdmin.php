<?php
session_start();
require 'userRequired.php';
?>
<!--
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor headerAdmin.php obsahuje hlavní navigaci pro přihlášené uživatele do webové aplikace
-->
<div class="infoSchool">
    <div onclick="location.href='index.php';" class="logo"></div>
    <div class="address"><span>Vraňany 67, 277 07 Vraňany</span></div>
</div>
<div id="respons">
    <div id="con" class="containerHeader" onclick="myFunction(this)">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>
</div>
<nav id="navig" class="topnav">
    <a style="visibility:<? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['UVOD'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="indexAdmin.php">úvod</a>
    <a style="visibility:<? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['SKOLNI_ROK'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="schoolYearAdmin.php">aktuální školní rok</a>
    <a style="visibility:<? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['FOTKY'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="photogaleryAdmin.php">fotky akcí školy</a>
    <a style="visibility:<? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['TRIDY'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="schoolClassesAdmin.php">Třídy</a>
    <a style="visibility:<? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['DOKUMENTY'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="documentsAdmin.php">Dokumenty</a>
    <a style="visibility:<? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['JIDELNA'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="schoolCanteenAdmin.php">školní<br>jídelna</a>
    <a style="visibility: <? echo(((empty($currentUser)) || (($currentUser['ADMIN'] == '0'))) ? 'hidden' : 'visible'); ?>"
       href="users.php">Uživatelé</a>
    </div>
</nav>
<div class="photoSchool">
    <img alt="fotoŠkoly" src="../img/slider02.jpg">
</div>
