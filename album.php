<html>
<?php
error_reporting(0);
session_start();
include_once "connect.php";
$_SESSION['activePage'] = "galeria";
$result = mysqli_query($conn, "SELECT tytul FROM albumy WHERE id=" . $_GET['album'] . "");
$result = mysqli_fetch_assoc($result);
$title = $result[tytul];
$_SESSION['prevPage1'] = "album.php?album=" . $_GET['album'] . "&strona=" . $_GET['strona'] . "";
?>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" href="css/galeria/style_list.css" type="text/css">
</head>
<body>
<?php include_once "menu.php"; ?>
<div class="content">
    <?php
    echo '<a class="link" href="' . $_SESSION['prevPage'] . '"><div class="circlePrev"><p style="margin-left: 45%; margin-top: 36%;">&#10094</p></div></a>'
    ?>
    <div class="gallery">
        <div class="filterBar"
             style="text-align: center; color: #FFF; font-weight: bold; font-size: 120%;">
            <?php
            echo $title . '<br>';
            echo 'Strona nr: ' . $_GET['strona'];
            ?>
        </div>
        <?php
        if (isset($_GET['strona'])) $_SESSION['listAl'] = ($_GET['strona'] - 1) * 20;
        else $_SESSION['listAl'] = 0;
        echo '<div class="list" style="height: 65%;">';
        $result = mysqli_query($conn, "SELECT * FROM zdjecia WHERE id_albumu=" . $_GET[album] . " AND zaakceptowane=1 ORDER BY data DESC LIMIT " . $_SESSION['listAl'] . ", 20");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="fot">
                                 <a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $row['id'] . '"><img class="listFot" src="img/' . $row['id_albumu'] . '/' . $row['id'] . 'm" />
                                  <div class="tooltipe">Data dodania : ' . $row['data'] . '
                                </div></a></div>';
        }
        $l = mysqli_query($conn, "SELECT * FROM zdjecia WHERE id_albumu=" . $_GET[album] . "");
        $li = mysqli_num_rows($l) / 20;
        ?>
    </div>
    <div class="pagin" style="position: absolute;">
        <?php

        if ($_GET['strona'] <= 0) {
            header("Location:album.php?album=" . $_GET['album'] . "&strona=1");
            exit();
        }
        echo '<div class="prev"><a href="?album=' . $_GET['album'] . '&strona=' . ($_GET['strona'] - 1) . '" class="link" style="color: #FFF;">&#10094;</a></div> ';
        for ($i = 1; $i <= (ceil($li)); $i++) {
            if ($i >= ($_GET['strona'] - 4) && $i <= ($_GET['strona']) + 4) {
                if (($i) == $_GET['strona'])
                    echo '<a href="?album=' . $_GET['album'] . '&strona=' . ($i) . ' class="link"><div class="pagis" style="background-color: #CCFF66;">' . ($i) . '</div></a>';
                else echo '<a href="?album=' . $_GET['album'] . '&strona=' . ($i) . ' class="link"><div class="pagis" >' . ($i) . '</div></a>';
            }
        }
        if ($_GET['strona'] < $li) echo ' <div class="next"><a href="?album=' . $_GET['album'] . '&strona=' . ($_GET['strona'] + 1) . '" class="link" style="color: #FFF;">&#10095;</a></div>';
        else echo ' <div class="next"><a href="?album=' . $_GET['album'] . '&strona=' . (ceil($li)) . '" class="link" style="color: #FFF;">&#10095;</a></div>';
        ?>
    </div>
    <div class="foot">Bartosz Miszczak 4Ta</div>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
</html>
