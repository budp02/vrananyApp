<!--
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor logCMS.php obsahuje horní navigaci pro přihlášené uživatele do webové aplikace
-->
<div class="redakcnisystem">
    <?php
    if (!empty($_SESSION['user_id'])) {
        echo '<div style="width: 25%;text-align: left;padding: 0 5px;">';
        echo '<a href="../index.php">WEB</a>';
        echo '</div>';
        echo '<div style="width: 75%;text-align: right;padding: 0 5px;">';
        echo '<strong>' . htmlspecialchars($_SESSION['user_name']) . '</strong>' . ' - ' . '<a href="../logout.php">Odhlásit se</a>';
        echo '</div>';
    }
    ?>
</div>