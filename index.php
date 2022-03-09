<!DOCTYPE HTML>
<html>
<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location:galeria.php");
    exit;
}

?>
<head>
    <title>Witaj na stronie Miszczaka</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style_index.css">
    <link rel="stylesheet" href="js/parallax/animate.css" type="text/css">
    <link rel="stylesheet" href="js/preloader/preloader.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap"
          rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?render=6LcSg74UAAAAAITWhv6uGUYeh_KsjIOCUuJzYRCZ"></script>
    <script src="js/reg-correct.js"></script>
    <script src="js/log-correct.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>


</head>
<body>
<div id="loader-wrapper">
    <div class="preloader"></div>
    <p class="textLoader">Wczytywanie strony</p>
</div>
</div>
<div class="menu">
    <div class="ham">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>
    <div class="menu-butts">
        <a href="galeria.php" class="link"><p class="menu-select">Galeria</p>
        </a>
        <a href="dodaj-album.php" class="link"><p class="menu-select">Załóż
                album</p></a>
        <a href="dodaj-foto.php" class="link"><p class="menu-select">Dodaj
                zdjęcie</p></a>
        <a href="top-foto.php" class="link"><p class="menu-select">Najlepiej
                oceniane</p></a>
        <a href="nowe-foto.php" class="link"><p class="menu-select">
                Najnowsze</p></a>
    </div>
</div>
<div class="content">
    <div class="box1" data-animate="fadeIn">
        <h1 class="h1">Witaj na stronie z galerią</h1>
        <p class="first-text">Strona ta jest stroną zaliczeniową na zajęcia z
            E.14</p>
        <a href="#log" class="formy">
            <div class="login" data-animate="bounceInUp">ZALOGUJ SIĘ</div>
        </a>
        <a href="#reg">
            <div class="registry" data-animate="bounceInUp"> ZAREJESTRUJ SIĘ
            </div>
        </a>
    </div>
    <div class="box2">
        <h2><a name="log">Logowanie</a></h2>
        <form class="logon" method="post" action="logowanie.php">
            <div class="seel1">
                <p class="reglog"><label class="lab">Login: </label><input
                            type="text" class="in" placeholder="Podaj login"
                            name="l1" id="l1" required></p>
                <p class="reglog"><label class="lab">Hasło: </label><input
                            type="password" class="in" placeholder="Podaj hasło"
                            name="l2" id="l2" required></p>
            </div>
            <div class="seel2">
                <?php
                if (isset($_SESSION['fail'])) echo '<h3>' . $_SESSION['fail'] . '</h3>';
                else echo '<h3>Jeśli nie masz konta, to formularz z rejestracją znajduje się poniżej</h3>';
                unset($_SESSION['fail']);
                ?>
                <input type="submit" value="Zaloguj" class="send" id="go"
                       onclick="return logchk()">
            </div>
        </form>

        <h2><a name="reg">Rejestracja</a></h2>
        <form class="regi" method="post" action="rejestracja.php">
            <div class="seer1">
                <p class="reglog"><label class="lab">Login: </label><input
                            type="text" name="r1" class="in"
                            placeholder="Podaj login" id="r1" required></p>
                <p class="reglog"><label class="lab">Hasło: </label><input
                            type="password" name="r2" class="in"
                            placeholder="Podaj hasło" id="r2" required></p>
                <p class="reglog"><label class="lab">Potwierdź
                        hasło: </label><input type="password" name="r3"
                                              class="in"
                                              placeholder="Potwierdź hasło"
                                              id="r3" required></p>
                <p class="reglog"><label class="lab">Email: </label><input
                            type="text" class="in" name="r4"
                            placeholder="Podaj email" id="r4" required></p>
                <input type="hidden" id="token" name="token">
                <p style="color:#FFF" ;><i>*Jeśli masz konto to formularz do
                        logowania znajduje się wyżej</i></p>
                <?php
                if (isset($_SESSION['fail1'])) echo '<p class="info" data-animate="bounceInUp">' . $_SESSION["fail1"] . '</p>';
                unset($_SESSION['fail1']);
                ?>
            </div>
            <div class="seer2">
                <p class="info" style="font-size: 170%;">Mail ma wyglądać np.
                    tak: jankowalski@gmail.com </p>
                <p class="info" style="font-size: 170%;">Hasło ma mieć min: 1
                    dużą literę, 1 małą literę i 1 cyfrę</p>
                <p class="info" style="font-size: 170%;">Login ma mieć od 6 do
                    20 znaków, tylko litery i cyfry</p>
                <input type="submit" value="Zarejestruj" class="send"
                       onclick="return chk()" id="add" name="send">
            </div>
        </form>
    </div>
</div>
<div class="foot">Bartosz Miszczak 4Ta</div>

</body>
<script src="js/parallax/jquery.viewportchecker.min.js"></script>
<script src="js/parallax/setup.js"></script>
<script src="js/preloader/setup.js"></script>
<script src="js/recaptcha/setup.js"></script>
</html>
