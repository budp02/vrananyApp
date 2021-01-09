/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptSelectAJAX.js obstarává zobrazování záznamů
 * script obstarává všechny soubory obsažené ve složce admin
 * data se odesílájí pomocí AJAX do PHP scriptu scriptSelectAJAX.php
 * */
function show(ID, type) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            $("#load-" + type).html(this.responseText);
        }
    };
    xhttp.open("POST", "../php/scriptSelectAJAX.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhttp.send("ID=" + ID + "&type=" + type);
}