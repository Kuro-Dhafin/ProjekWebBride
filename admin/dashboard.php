<?php
include 'includes/admin_header.php';
require_once '../config/db.php'; // Pastikan koneksi ke DB

// Ambil data
$vendorCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE user_type = 'vendor'"))['total'];
$checkoutCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM checkouts"))['total'];
?>
<div class="container">
  <div class="card">
    <h3>Total Vendors</h3>
    <p><?= $vendorCount ?></p>
  </div>
  <div class="card">
    <h3>Total Checkouts</h3>
    <p><?= $checkoutCount ?></p>
  </div>
</div>
<?php include 'includes/admin_footer.php'; ?>
