<?php
require_once 'includes/db.php'; // gunakan class Database

$db = new Database();
$conn = $db->getConnection();

// Ganti email target dan password aslinya
$email = 'lizdefliz@gmail.com';         // <-- sesuaikan dengan data kamu
$plainPassword = '63978dcb04';         // <-- sesuaikan juga

// Buat hash password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Update password ke database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->execute([$hashedPassword, $email]);

echo "Password untuk user $email berhasil di-hash.";
?>
