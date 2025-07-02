<?php
session_start();

// Cek apakah user adalah admin, kalau tidak redirect (opsional)
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

require_once '../includes/db.php';
include '../includes/admin_header.php';

// Pesan logout
$logoutMessage = '';
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
  $logoutMessage = "✅ Anda telah logout dari sistem admin.";
}

// Koneksi
$db = new Database();
$conn = $db->getConnection();

// Total vendor
$stmtVendor = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'vendor'");
$stmtVendor->execute();
$vendorCount = $stmtVendor->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Total transaksi
$stmtCheckout = $conn->prepare("SELECT COUNT(*) AS total FROM transactions");
$stmtCheckout->execute();
$checkoutCount = $stmtCheckout->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
?>

<!-- Tampilkan pesan logout -->
<?php if ($logoutMessage): ?>
  <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; margin: 20px auto; max-width: 500px; border-radius: 5px; text-align: center;">
    <?= $logoutMessage ?>
  </div>
<?php endif; ?>

<!-- Dashboard Konten -->
<div class="container" style="padding: 30px;">
  <div class="card" style="margin-bottom: 20px; padding: 20px; background: #f8f9fa;">
    <h3>Total Vendors</h3>
    <p style="font-size: 24px; font-weight: bold;"><?= $vendorCount ?></p>
  </div>

  <div class="card" style="padding: 20px; background: #f8f9fa;">
    <h3>Total Transactions</h3>
    <p style="font-size: 24px; font-weight: bold;"><?= $checkoutCount ?></p>
  </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
