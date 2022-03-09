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
    <title>Zdjęcia</title>
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
        Zdjęcia
        <a class="link" href="index.php"
           style="width: auto; height: 100%; font-size:70%; display:flex;justify-content:center;align-items:center;">
            <div class="comeBack">Powrót</div>
        </a>
    </div>
    <div class="gallery"
         style="overflow-y: auto; overflow-x: hidden; height: 80%; display: flex; flex-wrap: wrap; justify-content: center; height: auto;">
        <div class="edit"
             style="display:flex;justify-content:center;align-items:center;">
            <?php
            $result = mysqli_query($conn, "SELECT zdjecia.id, zdjecia.id_albumu, zdjecia.opis, albumy.id AS album, albumy.tytul, uzytkownicy.login, zdjecia.data FROM zdjecia, albumy, uzytkownicy WHERE zdjecia.id_albumu=albumy.id AND zaakceptowane=0
                        GROUP BY zdjecia.id");
            if (mysqli_num_rows($result) == 0) echo 'Brak zdjęć do akceptacji';
            else {
                echo '<table class="adminFotos">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                                    <td class="fotki" style="border-radius: 5px;">
                                        <a class="link" href="../img/' . $row['id_albumu'] . '/' . $row['id'] . '" target="_blank"><img src="../img/' . $row['id_albumu'] . '/' . $row['id'] . 'm" style="border-radius: 5px;"/></a><br>Album: ' . $row['tytul'] . '<br>Dodał: '
                        . $row['login'] . ' (' . $row['data'] . ')<br>';
                    if (strlen($row['opis']) != 0) echo 'Opis:' . $row['opis'];
                    echo '<td class="what"  style="display:flex; justify-content:center; align-items:center;">
                                        <form method="post" action="zdjecia.php?strona=' . $_GET['strona'] . '" class="acceptForm">
                                            <input type="hidden" name="hAcc" value="' . $row['id'] . '">
                                            <button type="submit" class="aFo" name="acc">&#x2714;
                                            </button><span class="tool" style="color: #66ff66; font-size: 140%;">Zaakceptuj zdjęcie</span>
                                        </form>
                                    </td>
                                    <td class="what"  style="display:flex;justify-content:center;align-items:center;">
                                        <form method="post" action="zdjecia.php?strona=' . $_GET['strona'] . '" class="deleteForm">
                                            <input type="hidden" name="hDel" value="' . $row['id'] . '">
                                            <input type="hidden" name="alDel" value="' . $row['id_albumu'] . '">
                                            <button type="submit" class="dFo" name="dec" onclick="return fotsure()">&#x2716;
                                            </button><span class="tool" style="font-size: 140%; color: #FF0000;">Usuń zdjęcie</span>
                                        </form>
                                    </td>
                                </tr>';
                }
                echo '</table>';
            }
            if (isset($_POST['hAcc'])) {
                $id = $_POST['hAcc'];
                mysqli_query($conn, "UPDATE zdjecia SET zaakceptowane=1 WHERE id='$id'");
                header("Location:zdjecia.php?strona=" . $_GET['strona'] . "");
                exit();
            }
            if (isset($_POST['hDel'])) {
                $id = $_POST['hDel'];
                mysqli_query($conn, "DELETE * FROM zdjecia WHERE id='$id'");
                $album = $_POST['alDel'];
                unlink("../img/" . $album . "/" . $id . "");
                unlink("../img/" . $album . "/" . $id . "m");
                header("Location:zdjecia.php?strona=" . $_GET['strona'] . "");
                exit();
            }
            ob_end_flush();
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