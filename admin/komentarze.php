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
    <title>Komentarze</title>
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
        Komentarze
        <a class="link" href="index.php"
           style="width: auto; height: 100%; font-size:70%; display:flex;justify-content:center;align-items:center;">
            <div class="comeBack">Powrót</div>
        </a>
    </div>
    <div class="gallery"
         style="overflow-y: auto; overflow-x: hidden; height: 80%; display: flex; flex-wrap: wrap; justify-content: center;">
        <a class="link" id="target" href="komentarze.php?filtr=wait"
           style="padding: 2%; height:auto; width: auto;">
            <div class="sel">Do zaakceptowania</div>
        </a>
        <a class="link" id="target" href="komentarze.php?filtr=all"
           style="padding: 2%; height:auto; width: auto;">
            <div class="sel">Wszystkie</div>
        </a>
        <div class="edit" style="width: 100%;">
            <?php
            if ($_GET['filtr'] == "wait") {
                $result = mysqli_query($conn, "SELECT zdjecia_komentarze.*, uzytkownicy.login, albumy.tytul,
                            zdjecia.id_albumu
                            FROM zdjecia_komentarze, uzytkownicy, albumy, zdjecia
                            WHERE zdjecia_komentarze.id_uzytkownika=uzytkownicy.id
                            AND zdjecia.id_albumu = albumy.id
                            AND zdjecia_komentarze.id_zdjecia=zdjecia.id
                            AND zdjecia_komentarze.zaakceptowany=0
                            GROUP BY zdjecia_komentarze.id
                            ORDER BY zdjecia_komentarze.data DESC");
            } else {
                $result = mysqli_query($conn, "SELECT zdjecia_komentarze.*, uzytkownicy.login, albumy.tytul,
                            zdjecia.id_albumu
                            FROM zdjecia_komentarze, uzytkownicy, albumy, zdjecia
                            WHERE zdjecia_komentarze.id_uzytkownika=uzytkownicy.id
                            AND zdjecia.id_albumu = albumy.id
                            AND zdjecia_komentarze.id_zdjecia=zdjecia.id
                            GROUP BY zdjecia_komentarze.id
                            ORDER BY zdjecia_komentarze.data DESC");
            }
            if (mysqli_num_rows($result) == 0) {
                echo 'Brak komentarzy do weryfikacji';
            } else {
                echo '<table class="adminComs">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                    <td class="about" style=" width: 50%;" colspan="3">
                                        Komentarz dodał: <b>' . $row['login'] . '</b> (' . $row['data'] . ')
                                    </td>';
                    echo '</tr><tr display:flex;justify-content:center;align-items:center;>';
                    if ($_SESSION['user']['uprawnienia'] == "administrator") {
                        echo '<td class="what" style="width: 70%;">
                                                <form class="editCom" method="post" action="komentarze.php?strona=' . $_GET['strona'] . '">
                                                    <textarea class="titleCh"placeholder="Edytuj komentarz">' . $row['komentarz'] . '</textarea>
                                                    </form>
                                            </td>';
                    } else {
                        echo '<td class="what" style="font-size: 120%; font-weight: bold; text-align: center;"><b>' . $row['komentarz'] . '</b></td>';
                    }
                    if ($row['zaakceptowany'] == 0) {
                        echo '<td class="what" style="text-align: center;">
                                            <form method="post" action="komentarze.php?strona=' . $_GET['strona'] . '" class="acceptForm">
                                                <input type="hidden" name="commAcc" value="' . $row['id'] . '" />
                                                <button type="submit" class="aFo" name="commentA">&#x2714;<br>Zaakceptuj 
                                                </button>
                                            </form></td>';
                    }
                    echo '<td class="what" style="">
                                            <form method="post" action="komentarze.php?strona=' . $_GET['strona'] . '" class="deleteForm">
                                                <input type="hidden" name="comDel" value="' . $row['id'] . '" />
                                                <button type="submit" class="dFo" name="commentD" onclick="return comsure()">&#x2716;<br>Usuń
                                                </button>
                                            </form>
                                        </td>';

                }
                echo '</table>';
                if (isset($_POST['commAcc'])) {
                    mysqli_query($conn, "UPDATE zdjecia_komentarze SET zaakceptowany=1 WHERE id='$_POST[commAcc]'");
                    header("Location:komentarze.php?strona=" . $_GET['strona'] . "");
                    exit();
                }
                if (isset($_POST['comDel'])) {
                    mysqli_query($conn, "DELETE FROM zdjecia_komentarze WHERE id='$_POST[comDel]'");
                    header("Location:komentarze.php?strona=" . $_GET['strona'] . "");
                    exit();
                }
            }
            ?>
        </div>

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