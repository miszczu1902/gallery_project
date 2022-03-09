<html>
<?php
error_reporting(0);
session_start();
include_once "connect.php";
unset($_SESSION['preloader']);
$_SESSION['activePage'] = "top-foto";
?>
<head>
    <title>Najlepiej oceniane zdjęcia</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" href="css/galeria/style_list.css" type="text/css">
</head>
<body>
<div id="loader-wrapper">
    <div class="preloader"></div>
    <p class="textLoader">Wczytywanie zawartości strony</p>
</div>
<?php include_once "menu.php"; ?>
<div class="content">
    <div class="gallery">
        <div class="filterBar"
             style="text-align: center; color: #FFF; font-weight: bold; font-size: 160%;">
            Najlepiej oceniane zdjęcia
        </div>
        <?php
        $result = mysqli_query($conn, "SELECT zdjecia_oceny.id_zdjecia, AVG(zdjecia_oceny.ocena) AS srednia,
                    zdjecia.id_albumu, zdjecia.data
                    FROM zdjecia_oceny, zdjecia
                    WHERE zdjecia.zaakceptowane=1
                    AND zdjecia_oceny.id_zdjecia=zdjecia.id
                    GROUP BY zdjecia_oceny.id_zdjecia
                    ORDER BY srednia DESC
                    LIMIT 20");
        echo '<div class="list" style="height: 78%">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="fot">
                                 <a class="link" href="foto.php?album=' . $row['id_albumu'] . '&foto=' . $row['id_zdjecia'] . '"><img class="listFot" src="img/' . $row['id_albumu'] . '/' . $row['id_zdjecia'] . 'm" />
                                  <div class="tooltipe">Średnia ocena użytkowników: ' . round($row['srednia'], 2) . '
                                </div></a></div>';
        }
        echo '</div>';
        ?>
    </div>
    <div class="foot">Bartosz Miszczak 4Ta</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
</html>
