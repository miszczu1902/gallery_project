<html>
<?php
ob_start();
error_reporting(0);
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
    <title>Albumy</title>
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
<?php include_once "../menu.php"; ?>
<div class="content">
    <div class="filterBar"
         style="text-align: center; color: #FFF; font-weight: bold; font-size: 140%;">
        <span style="text-align: center;">Albumy</span>
        <a class="link" href="index.php"
           style="width: auto; height: 100%; font-size:70%; display:flex;justify-content:center;align-items:center;">
            <div class="comeBack">Powrót</div>
        </a>
    </div>
    <div class="gallery"
         style="overflow:hidden; height: 90%; display: flex; flex-wrap: wrap; justify-content: center;">
        <div style="display:flex;justify-content:center;align-items:center;">
            <a class="link" id="target"
               href="albumy.php?strona=1&filter=albumy.tytul"
               style="padding: 2%; height:auto;">
                <div class="sel">Nazwa albumu</div>
            </a>
            <a class="link" id="target"
               href="albumy.php?strona=1&filter=albumy.data DESC"
               style="padding: 2%;">
                <div class="sel">Najnowsze</div>
            </a>
            <a class="link" id="target"
               href="albumy.php?strona=1&filter=albumy.data ASC"
               style="padding: 2%;">
                <div class="sel">Najstarsze</div>
            </a>
            <a class="link" id="target"
               href="albumy.php?strona=1&filter=uzytkownicy.login"
               style="padding: 2%;">
                <div class="sel">Właściciel</div>
            </a>
        </div>
        <?php
        if ($_SESSION['user']['uprawnienia'] == "administrator") {
            echo '<div class="edit" style="height: 60%; width: auto; overflow-x: hidden; overflow-y: auto;">';
            if (isset($_GET['strona'])) $_SESSION['listAl'] = ($_GET['strona'] - 1) * 20;
            else $_SESSION['listAl'] = 0;
            if (!isset($_GET['filter'])) $_SESSION['filtr'] = "albumy.tytul";
            else $_SESSION['filtr'] = $_GET['filter'];
            echo '<div class="list" style="height: 65%;">';
            $sq = "SELECT zdjecia.id_albumu, zdjecia.id,
                        albumy.tytul, albumy.data,
                        uzytkownicy.login
                        FROM zdjecia, albumy, uzytkownicy
                        WHERE albumy.id=zdjecia.id_albumu
                        AND uzytkownicy.id=albumy.id_uzytkownika
                        GROUP BY albumy.id
                        ORDER BY " . $_SESSION['filtr'] . "
                        LIMIT " . $_SESSION['listAl'] . ", 20";
            $result = mysqli_query($conn, $sq);
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id_albumu'];
                $query = mysqli_query($conn, "SELECT * FROM zdjecia WHERE id_albumu='$id' 
                            AND zaakceptowane=0");
                $nie = mysqli_num_rows($query);
                if ($nie > 0) {
                    echo '<div class="fotNie">
                                     <a class="link" href="albumy.php?strona=' . $_GET['strona'] . '&album=' . $row['id_albumu'] . '&ds=' . $row['tytul'] . '&filter=' . $_GET['filter'] . '"><img class="listFot" src="../img/' . $row['id_albumu'] . '/' . $row['id'] . 'm" />
                                     <div class="tooltipe">Do zaakceptowania: ' . $nie . ' zdjęć
                                        </div></a></div>';
                } else {
                    echo '<div class="fot">
                                    <a class="link" href="albumy.php?strona=' . $_GET['strona'] . '&album=' . $row['id_albumu'] . '&ds=' . $row['tytul'] . '&filter=' . $_GET['filter'] . '"><img class="listFot" src="../img/' . $row['id_albumu'] . '/' . $row['id'] . 'm" />
                                     <div class="tooltipe">Tytuł albumu: ' . $row['tytul'] . '<br>
                                            Utworzył: ' . $row['login'] . '<br>Data powstania: ' . $row['data'] . '
                                        </div></a></div>';
                }
            }
            $result = mysqli_query($conn, "SELECT count(*)
                        FROM zdjecia, albumy, uzytkownicy
                        WHERE zdjecia.zaakceptowane=1
                        AND albumy.id=zdjecia.id_albumu
                        AND uzytkownicy.id=albumy.id_uzytkownika
                        GROUP BY albumy.id
                        ORDER BY " . $_SESSION['filtr'] . "");
            $li = mysqli_num_rows($result) / 20;
            if ($_GET['strona'] <= 0) {
                header("Location:albumy.php?strona=1&filter=" . $_GET['filter'] . "");
                exit();
            }
            echo '</div>';
            echo '<div class="pagin">';
            echo '<div class="prev"><a href="albumy.php?strona=' . ($_GET['strona'] - 1) . '&filter=' . $_GET['filter'] . '" class="link" style="color: #FFF;">&#10094;</a></div> ';
            for ($i = 1; $i <= (ceil($li)); $i++) {
                if ($i >= ($_GET['strona'] - 4) && $i <= ($_GET['strona']) + 4) {
                    if (($i) == $_GET['strona'])
                        echo '<a href="?strona=' . ($i) . '&filter=' . $_GET['filter'] . '" class="link"><div class="pagis" style="background-color: #CCFF66;">' . ($i) . '</div></a>';
                    else echo '<a href="?strona=' . ($i) . '&filter=' . $_GET['filter'] . '" class="link"><div class="pagis">' . ($i) . '</div></a>';
                }
            }
            if ($_GET['strona'] < $li) echo ' <div class="next"><a href="albumy.php?strona=' . ($_GET['strona'] + 1) . '&filter=' . $_GET['filter'] . '" class="link" style="color: #FFF;">&#10095;</a></div>';
            else echo ' <div class="next"><a href="?strona=' . (ceil($li)) . '&filter=' . $_GET['filter'] . '" class="link" style="color: #FFF;">&#10095;</a></div>';
            echo '</div>';
            if (isset($_GET['album'])) {
                echo '<div class="describe">
                                <form method="post" action="albumy.php?strona=' . $_GET['strona'] . '&album=' . $_GET['album'] . '">
                                    <input class="descrEdit" name="opisik" type="text" placeholder="Miejsce na opis albumu"  value="';
                echo $_GET['ds'] . '" maxlength="100" id="opisek" />
                                    <input type="submit" value="Zmień" class="tCh" onclick="return chAlbT()">
                                </form>
                                <form method="post" action="albumy.php?strona=' . $_GET['strona'] . '&album=' . $_GET['album'] . '">
                                    <input type="hidden" value="' . $_GET['album'] . '" name="albumDel"/>
                                    <button type="submit" class="dFo" name="dec" onclick="return delalbs()">&#x2716;
                                    </button><span class="tool" style="color: #FF0000;">Usuń album</span>';
                echo '</form></div>';
            }
            echo '</div>';
        }
        if (isset($_POST['albumDel'])) {
            $albumik = $_GET['album'];
            $result = mysqli_query($conn, "SELECT id FROM zdjecia WHERE id_albumu='$albumik'");
            while ($row = mysqli_fetch_assoc($result)) {
                unlink("../img/" . $albumik . "/" . $row['id'] . "");
                unlink("../img/" . $albumik . "/" . $row['id'] . "m");
            }
            rmdir("../img/" . $albumik . "");

            mysqli_query($conn, "DELETE * FROM zdjecia_oceny WHERE id_zdjecia IN(SELECT id FROM zdjecia WHERE id_albumu='$albumik'");
            mysqli_query($conn, "DELETE * FROM zdjecia_komentarze WHERE id_zdjecia IN(SELECT id FROM zdjecia WHERE id_albumu='$albumik'");
            mysqli_query($conn, "DELETE * FROM zdjecia WHERE id_albumu='$albumik'");
            mysqli_query($conn, "DELETE * FROM albumy WHERE id='$albumik'");
            header("Location:albumy.php?strona=1");
            exit();

        }
        if (isset($_POST['opisik'])) {
            $tytul = $_POST['opisik'];
            $albumik = $_GET['album'];
            if (strlen($tytul) < 3 || strlen($tytul) > 100) {
                echo "Tytuł musi mieć długość od 3 do 100 znaków";
                header("Location:albumy.php?strona=1");
                exit();
            }
            mysqli_query($conn, "UPDATE albumy SET tytul='$tytul' WHERE id='$albumik'");
            header("Location:albumy.php?strona=1");
            exit();
        }
        ob_end_flush();
        ?>
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