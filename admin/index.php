<html>
<?php
ob_start();
session_start();
include_once "../connect.php";
if (isset($_SESSION['user'])) {
    $type = ($_SESSION['user'])['uprawnienia'];
    if ($type == "administrator" || $type == "moderator") $_SESSION['activePage'] = "adminPanel";
    else {
        header("Location:galeria.php");
        exit;
    }
} else {
    header("Location:index.php");
    exit;
}
?>
<head>
    <title>Panel administracyjny</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="../js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="../js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" href="../css/galeria/style_list.css" type="text/css">
    <link rel="stylesheet" href="../css/galeria/style_galeria.css"
          type="text/css">
    <link rel="stylesheet" href="../css/style_admin.css" type="text/css">
</head>
<body>
<?php
if (!isset($_GET['strona'])) {
    echo '<div id="loader-wrapper"><div class="preloader"></div><p class="textLoader">Wczytywanie zawartości strony</p></div>';
}
?>
<?php include_once "../menu.php"; ?>
<div class="content">
    <div class="filterBar"
         style="text-align: center; color: #FFF; font-weight: bold; font-size: 140%;">
        Panel administracyjny
    </div>
    <div class="gallery"
         style="overflow-y: auto; overflow-x: hidden; height: 85%; display: flex; flex-wrap: wrap; justify-content: center;">
        <?php
        if ($_SESSION['user']['uprawnienia'] == "administrator") {
            echo '<a class="link" href="albumy.php?strona=1&filter=albumy.tytul" id="target"><div class="sel">Albumy</div></a>';
            echo '<a class="link" href="uzytkownicy.php" id="target"><div class="sel">Użytkownicy</div></a>';
        }
        ?>
        <a class="link" href="zdjecia.php" id="target">
            <div class="sel">Zdjęcia</div>
        </a>
        <a class="link" href="komentarze.php" id="target">
            <div class="sel">Komentarze</div>
        </a>
    </div>
    <div class="foot">Bartosz Miszczak 4Ta</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="../js/parallax/jquery.viewportchecker.min.js"></script>
<script src="../js/parallax/setup.js"></script>
<script src="../js/preloader/setup.js"></script>
<script src="../js/confirm.js"></script>
</html>