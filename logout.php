<?php
session_start();
session_destroy();

// Ambil URL redirect jika ada
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

// Arahkan ke halaman yang diminta
header("Location: $redirect");
exit;
