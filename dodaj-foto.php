<html>
<?php
error_reporting(0);
session_start();
if (isset($_SESSION['user'])) {
    $_SESSION['activePage'] = "dodaj-foto";
    include_once "connect.php";
} else {
    header("Location:index.php");
    exit;
}
?>
<head>
    <title>Dodaj zdjęcie</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/galeria/style_galeria.css">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link rel="stylesheet" href="js/select/style.css" type="text/css">
    <link rel="stylesheet" href="css/galeria/style_typefile.css"
          type="text/css">
    <link rel="stylesheet" href="css/galeria/style_list.css" type="text/css">
    <script type="text/javascript" src="js/refresh.js"></script>
</head>
<body>
<?php
if (!isset($_GET['alb'])) {
    echo '<div id="loader-wrapper"><div class="preloader"></div><p class="textLoader">Wczytywanie zawartości strony</p></div>';
}
?>
<?php include_once "menu.php"; ?>
<div class="content">
    <div class="gallery">
        <div class="filterBar" style="top: 0;">
            <span class="information"
                  style="font-size: 190%; text-align: center; margin-left: 30%; margin-right: 30%; width: 40%; padding-top: 0;">Dodawanie zdjęć</span>
        </div>

        <form method="post" action="dodaj-foto.php" class="fotoAdd"
              enctype="multipart/form-data">
            <div class="select">
                <select name="slot" id="slot"
                        onchange="javascript:handleSelect(this)">
                    <option value="">Wybierz album</option>
                    <?php
                    $userId = $_SESSION['user']['id'];
                    $result = mysqli_query($conn, "SELECT id,tytul FROM albumy WHERE id_uzytkownika=" . $userId . " ORDER BY tytul");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        if ($id == $_GET[alb]) echo '<option value=' . $id . ' selected><a href="dodaj-foto.php?alb=' . $id . '">' . $row["tytul"] . '</a></option>';
                        else  echo '<option value=' . $id . '><a href="dodaj-foto.php?alb=' . $id . '">' . $row["tytul"] . '</a></option>';
                    }
                    ?>
                </select>
            </div>
            <div class="container">
                <label class="label" for="input">Wybierz zdjęcie, które chcesz
                    dodać</label>
                <div class="input">
                    <input name="input" id="file" type="file" required>
                </div>
            </div>
            <textarea rows="2" cols="128 "
                      placeholder="(Opcjonalnie) Opisz sobie zdjecie, ale opis musi mieć maksymalnie 255 znaków!"
                      name="ds" id="ds" class="ds"></textarea>
            <br><br>
            <input type="submit" value="Dodaj zdjęcia" id="sent"
                   onclick="return chkLen()">
            <?php
            if (isset($_SESSION['success'])) {
                echo "<p class='first-text'>" . $_SESSION['success'] . "</p>";
                unset($_SESSION['success']);
            } elseif (isset($_SESSION['fail'])) {
                echo "<p class='first-text'>" . $_SESSION['fail'] . "</p>";
                unset($_SESSION['fail']);
            }
            $_SESSION['album'] = $_POST['slot'];
            if (isset($_POST['ds'])) {
                $_SESSION['type'] = mime_content_type($_FILES['input']['tmp_name']);
                $_SESSION['type'] = substr($_SESSION['type'], 0, 5);
                if ($_SESSION['type'] == "image") {
                    $opis = $_POST['ds'];
                    if (strlen($opis) <= 255) {
                        mysqli_query($conn, "INSERT INTO zdjecia SET opis='$opis', data=now(), zaakceptowane=0, id_albumu=" . $_SESSION['album']);
                        $_SESSION['zdjecie'] = mysqli_insert_id($conn);
                        $lok = "img/" . $_SESSION['album'] . "/" . $_SESSION["zdjecie"];
                        include_once "class.img.php";
                        $img = new Image($_FILES['input']['tmp_name']);
                        $img->SetMaxSize(1200);
                        $img->Save($lok);
                        $lok = "img/" . $_SESSION['album'] . "/" . $_SESSION["zdjecie"] . "m";
                        $img = new Image($_FILES['input']['tmp_name']);
                        $img->SetSize(180, 180);
                        $img->Save($lok);
                        unset($_SESSION["zdjecie"]);
                        $_SESSION['success'] = "Dodano zdjęcie do albumu";
                    } else $_SESSION['fail'] = "Za długi opis zdjęcia";
                } else $_SESSION['fail'] = "Podany plik nie jest zdjeciem";
                header("Location:dodaj-foto.php?alb=" . $_SESSION['album'] . "");
                exit();
            }
            ?>
        </form>
        <?php
        if (isset($_GET[alb])) $_SESSION['show'] = $_GET[alb];
        elseif (isset($_SESSION['album'])) $_SESSION['show'] = $_SESSION['album'];
        echo '<div class="list" style="height: 28%;">';
        $result = mysqli_query($conn, "SELECT id FROM zdjecia WHERE id_albumu=" . $_SESSION['show']);
        while ($row = mysqli_fetch_assoc($result)) {
            $idFoto = $row['id'];
            echo '<div class="fot">
                            <img class="listFot"src="img/' . $_SESSION['show'] . '/' . $idFoto . 'm" />
                    </div>';
        }
        echo '</div>';
        ?>
    </div>
    <div class="foot">Bartosz Miszczak 4Ta</div>
</div>
</body>
<script src="js/len255.js"></script>
<script defer type="text/javascript"
        src="https://stackend.com/launch.js"></script>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
<script src="js/typefile.js"></script>
</html>
