<!--
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor footer.php slouží k zobrazení odznaků školy a spodního navigačního menu
-->
<h3>Naše škola je zapojena do těchto projektů</h3>
<br>
<div class="projects">
    <div><img alt="jaTyMleko odznak" src="img/projekt1.jpg"></div>
    <div><img alt="jaTyOvoce odznak" src="img/projekt2.jpg"></div>
    <div><a rel="noopener" href="https://www.vzp.cz/" target="_blank"><img alt="vzp logo" src="img/vzp.jpg"></a></div>
    <div><a rel="noopener" href="http://www.proskoly.cz/?f=f_218695&le=e_7" target="_blank"><img
                    alt="Aktivní škola logo" src="img/proSkoly.jpg"/></a></div>
    <div><a rel="noopener"
            href="https://www.idatabaze.cz/firma/128578-zakladni-skola-vranany-okres-melnik-prispevkova-organizace/"
            target="_blank"><img alt="ověřená firma logo" src="img/idatabaze.jpg?v=2"/></a>
    </div>
</div>
<div class="menuCopy">
    <div class="menu">
        <div><a href="uvod">úvod</a></div>
        <div><a href="aktualni-skolni-rok">aktuální školní rok</a></div>
        <div><a href="fotky-akci-skoly">fotky akcí školy</a></div>
        <div><a href="dokumenty">dokumenty</a></div>
        <div>
            <?php
            if (!empty($_SESSION['user_id'])) {
                echo '<a href="admin/">Administrace</a>';
            } else {
                echo '<a href="loginPage.php">Přihlásit se</a>';
            } ?>
        </div>
    </div>
</div>
<div class="copyright">
    &copy; 2015 - <? echo date("Y"); ?> ZŠ Vraňany WEB and CMS created by Petr Budinský
</div>