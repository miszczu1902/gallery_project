<html>
<?php
ob_start();
session_start();
error_reporting(0);
include_once "connect.php";
$_SESSION['activePage'] = "galeria";
$_SESSION['prevPage1'] = "album.php?album=" . $_GET['album'] . "&strona=" . $_GET['strona'] . "";

?>
<head>
    <title>Zdjecia z albumu</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" href="css/galeria/style_list.css" type="text/css">
    <link rel="stylesheet" href="js/rating/rating.css" type="text/css">
</head>
<body>
<?php include_once "menu.php"; ?>
<div class="content">
    <a class="link" href="<?php echo $_SESSION['prevPage1']; ?>">
        <div class="circlePrev"><p style="margin-left: 45%; margin-top: 36%;">
                &#10094</p></div>
    </a>
    <div class="gallery">
        <div class="filterBar"
             style="color: #FFF; font-weight: bold; font-size: 100%; padding: 1%;">
            <?php
            $result = mysqli_query($conn, "SELECT zdjecia.id, zdjecia.opis, zdjecia.data,
                    uzytkownicy.login, albumy.id_uzytkownika, uzytkownicy.id, albumy.tytul
                    FROM zdjecia, uzytkownicy, albumy
                    WHERE zdjecia.id=" . $_GET['foto'] . "
                    AND zdjecia.zaakceptowane=1
                    AND albumy.id=zdjecia.id_albumu
                    AND uzytkownicy.id=albumy.id_uzytkownika");
            while ($row = mysqli_fetch_assoc($result)) {
                echo $row['tytul'] . '<br>'
                    . $row['login'] . ', ' . $row['data'] . '<span style="border-left: 1px solid #FFF; height: 100%; margin-left: 2%; padding-left: 1%;">' . $row['opis'] . '</span>';
            }
            ?>
        </div>
        <div class="fotoView">
            <div class="slider">
                <img class="fotoCont"
                     src="<?php echo "img/" . $_GET[album] . "/" . $_GET[foto] . "" ?>"/>
                <?php
                $result = mysqli_query($conn, "SELECT id FROM zdjecia WHERE zaakceptowane=1 AND id_albumu=" . $_GET['album'] . "");
                $x = array();
                $n = mysqli_num_rows($result);
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $x[$i] = $row['id'];
                    $i++;
                }
                for ($i = 1; $i <= $n; $i++) {
                    if ($x[$i] == $_GET['foto']) {
                        if ($n == 1) {
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[$n] . '"><div class="prevFoto">&#10094</div></a>';
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[$n] . '"><div class="nextFoto">&#10095</div></a>';
                        } elseif ($_GET['foto'] == $x[1]) {
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[$n] . '"><div class="prevFoto">&#10094</div></a>';
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[2] . '"><div class="nextFoto">&#10095</div></a>';
                        } elseif ($_GET['foto'] == $x[$n]) {
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[$n - 1] . '"><div class="prevFoto">&#10094</div></a>';
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[1] . '"><div class="nextFoto">&#10095</div></a>';
                        } else {
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[$i - 1] . '"><div class="prevFoto">&#10094</div></a>';
                            echo '<a class="link" href="foto.php?album=' . $_GET['album'] . '&foto=' . $x[$i + 1] . '"><div class="nextFoto">&#10095</div></a>';
                        }
                    }
                }

                ?>

            </div>
            <div class="rating">
                <?php
                if (!isset($_SESSION['user'])) echo '<div class="noUser">Tylko zalogowani użytkownicy mogą oceniać zdjęcia</div>';
                else {
                    $to = "foto.php?album=" . $_GET['album'] . "&foto=" . $_GET['foto'] . "";
                    $result = mysqli_query($conn, "SELECT * FROM zdjecia_oceny WHERE id_zdjecia=" . $_GET['foto'] . " AND id_uzytkownika=" . $_SESSION['user']['id'] . "");
                    $num = mysqli_num_rows($result);
                    $result = mysqli_fetch_assoc($result);
                    if ($num != 0) {
                        echo '<p style=" font-weight: bold; color: #FFF;">Dodałeś już ocenę (' . $result['ocena'] . ') ale możesz ją zmienić</p>';
                    }
                    echo '
                        <form class="addNote" method="post" action="' . $to . '">
                            <span class="star-cb-group">
                              <input type="radio" id="rating-10" name="rating" value="10" /><label for="rating-10">10</label>
                              <input type="radio" id="rating-9" name="rating" value="9" /><label for="rating-9">9</label>
                              <input type="radio" id="rating-8" name="rating" value="8" /><label for="rating-8">8</label>
                              <input type="radio" id="rating-7" name="rating" value="7" /><label for="rating-7">7</label>
                              <input type="radio" id="rating-6" name="rating" value="6" /><label for="rating-6">6</label>
                              <input type="radio" id="rating-5" name="rating" value="5" /><label for="rating-5">5</label>
                              <input type="radio" id="rating-4" name="rating" value="4" /><label for="rating-4">4</label>
                              <input type="radio" id="rating-3" name="rating" value="3" /><label for="rating-3">3</label>
                              <input type="radio" id="rating-2" name="rating" value="2" /><label for="rating-2">2</label>
                              <input type="radio" id="rating-1" name="rating" value="1" /><label for="rating-1">1</label>
                        </span>
                    <input type="submit" id="sent" value="Oceń" style="width: 20%; height: auto; padding: auto; margin-left: 3%; margin-top: 8px;">
                    </form>';
                    if (isset($_POST['rating'])) {
                        if ($num != 0) {
                            mysqli_query($conn, "UPDATE zdjecia_oceny SET ocena=" . $_POST['rating'] . " WHERE id_uzytkownika=" . $_SESSION['user']['id'] . "
                          AND id_zdjecia=" . $_GET['foto'] . "");
                        } else {
                            mysqli_query($conn, "INSERT INTO zdjecia_oceny SET id_zdjecia=" . $_GET[foto] . ", id_uzytkownika=" . $_SESSION['user']['id'] . ", ocena=" . $_POST['rating'] . "");
                        }
                        header("Location:foto.php?album=" . $_GET['album'] . "&foto=" . $_GET['foto'] . "");
                        exit();
                    }
                }
                $result = mysqli_query($conn, "SELECT avg(ocena) AS srednia, COUNT(id_uzytkownika) AS ocenialo FROM zdjecia_oceny WHERE id_zdjecia=" . $_GET['foto'] . "");
                $result = mysqli_fetch_assoc($result);
                echo '<div class="about">';
                if ($result['ocenialo'] == 0) {
                    echo '<p style="font-weight: bold; text: align: center; color: #FFF;">Brak ocen dla zdjęcia</p>';
                } else {
                    echo '<p style="font-weight: bold; text: align: center; color: #FFF;">Oceniało: ' . $result['ocenialo'] . ' użytkowników <br>';
                    echo 'Średnia ocena zdjęcia: ' . round($result['srednia'], 2) . '</p>';
                }
                echo '</div>';

                ?>
            </div>
            <div class="commentList">
                <?php
                $query = "SELECT zdjecia_komentarze.*, uzytkownicy.id, uzytkownicy.login
                    FROM zdjecia_komentarze, uzytkownicy
                    WHERE zdjecia_komentarze.zaakceptowany=1
                    AND uzytkownicy.id=zdjecia_komentarze.id_uzytkownika
                    AND zdjecia_komentarze.id_zdjecia='$_GET[foto]'
                    ORDER BY zdjecia_komentarze.data DESC";
                $result = mysqli_query($conn, $query);
                $num = mysqli_num_rows($result);
                if ($num == 0) echo '<div class="comment">Brak komentarzy</div>';
                else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="comment">
                        ' . $row['login'] . '<br>' . $row['data'] .
                            '<span class="con" >' . $row['komentarz'] . '</span></div>';
                    }
                }
                if (!isset($_SESSION['user'])) {
                    echo '<p style="text-align: center;">Tylko zalogowani użytkownicy mogą komentować zdjęcia</p>';
                } else {
                    echo '
                            <form class="addComment" method="post" action="' . $to . '">
                              <textarea class="comment" placeholder="Tu wpisz swój komentarz..." name="komentarz" required></textarea>
                              <input type="submit" id="sent" value="Skomentuj" style="width: 10%; height: auto; padding: auto; margin-left: -14%;">
                            </form>';
                }
                ?>
                <?php

                if (isset($_POST['komentarz'])) {
                    $u = $_SESSION['user']['id'];
                    mysqli_query($conn, "INSERT INTO zdjecia_komentarze SET data=now(), komentarz='$_POST[komentarz]', id_zdjecia='$_GET[foto]', id_uzytkownika='$u'");
                    header("Location:foto.php?album=" . $_GET['album'] . "&foto=" . $_GET['foto'] . "");
                    exit();
                }
                ob_end_flush();
                ?>
            </div>
        </div>
    </div>
    <div class="foot">Bartosz Miszczak 4Ta</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
<script src="js/rating/setup.js"></script>
</html>
