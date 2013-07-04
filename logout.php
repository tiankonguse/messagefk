<?php
session_start();
unset($_SESSION['messagefk_id']);
unset($_SESSION['messagefk_email']);
unset($_SESSION['messagefk_lev']);
header('Location:index.php');
?>