<?php
session_start();

// Check if user is admin, if not redirect
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

require_once '../includes/db.php';
include '../includes/admin_header.php';

// Logout message
$logoutMessage = '';
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
  $logoutMessage = "✅ Anda telah logout dari sistem admin.";
}

// Database connection
$db = new Database();
$conn = $db->getConnection();

// Total vendors
$stmtVendor = $conn->prepare("SELECT COUNT(*) AS total FROM users WHERE role = 'vendor'");
$stmtVendor->execute();
$vendorCount = $stmtVendor->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Total transactions
$stmtCheckout = $conn->prepare("SELECT COUNT(*) AS total FROM transactions");
$stmtCheckout->execute();
$checkoutCount = $stmtCheckout->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Get recent transactions (for new section)
$stmtRecent = $conn->prepare("SELECT * FROM transactions ORDER BY created_at DESC LIMIT 5");
$stmtRecent->execute();
$recentTransactions = $stmtRecent->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-pink: #e83e8c;
      --soft-pink: #ff85a2;
      --light-pink: #ffdeeb;
      --dark-pink: #c2185b;
      --pink-gradient: linear-gradient(135deg, #e83e8c 0%, #ff85a2 100%);
      --pink-shadow: 0 4px 20px rgba(232, 62, 140, 0.3);
      --white: #ffffff;
      --light-gray: #fff9fb;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    body {
      font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-gray);
      color: #555;
      margin: 0;
      padding: 0;
      line-height: 1.6;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 20px;
    }
    
    .dashboard-header {
      text-align: center;
      margin-bottom: 40px;
      position: relative;
    }
    
    .dashboard-header h1 {
      color: var(--dark-pink);
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 10px;
      position: relative;
      display: inline-block;
    }
    
    .dashboard-header h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: var(--pink-gradient);
      border-radius: 2px;
    }
    
    .dashboard-header p {
      color: var(--soft-pink);
      font-size: 1.1rem;
    }
    
    .action-buttons {
      position: absolute;
      right: 0;
      top: 0;
      display: flex;
      gap: 15px;
    }
    
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      margin-bottom: 40px;
    }
    
    .card {
      background: var(--white);
      border-radius: 20px;
      padding: 30px;
      box-shadow: var(--pink-shadow);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      text-align: center;
      border: none;
    }
    
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(232, 62, 140, 0.4);
    }
    
    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: var(--pink-gradient);
    }
    
    .card-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      background: var(--light-pink);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: var(--primary-pink);
      box-shadow: 0 5px 15px rgba(232, 62, 140, 0.2);
    }
    
    .card h3 {
      color: var(--dark-pink);
      margin: 0 0 10px;
      font-size: 1.4rem;
      font-weight: 600;
    }
    
    .card .count {
      font-size: 3rem;
      font-weight: 700;
      color: var(--primary-pink);
      margin: 10px 0;
      display: block;
    }
    
    .card .subtext {
      color: var(--soft-pink);
      font-size: 0.9rem;
    }
    
    /* Beautiful Button Styles */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 12px 24px;
      border-radius: 50px;
      font-weight: 600;
      text-decoration: none;
      transition: var(--transition);
      cursor: pointer;
      border: none;
      font-size: 0.95rem;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn i {
      margin-right: 8px;
      font-size: 1rem;
    }
    
    .btn-pink {
      background: var(--pink-gradient);
      color: white;
      box-shadow: 0 4px 15px rgba(232, 62, 140, 0.3);
    }
    
    .btn-pink:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(232, 62, 140, 0.4);
    }
    
    .btn-pink:active {
      transform: translateY(1px);
    }
    
    .btn-pink::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #ff85a2 0%, #e83e8c 100%);
      opacity: 0;
      transition: var(--transition);
      z-index: -1;
    }
    
    .btn-pink:hover::before {
      opacity: 1;
    }
    
    .btn-outline-pink {
      background: transparent;
      color: var(--primary-pink);
      border: 2px solid var(--primary-pink);
    }
    
    .btn-outline-pink:hover {
      background: var(--primary-pink);
      color: white;
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(232, 62, 140, 0.3);
    }
    
    .btn-sm {
      padding: 8px 16px;
      font-size: 0.85rem;
    }
    
    .btn-lg {
      padding: 15px 30px;
      font-size: 1.1rem;
    }
    
    /* Recent Transactions Section */
    .recent-transactions {
      background: var(--white);
      border-radius: 20px;
      padding: 30px;
      box-shadow: var(--pink-shadow);
      margin-top: 40px;
    }
    
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }
    
    .section-header h2 {
      color: var(--dark-pink);
      font-size: 1.8rem;
      margin: 0;
    }
    
    .transaction-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .transaction-table th {
      background: var(--light-pink);
      color: var(--dark-pink);
      padding: 12px 15px;
      text-align: left;
    }
    
    .transaction-table td {
      padding: 12px 15px;
      border-bottom: 1px solid var(--light-pink);
    }
    
    .transaction-table tr:last-child td {
      border-bottom: none;
    }
    
    .transaction-table tr:hover {
      background-color: rgba(255, 222, 235, 0.3);
    }
    
    .badge {
      display: inline-block;
      padding: 5px 10px;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 600;
    }
    
    .badge-success {
      background: rgba(40, 167, 69, 0.1);
      color: #28a745;
    }
    
    .notification {
      background-color: var(--white);
      color: var(--dark-pink);
      border-left: 4px solid var(--primary-pink);
      padding: 15px 25px;
      margin: 20px auto;
      max-width: 600px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      box-shadow: var(--pink-shadow);
      animation: fadeIn 0.5s ease;
    }
    
    .notification::before {
      content: "\f00c";
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      color: var(--primary-pink);
      margin-right: 15px;
      font-size: 1.2rem;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulse {
      0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(232, 62, 140, 0.4); }
      70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(232, 62, 140, 0); }
      100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(232, 62, 140, 0); }
    }
    
    .pulse {
      animation: pulse 2s infinite;
    }
    
    /* Modern scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: var(--light-pink);
    }
    
    ::-webkit-scrollbar-thumb {
      background: var(--primary-pink);
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <!-- Logout notification -->
  <?php if ($logoutMessage): ?>
    <div class="notification pulse">
      <?= $logoutMessage ?>
    </div>
  <?php endif; ?>

  <!-- Dashboard Content -->
  <div class="container">
    <div class="dashboard-header">
      <h1>Admin Dashboard</h1>
      <p>Selamat datang di panel administrasi</p>
      <div class="action-buttons">
        <button class="btn btn-pink">
          <i class="fas fa-plus"></i> Tambah Data
        </button>
        <button class="btn btn-outline-pink">
          <i class="fas fa-cog"></i> Pengaturan
        </button>
      </div>
    </div>
    
    <div class="dashboard-grid">
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-users"></i>
        </div>
        <h3>Total Vendors</h3>
        <span class="count"><?= $vendorCount ?></span>
        <span class="subtext">Vendor terdaftar</span>
        <button class="btn btn-outline-pink btn-sm" style="margin-top: 15px;">
          <i class="fas fa-list"></i> Lihat Semua
        </button>
      </div>
      
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <h3>Total Transactions</h3>
        <span class="count"><?= $checkoutCount ?></span>
        <span class="subtext">Transaksi berhasil</span>
        <button class="btn btn-outline-pink btn-sm" style="margin-top: 15px;">
          <i class="fas fa-chart-line"></i> Lihat Grafik
        </button>
      </div>
    </div>
    
    <!-- Recent Transactions Section -->
    <div class="recent-transactions">
      <div class="section-header">
        <h2><i class="fas fa-history"></i> Transaksi Terbaru</h2>
        <button class="btn btn-pink btn-sm">
          <i class="fas fa-sync-alt"></i> Refresh
        </button>
      </div>
      
      <table class="transaction-table">
        <thead>
          <tr>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentTransactions)): ?>
            <?php foreach ($recentTransactions as $transaction): ?>
              <tr>
                <td>#<?= substr($transaction['id'], 0, 8) ?></td>
                <td><?= date('d M Y', strtotime($transaction['created_at'])) ?></td>
                <td>Rp <?= number_format($transaction['amount'], 0, ',', '.') ?></td>
                <td><span class="badge badge-success">Berhasil</span></td>
                <td>
                  <button class="btn btn-outline-pink btn-sm">
                    <i class="fas fa-eye"></i> Detail
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align: center;">Tidak ada transaksi terbaru</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php include '../includes/admin_footer.php'; ?>
</body>
</html>