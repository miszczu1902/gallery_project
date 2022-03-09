<html>
<?php
error_reporting(0);
unset($_SESSION['preloader']);
if (!isset($_GET[strona])) {
    header("Location:galeria.php?strona=1");
    exit();
}

session_start();
include_once "connect.php";
$_SESSION['activePage'] = "galeria";
if (isset($_SESSION['user'])) {
    unset($_SESSION['success']);
    unset($_SESSION['fail']);
}
if (!isset($_GET['filter'])) $_SESSION['prevPage'] = "galeria.php?strona=" . $_GET['strona'] . "&filter=albumy.tytul";
else $_SESSION['prevPage'] = "galeria.php?strona=" . $_GET['strona'] . "&filter=" . $_GET['filter'] . "";

?>
<head>
    <title>Galeria</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" href="css/galeria/style_list.css" type="text/css">
    <link rel="stylesheet" href="js/select/style.css" type="text/css">
</head>
<body>
<?php
if (!isset($_SESSION['preloader'])) {
    echo '<div id="loader-wrapper"><div class="preloader"></div>
            <p class="textLoader">Wczytywanie zawartości strony</p></div>';
    $_SESSION['preloader'] = true;
}
?>
<?php include_once "menu.php"; ?>
<div class="content">
    <div class="gallery">
        <div class="filterBar">
            <span class="information" style="width: 20%;">Filtruj według:</span>
            <div class="select"
                 style="width: 17%; height: 80%; margin-left: -9.5%;">
                <select name="slot" id="slot"
                        onchange="javascript:filterSelect(this)">
                    <?php
                    switch ($_GET[filter]) {
                        case "albumy.data DESC":
                            echo '<option value="albumy.tytul"><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa albumu</a></option>
                                <option value="albumy.data DESC" selected><a href="galeria.php?strona=' . $_GET[strona] . '">Najnowsze albumy</a></option>
                                <option value="albumy.data ASC"><a href="galeria.php?strona=' . $_GET[strona] . '">Najstarsze albumy</a></option>
                                <option value="uzytkownicy.login"><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa dodającego album</a></option>
                                ';
                            break;
                        case "albumy.data ASC":
                            echo '<option value="albumy.tytul"><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa albumu</a></option>
                                <option value="albumy.data DESC"><a href="galeria.php?strona=' . $_GET[strona] . '">Najnowsze albumy</a></option>
                                <option value="albumy.data ASC" selected><a href="galeria.php?strona=' . $_GET[strona] . '">Najstarsze albumy</a></option>
                                <option value="uzytkownicy.login"><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa dodającego album</a></option>
                                ';
                            break;
                        case "uzytkownicy.login":
                            echo '<option value="albumy.tytul"><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa albumu</a></option>
                                <option value="albumy.data DESC"><a href="galeria.php?strona=' . $_GET[strona] . '">Najnowsze albumy</a></option>
                                <option value="albumy.data ASC"><a href="galeria.php?strona=' . $_GET[strona] . '">Najstarsze albumy</a></option>
                                <option value="uzytkownicy.login" selected><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa dodającego album</a></option>
                                ';
                            break;
                        default:
                            echo '<option value="albumy.tytul" selected><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa albumu</a></option>
                                <option value="albumy.data DESC"><a href="galeria.php?strona=' . $_GET[strona] . '">Najnowsze albumy</a></option>
                                <option value="albumy.data ASC"><a href="galeria.php?strona=' . $_GET[strona] . '">Najstarsze albumy</a></option>
                                <option value="uzytkownicy.login"><a href="galeria.php?strona=' . $_GET[strona] . '">Nazwa dodającego album</a></option>
                                ';
                    }
                    ?>
                </select>
            </div>
            <?php
            echo '<span class="information" style="font-size: 190%; padding: 0; text-align: center;">Witaj w galerii</span>';
            echo '<span class="information" style="float: right; margin-right: -10%;">Strona nr: ' . $_GET['strona'] . '</span>' ?>
        </div>
        <?php
        if (isset($_GET['strona'])) $_SESSION['listAl'] = ($_GET['strona'] - 1) * 20;
        else $_SESSION['listAl'] = 0;
        if (!isset($_GET[filter])) $_SESSION['filtr'] = "albumy.tytul";
        else $_SESSION['filtr'] = $_GET[filter];
        echo '<div class="list" style="height: 75%;">';
        $sq = "SELECT zdjecia.id_albumu, zdjecia.id,
                    albumy.tytul, albumy.data,
                    uzytkownicy.login
                    FROM zdjecia, albumy, uzytkownicy
                    WHERE albumy.id=zdjecia.id_albumu
                    AND uzytkownicy.id=albumy.id_uzytkownika
                    AND zdjecia.zaakceptowane=1
                    GROUP BY albumy.id
                    ORDER BY " . $_SESSION['filtr'] . "
                    LIMIT " . $_SESSION['listAl'] . ", 20";
        $result = mysqli_query($conn, $sq);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="fot">
                                 <a class="link" href="album.php?album=' . $row['id_albumu'] . '&strona=1"><img class="listFot" src="img/' . $row['id_albumu'] . '/' . $row['id'] . 'm" />
                                 <div class="tooltipe">Tytuł albumu: ' . $row['tytul'] . '<br>
                                        Utworzył: ' . $row['login'] . '<br>Data powstania: ' . $row['data'] . '
                                    </div></a>

                            </div>';
        }
        $result = mysqli_query($conn, "SELECT count(*)
                    FROM zdjecia, albumy, uzytkownicy
                    WHERE zdjecia.zaakceptowane=1
                    AND albumy.id=zdjecia.id_albumu
                    AND uzytkownicy.id=albumy.id_uzytkownika
                    GROUP BY albumy.id
                    ORDER BY " . $_SESSION['filtr'] . "");
        $li = mysqli_num_rows($result) / 20;
        echo '</div>';
        ?>
    </div>
    <div class="pagin" style="position: absolute;">
        <?php

        if ($_GET['strona'] <= 0) {
            header("Location:galeria.php?strona=1&filter=" . $_SESSION['filtr'] . "");
            exit();
        }
        echo '<div class="prev"><a href="?strona=' . ($_GET['strona'] - 1) . '&filter=' . $_SESSION['filtr'] . '" class="link" style="color: #FFF;">&#10094;</a></div> ';
        for ($i = 1; $i <= (ceil($li)); $i++) {
            if ($i >= ($_GET['strona'] - 4) && $i <= ($_GET['strona']) + 4) {
                if (($i) == $_GET['strona'])
                    echo '<a href="?strona=' . ($i) . '&filter=' . $_SESSION['filtr'] . '" class="link"><div class="pagis" style="background-color: #CCFF66;">' . ($i) . '</div></a>';
                else echo '<a href="?strona=' . ($i) . '&filter=' . $_SESSION['filtr'] . '" class="link"><div class="pagis">' . ($i) . '</div></a>';
            }
        }
        if ($_GET['strona'] < $li) echo ' <div class="next"><a href="?strona=' . ($_GET['strona'] + 1) . '&filter=' . $_SESSION['filtr'] . '" class="link" style="color: #FFF;">&#10095;</a></div>';
        else echo ' <div class="next"><a href="?strona=' . (ceil($li)) . '&filter=' . $_SESSION['filtr'] . '" class="link" style="color: #FFF;">&#10095;</a></div>';
        ?>
    </div>
    <div class="foot">Bartosz Miszczak 4Ta</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script type="text/javascript" src="js/refresh.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
</html>
