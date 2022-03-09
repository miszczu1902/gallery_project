<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "gallery_db");
if (mysqli_connect_errno()) {
    echo "Błąd połączenia nr: " . mysqli_connect_errno();
    echo "Opis błędu: " . mysqli_connect_error();
    exit();
}
mysqli_query($conn, 'SET NAMES utf8');
mysqli_query($conn, 'SET CHARACTER SET utf8');
mysqli_query($conn, "SET collation_connection = utf8_polish_ci");
if (isset($_POST['send'])) {
    print_r($_POST);
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => "6LcSg74UAAAAAHVb-qAmY_-RFBoZmOG_-IcX--lD",
        'response' => $_POST['token'],
        //'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    $res = json_decode($response, true);
    if ($res['success'] == true) {
        $login = $_POST['r1'];
        $haslo = $_POST['r2'];
        $phaslo = $_POST['r3'];
        $mail = $_POST['r4'];
        $len = strlen($haslo);
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE login='$login'")) == 0) {
            if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE email='$mail'")) == 0) {
                if (preg_match('/^[A-Za-z0-9]{6,20}$/', $login)) {
                    if (preg_match('/[A-Z]/', $haslo) && preg_match('/[a-z]/', $haslo) && preg_match('/[0-9]/', $haslo) && $len >= 6 && $len <= 20) {
                        if ($phaslo == $haslo) {
                            if (preg_match('/^[a-zA-Z0-9.\-_]+@[a-zA-Z0-9\-.]+\.[a-zA-Z]{2,4}$/', $mail)) {
                                $haslo = md5($haslo);
                                mysqli_query($conn, "INSERT INTO uzytkownicy SET login='$login', haslo='$haslo', email='$mail',uprawnienia='użytkownik', zarejestrowany=now(), aktywny=1");
                                $result = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE login='$login'");
                                $_SESSION['user'] = mysqli_fetch_assoc($result);
                                $_SESSION['regOk'] = 1;
                                header("Location:rejestracja-ok.php");
                                exit;
                            } else {
                                $_SESSION['fail1'] = "Niepoprawny mail";
                                header("Location:index.php#reg");
                                exit;
                            }
                        } else {
                            $_SESSION['fail1'] = "Hasła się nie zgadzają";
                            header("Location:index.php#reg");
                            exit;
                        }
                    } else {
                        $_SESSION['fail1'] = "Błędne hasło";
                        header("Location:index.php#reg");
                        exit;
                    }
                } else {
                    $_SESSION['fail1'] = "Błędny login";
                    header("Location:index.php#reg");
                    exit;
                }
            } else {
                $_SESSION['fail1'] = "Użytkownik o takim mailu jest już w bazie";
                header("Location:index.php#reg");
                exit;
            }
        } else {
            $_SESSION['fail1'] = "Użytkownik o takim loginie jest już w bazie";
            header("Location:index.php#reg");
            exit;
        }
    } else {
        header("Location:index.php#reg");
        exit;
    }
}
mysqli_close($conn);
?>
