<?
session_start();
/*
 * Copyright (C) 2015 - 2020 Petr Budinský
 * Soubor schoolClassesAdmin.php je určený pro administraci webové prezentace schoolClasses.php
 * */
setlocale(LC_TIME, 'cs_CZ.UTF-8');
require '../inc/db.php';
require '../inc/userRequired.php';
if ((empty($currentUser)) || (($currentUser['ADMIN'] == '0') && ($currentUser['SKOLNI_ROK'] == '0'))) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    header('Location: ../logout.php');
    exit();
}
$positions = $db->query('SELECT * FROM 2020_POSITIONS ORDER BY POSITION_NAME;')->fetchAll(PDO::FETCH_ASSOC);
$events = $db->query('SELECT * FROM 2020_EVENTS_TYPE ORDER BY EVENT_NAME;')->fetchAll(PDO::FETCH_ASSOC);
$pageTitle = "Školní rok - ";
?>
<!DOCTYPE html>
<html lang="cs">
<?php include "../inc/headAdmin.php"; ?>
<body onload="show('','ZVONENI'),show('','SKOLNIROK')"><!--scriptSelectAJAX.js-->
<?php include '../inc/logCMS.php' ?>
<header class="admin">
    <?php include "../inc/headerAdmin.php" ?>
</header>
<main class="skolni_rok adminPart">
    <h3>Editace školního roku</h3>
    Školní rok <span id="load-SKOLNIROK"></span><br><br>
    <form id="formSKOLNIROK" method="post" enctype="multipart/form-data">
        <input type="hidden" value="SKOLNIROK" name="type">
        <table>
            <tr>
                <th>Školní rok</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control" id="skolniRok" name="skolniRok" aria-label="Školní rok">
                </td>
            </tr>
        </table>
        <input type="button" id="updateSKOLNIROK" class="btn btn-warning" value='Aktualizovat'>
        <!--scriptUpdateAJAX.js-->
    </form>
    <span id="message-SKOLNIROK"></span>
    <h3>Editace zaměstnanců</h3>
    <form id="formUSERS" method="post" enctype="multipart/form-data">
        <div style="overflow-x: auto">
            <table>
                <tr class="table table-striped notschedule">
                    <th>Pozice</th>
                    <th>Jméno</th>
                    <th>Email</th>
                    <th>Popis</th>
                </tr>
                <tr>
                    <input type="hidden" id="ID1" name="ID1" aria-label="ID zaměstnance">
                    <input type="hidden" value="USERS" name="type">
                    <td>
                        <select aria-label="Pozice" class="form-control custom-select" required id="position"
                                name="position"
                                onchange="show(this.value,'USERS')">
                            <option value="">--Vyberte pozici--</option>
                            <?php
                            if (!empty($positions)) {
                                foreach ($positions as $position) {
                                    echo '<option value="' . $position['POSITION'] . '">' . htmlspecialchars($position['POSITION_NAME']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" id="jmeno" name="jmeno" aria-label="Jméno zaměstnance">
                    </td>
                    <td><input type="text" class="form-control" id="email" name="email" aria-label="Email Zaměstnance">
                    </td>
                    <td><input type="text" class="form-control" id="popis" name="popis"
                               aria-label="Popis pozice zaměstnance"></td>
                </tr>
            </table>
        </div>
        <input type="button" id="submitUSERS" class="btn btn-primary" value='Vložit'><!--scriptInsertAJAX.js-->
        <input type="button" id="updateUSERS" class="btn btn-warning" value='Aktualizovat'><!--scriptUpdateAJAX.js-->
        <input type="button" onclick="deleteData('','USERS')" id="deleteUSERS" class="btn btn-danger" value='Smazat'>
        <!--scriptDeleteAJAX.js-->
        <input type="button" class="btn btn-light"
               onclick="$('#formUSERS')[0].reset();$('#submitUSERS').show();$('#updateUSERS').hide();$('#deleteUSERS').hide();"
               value='Zrušit'>
    </form>
    <span id="message-USERS"></span>
    <h4>Zaměstnanci školy</h4>
    <div style="overflow-x: auto">
        <table class="table table-striped notschedule">
            <thead>
            <tr>
                <th>Jméno</th>
                <th>Email</th>
                <th>Popis</th>
                <th>Upravit</th>
            </tr>
            </thead>
            <tbody id="load-USERS"><!--scriptSelectAJAX.js-->
            </tbody>
        </table>
    </div>
    <br>
    <h3>Editace rozpisu vyučujících hodin</h3>
    <form id="formZVONENI" method="post" enctype="multipart/form-data">
        <div style="overflow-x: auto">
            <table>
                <tr class="table table-striped notschedule">
                    <th>Hodina</th>
                    <th>Od</th>
                    <th>Do</th>
                </tr>
                <tr>
                    <input type="hidden" id="ID2" name="ID2" aria-label="ID hodiny">
                    <input type="hidden" value="ZVONENI" name="type">
                    <td><input type="text" class="form-control" id="hodina" name="hodina"
                               aria-label="Název vyučovací hodiny"></td>
                    <td><input type="time" class="form-control" id="odHodina" name="odHodina"
                               aria-label="Začátek hodiny"></td>
                    <td><input type="time" class="form-control" id="doHodina" name="doHodina" aria-label="Konec hodiny">
                    </td>
                </tr>
            </table>
        </div>
        <input type="button" id="submitZVONENI" class="btn btn-primary" value='Vložit'><!--scriptInsertAJAX.js-->
        <input type="button" id="updateZVONENI" class="btn btn-warning" value='Aktualizovat'><!--scriptUpdateAJAX.js-->
        <input type="button" onclick="deleteData('','ZVONENI')" id="deleteZVONENI" class="btn btn-danger"
               value='Smazat'><!--scriptDeleteAJAX.js-->
        <input type="button" class="btn btn-light"
               onclick="$('#formZVONENI')[0].reset();$('#submitZVONENI').show();$('#updateZVONENI').hide();$('#deleteZVONENI').hide();"
               value='Zrušit'>
    </form>
    <span id="message-ZVONENI"></span>
    <h4>
        Rozpis vyučovacích hodin
    </h4>
    <div style="overflow-x: auto">
        <table class="table table-striped notschedule">
            <thead>
            <tr>
                <th>Hodina</th>
                <th>Od</th>
                <th>Do</th>
                <th>Upravit</th>
            </tr>
            </thead>
            <tbody id="load-ZVONENI"><!--scriptSelectAJAX.js-->
            </tbody>
        </table>
    </div>
    <br>
    <h3>Editace událostí školy</h3>
    <form id="formUDALOSTI" method="post" enctype="multipart/form-data">
        <div style="overflow-x: auto">
            <table>
                <tr class="table table-striped notschedule">
                    <th>Druh</th>
                    <th>Typ</th>
                    <th>Od</th>
                    <th>Do</th>
                </tr>
                <tr>
                    <input type="hidden" id="ID3" name="ID3" aria-label="ID události">
                    <input type="hidden" value="UDALOSTI" name="type">
                    <td>
                        <select aria-label="event" class="form-control custom-select" required id="event" name="event"
                                onchange="show(this.value,'UDALOSTI')">
                            <option value="">--Vyberte událost--</option>
                            <?php
                            if (!empty($events)) {
                                foreach ($events as $event) {
                                    echo '<option value="' . $event['EVENT_ID'] . '">' . htmlspecialchars($event['EVENT_NAME']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" id="typ" name="typ" aria-label="Název události"></td>
                    <td><input type="datetime-local" class="form-control" id="odTyp" name="odTyp"
                               aria-label="Začátek události"></td>
                    <td><input type="datetime-local" class="form-control" id="doTyp" name="doTyp"
                               aria-label="Konec události"></td>
                </tr>
            </table>
        </div>
        <input type="button" id="submitUDALOSTI" class="btn btn-primary" value='Vložit'><!--scriptInsertAJAX.js-->
        <input type="button" id="updateUDALOSTI" class="btn btn-warning" value='Aktualizovat'><!--scriptUpdateAJAX.js-->
        <input type="button" onclick="deleteData('','UDALOSTI')" id="deleteUDALOSTI" class="btn btn-danger"
               value='Smazat'><!--scriptDeleteAJAX.js-->
        <input type="button" class="btn btn-light"
               onclick="$('#formUDALOSTI')[0].reset();$('#submitUDALOSTI').show();$('#updateUDALOSTI').hide();$('#deleteUDALOSTI').hide();"
               value='Zrušit'>
    </form>
    <span id="message-UDALOSTI"></span>
    <h4>
        Události školy
    </h4>
    <div style="overflow-x: auto">
        <table class="table table-striped notschedule">
            <thead>
            <tr>
                <th>Typ</th>
                <th>Od</th>
                <th>Do</th>
                <th>Upravit</th>
            </tr>
            </thead>
            <tbody id="load-UDALOSTI"><!--scriptSelectAJAX.js-->
            </tbody>
        </table>
    </div>
    <br>
    <h3>Editace rozvrhů hodin</h3>
    <form id="formROZVRH" method="post" enctype="multipart/form-data">
        <div style="overflow-x: auto">
            <table>
                <tr class="table table-striped notschedule">
                    <th>Ročník</th>
                    <th>Den</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                </tr>
                <tr>
                    <input type="hidden" id="ID4" name="ID4" aria-label="ID vyučovací hodiny">
                    <input type="hidden" value="ROZVRH" name="type">
                    <td>
                        <select class="form-control custom-select" aria-label="schedules" required id="schedules"
                                name="schedules"
                                onchange="show(this.value,'ROZVRH')">
                            <option value="">--Vyberte ročník--</option>
                            <option value="1">První třída</option>
                            <option value="2">Druhá třída</option>
                            <option value="3">Třetí třída</option>
                            <option value="4">Čtvrtá třída</option>
                            <option value="5">Pátá třída</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" id="den" name="den" aria-label="Den v týdnu"></td>
                    <td><input type="text" class="form-control" id="hodina1" name="hodina1" aria-label="První hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina2" name="hodina2" aria-label="Druhá hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina3" name="hodina3" aria-label="Třetí hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina4" name="hodina4" aria-label="Čtvrtá hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina5" name="hodina5" aria-label="Pátá hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina6" name="hodina6" aria-label="Šestá hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina7" name="hodina7" aria-label="Sedmá hodina">
                    </td>
                    <td><input type="text" class="form-control" id="hodina8" name="hodina8" aria-label="Osmá hodina">
                    </td>
                </tr>
            </table>
        </div>
        <input type="button" id="updateROZVRH" class="btn btn-warning" value='Aktualizovat'><!--scriptUpdateAJAX.js-->
        <input type="button" class="btn btn-light" onclick="$('#formROZVRH')[0].reset();$('#updateROZVRH').hide();"
               value='Zrušit'>
    </form>
    <span id="message-ROZVRH"></span>
    <h4>
        Rozvrhy hodin
    </h4>
    <div style="overflow-x: auto">
        <table class="table table-striped schedule">
            <thead>
            <tr>
                <th>Den</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>Upravit</th>
            </tr>
            </thead>
            <tbody id="load-ROZVRH"><!--scriptSelectAJAX.js-->
            </tbody>
        </table>
    </div>
    <br>
</main>
<footer>
    <?php include "../inc/footerAdmin.php" ?>
</footer>
<script>
    $("header nav a:nth-child(2)").addClass("active");
</script>
<?php include "../inc/scriptsAdmin.php" ?>
</body>

</html>