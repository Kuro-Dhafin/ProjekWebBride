<?php
session_start();

// Hapus semua data session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect ke login.php dengan pesan sukses
header("Location: ../login.php?logout=1");
exit;
