<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = [
        'vendor_id' => $_POST['vendor_id'],
        'vendor_name' => $_POST['vendor_name'],
        'price' => $_POST['price']
    ];

    // Inisialisasi cart jika belum ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Tambahkan ke cart
    $_SESSION['cart'][] = $item;

    // Redirect ke halaman cart
    header('Location: cart.php');
    exit();
}
?>
