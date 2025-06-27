<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: /admin/login.php");
        exit();
    }
}
?>