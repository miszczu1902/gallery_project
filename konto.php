<html>
<?php
ob_start();
session_start();
error_reporting(0);
include_once "connect.php";
unset($_SESSION['preloader']);
if (isset($_SESSION['user'])) $_SESSION['activePage'] = "konto";
else {
    header("Location:index.php");
    exit;
}
?>
<head>
    <title><?php echo "Profil " . $_SESSION['user']['login'] . "" ?></title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <script src="js/confirm.js"></script>
</head>
<body>
<?php
if (!isset($_GET['album'])) {
    echo '<div id="loader-wrapper"><div class="preloader"></div><p class="textLoader">Wczytywanie zawartości strony</p></div>';
}
?>
<?php include_once "menu.php"; ?>
<div class="content">
    <div class="filterBar"
         style="color: #FFF; font-weight: bold; font-size: 140%;">
        <table style="width: 100%; height: 100%;" class="inx">
            <tr>
                <td class="oUserku"><?php echo $_SESSION['user']['login']; ?></td>
                <td class="oUserku" style="width: 8%;"><img
                            src="img/icons/permission.png"/></td>
                <td class="oUserku"
                    style="text-align: left;"><?php echo $_SESSION['user']['uprawnienia'] ?></td>
                <td class="oUserku" style="width: 8%;"><img
                            src="img/icons/time-and-date.png"/></td>
                <td class="oUserku"
                    style="text-align: left;"><?php echo $_SESSION['user']['zarejestrowany'] ?></td>
            </tr>

        </table>
    </div>
    <div class="gallery"
         style="overflow-y: auto; overflow-x: hidden; height: 85%;">
        <div class="view">
            <div class="edit" style="width: 40%;">Moje konto
                <div class="konto" style="margin-top: 1%;">
                    <?php $adres = "konto.php?album=" . $_GET['album'] . "" ?>
                    <table class="chAc">
                        <form class="changeDane" method="post"
                              action="<?php echo $adres; ?>">
                            <tr>
                                <td class="st"><input type="mail" class="chIN"
                                                      placeholder="Tu możesz zmienić swój email"
                                                      name="mail" id="mail"
                                                      value="<?php echo trim($_SESSION['user']['email']); ?>"/>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="password" class="chIN"
                                           placeholder="Tu możesz zmienić hasło"
                                           name="password" id="password"/></td>
                                <td class="st" style="text-align: center;"><span
                                            class="change" onclick="show()">Pokaż hasło</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="st"><input type="password"
                                                      class="chIN"
                                                      placeholder="Wpisz obecne hasło"
                                                      name="conPassword"/></td>
                                <td style="display: flex;
                                flex-wrap: wrap; justify-content: center;">
                                    <input type="submit" id="sent" value="Zmień"
                                           style="font-size: 100%; width: 50%; padding: 3px; margin-right: 2%;"
                                           onclick="return confirmx()"
                                           name="conf" id="conf"/>
                                </td>
                            </tr>
                        </form>
                    </table>
                    <?php
                    if (isset($_POST['conPassword'])) {
                        if (md5($_POST['conPassword']) == $_SESSION['user']['haslo']) {
                            $mail = $_POST['mail'];
                            $haslo = md5($_POST['password']);
                            $id = $_SESSION['user']['id'];
                            if ($mail == "") {
                                if ($haslo != "") {
                                    mysqli_query($conn, "UPDATE uzytkownicy 
                                            SET haslo='$haslo' 
                                            WHERE id='$id'");
                                }
                            }
                            if ($haslo == "") {
                                if ($mail != "") {
                                    mysqli_query($conn, "UPDATE uzytkownicy 
                                            SET email='$mail' 
                                            WHERE id='$id'");
                                }
                            }
                            if ($mail != "" && $haslo != "") {
                                mysqli_query($conn, "UPDATE uzytkownicy 
                                        SET haslo='$haslo', email='$mail' 
                                        WHERE id='$id'");
                            }
                        }
                        header("Location:konto.php?album=" . $_GET['album'] . "");
                        exit();
                    }
                    ?>
                </div>
            </div>
            <div class="edit" style="width: 40%;">Moje albumy
                <?php
                if (isset($_SESSION['fail1'])) {
                    echo $_SESSION['fail1'];
                    unset($_SESSION['fail1']);
                }
                $id = $_SESSION['user']['id'];
                $result = mysqli_query($conn, "SELECT id, tytul FROM albumy WHERE id_uzytkownika='$id'");
                echo '<div class="albums">';
                echo '<table class="editAlbums">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class="albumTitle">
                                <form method="post" action="konto.php?album=' . $row['id'] . '">
                                    <input type="text" class="titleCh" value="' . $row['tytul'] . '" name="title1" id="title' . $row['id'] . '">
                                    <input type="submit" value="Zmień" class="tCh" onclick="return titleCh(' . $row['id'] . ')">
                                </form>
                                </td>';
                    echo '<td class="albumSel"><a class="link" style="color: #66ff66; text-align: center;" href="konto.php?album=' . $row['id'] . '">&#x2714;</a></td>';
                    echo '<td class="albumDel">
                                <form method="post" action="konto.php?album=' . $row['id'] . '" class="delAlb">
                                    <input type="hidden" name="erAlb" value="true">
                                    <button type="submit" class="aDel" onclick="return albsure()">&#x2716;</button>
                                </form></td></tr>';
                }
                echo '</table>';
                echo '</div>';
                if (isset($_POST['title1'])) {
                    if (strlen(trim($_POST['title1'])) >= 3) {
                        if (strlen(trim($_POST['title1'])) <= 100) {
                            $tytul = trim($_POST['title1']);
                            $id = $_SESSION['user']['id'];
                            mysqli_query($conn, "UPDATE albumy SET tytul='$tytul' WHERE id_uzytkownika='$id' AND id=" . $_GET['album'] . "");
                            header("Location:konto.php?album=" . $_GET['album'] . "");
                            exit();
                        } else {
                            $_SESSION["fail1"] = "Za długa nazwa albumu (Od 3 do 100 znaków)!";
                            header("Location:konto.php?album=" . $_GET['album'] . "");
                            exit();
                        }
                    } else {
                        $_SESSION["fail1"] = "Za krótka nazwa albumu (Od 3 do 100 znaków)!";
                        header("Location:konto.php?album=" . $_GET['album'] . "");
                        exit();
                    }
                }
                if (isset($_POST['erAlb'])) {
                    $album = $_GET['album'];
                    mysqli_query($conn, "DELETE FROM albumy WHERE id='$album'");
                    $result = mysqli_query($conn, "DELETE FROM zdjecia WHERE id_albumu='$album'");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        mysqli_query($conn, "DELETE FROM zdjecia_oceny WHERE id_zdjecia='$id'");
                        mysqli_query($conn, "DELETE FROM zdjecia_komentarze
                                   WHERE id_zdjecia='$id'");
                        unlink("img/" . $_GET['album'] . "/" . $id . "");
                        unlink("img/" . $_GET['album'] . "/" . $id . "m");
                    }
                    rmdir("img/" . $_GET['album'] . "");
                    header("Location:konto.php?album=");
                    exit();
                }
                ?>
            </div>
            <div class="edit" style="width: 95%; overflow-y: hidden;">
                Zdjecia albumu
                <?php
                echo '<div class="fotosy">';
                echo '<table class="editFotos">';
                $result = mysqli_query($conn, "SELECT id, opis FROM zdjecia WHERE id_albumu=" . $_GET['album'] . "");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class="foty"><img src="img/' . $_GET['album'] . '/' . $row['id'] . 'm" style="border-radius:5px;" /></td>';
                    echo '<td class="opis"><form method="post" action="konto.php?album=' . $_GET['album'] . '">
                                        <input type="hidden" value="' . $row['id'] . '" name="fotId">
                                        <input type="text" class="titleCh" value="' . $row['opis'] . '" maxlength="255" name="opisFot" placeholder="Brak opisu">
                                        <input type="submit" value="Zmień" class="tCh">
                                        </form></td>';
                    echo '<td><td class="albumDel">
                                <form method="post" action="konto.php?album=' . $_GET['album'] . '" class="delAlb">
                                    <input type="hidden" name="erFot" value="' . $row['id'] . '" id="erFoto">
                                    <button type="submit" class="aDel" onclick="return fotsure()">&#x2716;</button>
                                </form></td>';
                    echo '</tr>';
                }
                echo '</table></div>';
                if (isset($_POST['opisFot'])) {
                    $zm = $_POST['opisFot'];
                    mysqli_query($conn, "UPDATE zdjecia SET opis='$zm' WHERE id=" . $_POST['fotId'] . "");
                    header("Location:konto.php?album=" . $_GET['album'] . "");
                    exit();
                }
                if (isset($_POST['erFot'])) {
                    mysqli_query($conn, "DELETE FROM zdjecia WHERE id=" . $_POST['erFot'] . "");
                    mysqli_query($conn, "DELETE FROM zdjecia_oceny WHERE id_zdjecia=" . $_POST['erFot'] . "");
                    mysqli_query($conn, "DELETE FROM zdjecia_komentarze WHERE id_zdjecia=" . $_POST['erFot'] . "");
                    unlink("img/" . $_GET['album'] . "/" . $_POST['erFot'] . "");
                    unlink("img/" . $_GET['album'] . "/" . $_POST['erFot'] . "m");
                    header("Location:konto.php?album=" . $_GET['album'] . "");
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
</html>
