<?php
session_start();
if (isset($_SESSION['backb'])) session_destroy();
header("Location:index.php");
exit();
?>
