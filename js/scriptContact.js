/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor scriptContact.js obstarává odesílání kontaktní formulář
 * kontaktní formulář je na contact.php
 * data se odesílájí pomocí AJAX do PHP scriptu scriptContact.php
 * */
$(document).ready(function () {
    $('#submitEmail').click(function (e) {
        var form = $("#formMail");
        var params = form.serializeArray(); /*jen vstupy*/
        var formData = new FormData();
        $(params).each(function (index, element) {
            formData.append(element.name, element.value);
        });
        var btn = $(this);
        btn.val("Nahrávám...");
        btn.prop("disabled", true);
        $.ajax({
            url: '../php/scriptContact.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                btn.prop("disabled", false);
                btn.val("Odeslat zprávu");
                if (response.status === 1) {
                    $('#formMail')[0].reset();
                    $('#message-MAIL').html('<p class="good">' + response.message + '</p>');
                } else {
                    $('#message-MAIL').html('<p class="bad">' + response.message + '</p>');
                }
            },
        });
    });
});