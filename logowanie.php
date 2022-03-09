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
$login = $_POST['l1'];
$haslo = $_POST['l2'];
$haslo = md5($haslo);
if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE login='$login'")) > 0) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE haslo='$haslo'")) > 0) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE login='$login' AND aktywny=1")) > 0) {
            $_SESSION['hello'] = "Witaj na stronie galerii Bartosza Miszczaka";
            $result = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE login='$login'");
            $_SESSION['user'] = mysqli_fetch_assoc($result);
            header("Location:galeria.php");
            exit;
        } else {
            $_SESSION['fail'] = "Użytkownik nieaktywny";
            header("Location:index.php#log");
            exit;
        }
    } else {
        $_SESSION['fail'] = "Nieprawdłowe hasło";
        header("Location:index.php#log");
        exit;
    }
} else {
    $_SESSION['fail'] = "Taki użytkownik nie istnieje";
    header("Location:index.php#log");
    exit;
}
mysqli_close($conn);
?>