<html>
<?php
session_start();
if (isset($_SESSION['user'])) {
    $_SESSION['activePage'] = "dodaj-album";
    include "connect.php";
} else {
    header("Location:index.php");
    exit();
}

?>
<head>
    <title>Dodaj album</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <script src="js/albumAdd.js"></script>
    <style>
    </style>
</head>
<body>
<div id="loader-wrapper">
    <div class="preloader"></div>
    <p class="textLoader">Wczytywanie zawartości strony</p>
</div>
<?php include_once "menu.php"; ?>
<div class="content">
    <div class="gallery">
        <div class="filterBar">
            <span class="information"
                  style="font-size: 190%; text-align: center; margin-left: 30%; margin-right: 30%; width: 40%; padding-top: 0;">Utwórz album</span>
        </div>
        <div class="addAlbum">
            <form method="post" action="dodaj-album.php" class="albumName">
                <input type="text" placeholder="Podaj tu nazwę albumu"
                       name="add" id="add" class="in"><br><br>
                <input type="submit" value="Utwórz album" id="sent"
                       onclick="return chkName()">
                <p style="color:#FFF" ;><i>*Długość nazwy powinna miec od 3 do
                        100 znaków</i></p>
                <p class="first-text"><?php
                    if (isset($_SESSION['fail1'])) {
                        echo $_SESSION['fail1'];
                        unset($_SESSION['fail1']);
                    }
                    ?></p>
                <?php
                if (isset($_POST['add'])) {
                    if (strlen(trim($_POST['add'])) >= 3) {
                        if (strlen(trim($_POST['add'])) <= 100) {
                            $tytul = trim($_POST['add']);
                            $id = $_SESSION['user']['id'];
                            mysqli_query($conn, "INSERT INTO albumy SET tytul='$tytul', data=now(), id_uzytkownika='$id'");
                            $_SESSION['album'] = mysqli_insert_id($conn);
                            $_SESSION['tytul'] = $tytul;
                            mkdir("img/" . $_SESSION['album'], 0777, true);
                            $_SESSION['success'] = "Dodano album " . $tytul . " do bazy";
                            header("Location:dodaj-foto.php?alb=" . $_SESSION['album'] . "");
                            exit();
                        } else {
                            $_SESSION["fail1"] = "Za długa nazwa albumu!";
                            header("Location:dodaj-album.php");
                            exit();
                        }
                    } else {
                        $_SESSION["fail1"] = "Za krótka nazwa albumu!";
                        header("Location:dodaj-album.php");
                        exit();
                    }
                }

                ?>
            </form>
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
