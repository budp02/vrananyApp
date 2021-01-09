<!--

 * Copyright (C) 2015 - 2020 Petr Budinský

 * Soubor headFoto.php obsahuje styly a scripty pro zobrazení fotogalerie

-->
<head>
    <title><?php echo $pageTitle ?>ZŠ Vraňany</title>
    <meta charset=utf-8>
    <meta name=description
          content="Základní škola Vraňany v okrese Mělník je malotřídní školou pro vzdělávání dětí od 1. do 5. ročníku.">
    <meta name=viewport content="width=device-width, initial-scale=1, maximum-scale=5">
    <link rel="stylesheet" type="text/css" href="css/styles_min.css?v=92">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/menu.js?v=20"></script>
    <link rel="shortcut icon" href=favicon.ico>
    <!--fancybox settings-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen"/>
    <script>
        $("a.group").fancybox({
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200,
            'overlayShow': false
        });
    </script>
    <!--fancyboxEnd-->
</head>

