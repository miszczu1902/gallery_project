<?php
if (!isset($_POST['add'])) {
    if (isset($_SESSION['fail1'])) {
        header("Location:dodaj-album.php");
        exit();
    }
}
?>