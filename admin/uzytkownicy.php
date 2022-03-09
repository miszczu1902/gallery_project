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
    <title>Użytkownicy</title>
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
        Użytkownicy
        <a class="link" href="index.php"
           style="width: auto; height: 100%; font-size:70%; display:flex;justify-content:center;align-items:center;">
            <div class="comeBack">Powrót</div>
        </a>
    </div>
    <div class="gallery"
         style="overflow-y: auto; overflow-x: hidden; height: 80%; display: flex; flex-wrap: wrap; justify-content: center;">
        <div style="display:flex;justify-content:center;align-items:center;">
            <a class="link" id="target"
               href="uzytkownicy.php?filtr=administrator" style="padding: 2%;">
                <div class="sel">Administratorzy</div>
            </a>
            <a class="link" id="target" href="uzytkownicy.php?filtr=moderator"
               style="padding: 2%;">
                <div class="sel">Moderatorzy</div>
            </a>
            <a class="link" id="target" href="uzytkownicy.php?filtr=użytkownik"
               style="padding: 2%;">
                <div class="sel">Pozostali</div>
            </a>
            <a class="link" id="target" href="uzytkownicy.php?"
               style="padding: 2%;">
                <div class="sel">Wszyscy</div>
            </a>
        </div>
        <?php
        echo '<div class="edit" style="display:flex;justify-content:center;align-items:center;">';
        if (isset($_GET['filtr'])) {
            $result = mysqli_query($conn, "SELECT id, login, uprawnienia, aktywny FROM uzytkownicy WHERE uprawnienia='$_GET[filtr]' ORDER BY uprawnienia DESC");
        } else {
            $result = mysqli_query($conn, "SELECT id, login, uprawnienia, aktywny FROM uzytkownicy ORDER BY uprawnienia DESC");
        }
        echo '<table class="usery">';
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['login'] != $_SESSION['user']['login']) {

                echo '<tr>
                                <td class="nick">' . $row['login'] . '</td>
                                <td>
                                    <form method="post" action="uzytkownicy.php" style="display:flex;justify-content:center;align-items:center;">
                                        <input type="hidden" name="userId1" value="' . $row['id'] . '" />
                                        <select name="upraw" class="upry">';
                switch ($row['uprawnienia']) {
                    case "administrator":
                        echo '
                                                    <option value="' . $row['uprawnienia'] . '" selected>' . $row['uprawnienia'] . '</option>
                                                    <option value="moderator">moderator</option>
                                                    <option value="użytkownik">użytkownik</option>
                                                            ';
                        break;
                    case "moderator":
                        echo '
                                                            <option value="administrator">administrator</option>
                                                            <option value="' . $row['uprawnienia'] . '" selected>' . $row['uprawnienia'] . '</option>
                                                            <option value="użytkownik">użytkownik</option>
                                                            ';
                        break;
                    case "uzytkownik":
                        echo '<option value="administrator">administrator</option>
                                                            <option value="moderator">moderator</option>
                                                            <option value="' . $row['uprawnienia'] . '" selected>' . $row['uprawnienia'] . '</option>
                                                            ';
                        break;
                    default:
                        echo '<option value="administrator">administrator</option>
                                                            <option value="moderator">moderator</option>
                                                            <option value="' . $row['uprawnienia'] . '" selected>' . $row['uprawnienia'] . '</option>
                                                            ';
                }
                echo '</select>';
                echo '<button type="submit" class="tCh" style="margin-left: 15px;">Zmień uprawnienia</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post" action="uzytkownicy.php">
                                                    <input type="hidden" name="userId2" value="' . $row['id'] . '" />
                                                    <button type="submit" class="tCh">';
                if ($row['aktywny'] == 1) {
                    echo 'Zablokuj</button>';
                    echo '<input type="hidden" name="userId2-1" value="0" />';
                } else {
                    echo 'Odblokuj</button>';
                    echo '<input type="hidden" name="userId2-1" value="1" />';
                }

                echo '</form>
                                            </td>
                                            <td>
                                                <form method="post" action="uzytkownicy.php">
                                                    <input type="hidden" name="userId3" value="' . $row['id'] . '" />
                                                    <button type="submit" onclick="return deluser()" class="tCh">Usuń</button>
                                                </form>
                                            </td>
                                          </tr>';
            }
        }
        if (isset($_POST['userId1'])) {
            $up = $_POST['upraw'];
            $id = $_POST['userId1'];
            mysqli_query($conn, "UPDATE uzytkownicy SET uprawnienia='$up' WHERE id='$id'");
            header("Location:uzytkownicy.php");
            exit();
        }
        if (isset($_POST['userId2'])) {
            $id = $_POST['userId2'];
            $act = $_POST['userId2-1'];
            mysqli_query($conn, "UPDATE uzytkownicy SET aktywny='$act' WHERE id='$id'");
            header("Location:uzytkownicy.php");
            exit();
        }
        if (isset($_POST['userId3'])) {
            $user = $_POST['userId3'];
            $result = mysqli_query($conn, "SELECT * FROM zdjecia WHERE id_albumu IN (SELECT id FROM albumy WHERE id_uzytkownika='$user')");
            while ($row = mysqli_fetch_assoc($result)) {
                unlink("../img/" . $row['id_albumu'] . "/" . $row['id'] . "");
                unlink("../img/" . $row['id_albumu'] . "/" . $row['id'] . "m");
            }
            $result = mysqli_query($conn, "SELECT id FROM albumy WHERE id_uzytkownika='$user'");
            while ($row = mysqli_fetch_assoc($result)) {
                rmdir("../img/" . $row['id'] . "");
            }
            mysqli_query($conn, "DELETE * FROM zdjecia_oceny WHERE id_uzytkownika='$user'");
            mysqli_query($conn, "DELETE * FROM zdjecia_oceny WHERE id_zdjecia IN (SELECT id FROM zdjecia WHERE id_albumu IN(SELECT id FROM albumy WHERE id_uzytkownika='$user'))");
            mysqli_query($conn, "DELETE * FROM zdjecia_komentarze WHERE id_zdjecia IN (SELECT id FROM zdjecia WHERE id_albumu IN(SELECT id FROM albumy WHERE id_uzytkownika='$user'))");
            mysqli_query($conn, "DELETE * FROM zdjecia_komentarze WHERE id_uzytkownika='$user'");
            mysqli_query($conn, "DELETE * FROM zdjecia WHERE id_albumu IN (SELECT id FROM albumy WHERE id_uzytkownika='$user')");
            mysqli_query($conn, "DELETE * FROM albumy WHERE id_uzytkownika='$user'");
            mysqli_query($conn, "DELETE * FROM uzytkownicy WHERE id='$user'");
            header("Location:uzytkownicy.php");
            exit();
        }
        echo '</table></div>';
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