/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor menu.js obstarává rozbalování hamburger menu v horní navigaci pro mobilní zařízení
 * */
$(document).ready(function () {
    $("#con").click(function () {
        var x = document.getElementById("navig");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    });
});

function myFunction(x) {
    x.classList.toggle("change");
}
