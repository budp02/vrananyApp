<!--

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor headCanteen.php obsahuje styly a scripty pro zobrazení a tisk jídelního lístku

-->

<head>
    <title><?php echo $pageTitle ?>ZŠ Vraňany</title>
    <meta charset=utf-8>
    <meta name=description
          content="Základní škola Vraňany v okrese Mělník je malotřídní školou pro vzdělávání dětí od 1. do 5. ročníku.">
    <meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=5">
    <link rel="shortcut icon" href=favicon.ico>
    <style>
        @page {
            size: auto;
            margin: 0;
        }
        body {
            font: 14px/21px "Segoe UI", Helvetica, Arial, sans-serif;
        }
        img {
            width: 750px;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .important {
            font-weight: bold;
            width: 150px;
        }
        .day {
            font-size: larger;
            width: 300px;
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .newItemMenu {

            padding: 10px;

        }
    </style>
</head>

