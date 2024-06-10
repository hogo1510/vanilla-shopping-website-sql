<?php
session_start();

//foutmeldingen
error_reporting(E_ALL);
ini_set('display_errors', 1);

//check of ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); //niet ingelogd? -> login.php
    exit;
} else {
    header("Location: loggedin.php"); //wel ingelogd? -> loggedin.php
}
?>
