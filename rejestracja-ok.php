<!DOCTYPE HTML>
<html>
<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['regOk'])) {
    header("Location:index.php");
    exit();
}
?>
<head>
    <title>Witaj na stronie Miszczaka</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style_rejestracja_ok.css">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
</head>
<body>
<div id="loader-wrapper">
    <div class="preloader"></div>
    <p class="textLoader">Sprawdzam poprawność</p>
</div>
</div>
<?php include_once "menu.php"; ?>
<div class="content">
    <div class="box1">
        <h1 class="h1">Zostałeś zarejestrowany</h1>
        <p class="first-text">Kliknij na przycisk aby przejść dalej</p>
        <a href="galeria.php" class="link">
            <div class="goto" data-animate="bounceInUp" onclick="
				   <?php
            //if(isset($_SESSION['regOk'])) //unset($_SESSION['regOk']);
            ?>">
                <p class="first-text">Przejdź do strony głównej</p>
            </div>
        </a>
    </div>
</div>
<div class="foot">Bartosz Miszczak 4Ta</div>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
</html>
