<?php
session_start();
unset($_SESSION['messagefkId']);
unset($_SESSION['messagefkEmail']);
unset($_SESSION['messagefkLev']);
header('Location:index.php');
?>

