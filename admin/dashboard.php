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

// Get recent transactions
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css ">
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

    /* Button Styles */
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

    /* Chart & Stats Styles */
    .chart-container {
      background: var(--white);
      border-radius: 20px;
      padding: 30px;
      box-shadow: var(--pink-shadow);
      margin-top: 40px;
      position: relative;
    }

    .chart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .chart-placeholder {
      height: 300px;
      background: var(--light-pink);
      border-radius: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--dark-pink);
      font-weight: 600;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .stat-card {
      background: var(--white);
      padding: 20px;
      border-radius: 15px;
      box-shadow: var(--pink-shadow);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .stat-icon {
      width: 50px;
      height: 50px;
      background: var(--light-pink);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary-pink);
      font-size: 1.2rem;
    }

    .stat-content h4 {
      margin: 0;
      color: var(--dark-pink);
      font-size: 1rem;
    }

    .stat-content p {
      margin: 5px 0 0;
      color: var(--primary-pink);
      font-size: 1.5rem;
      font-weight: 700;
    }

    .transaction-status {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .status-badge {
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .status-success {
      background: rgba(40, 167, 69, 0.1);
      color: #28a745;
    }

    .status-pending {
      background: rgba(255, 193, 7, 0.1);
      color: #ffc107;
    }

    .status-failed {
      background: rgba(220, 53, 69, 0.1);
      color: #dc3545;
    }

    .view-all {
      text-align: center;
      margin-top: 20px;
    }

    /* Recent Transactions Table */
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    table.transaction-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: var(--pink-shadow);
    }

    table.transaction-table thead {
      background: var(--light-pink);
    }

    table.transaction-table th,
    table.transaction-table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    table.transaction-table tbody tr:hover {
      background: var(--light-pink);
    }

    .badge {
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .badge-success {
      background: rgba(40, 167, 69, 0.1);
      color: #28a745;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="dashboard-header">
      <h1>Admin Dashboard</h1>
      <p>Selamat datang di panel administrasi</p>
    </header>

    <section class="dashboard-grid">
      <div class="card">
        <div class="card-icon"><i class="fas fa-store"></i></div>
        <h3>Total Vendors</h3>
        <span class="count"><?= htmlspecialchars($vendorCount); ?></span>
        <p class="subtext">Jumlah vendor aktif</p>
      </div>
      <div class="card">
        <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
        <h3>Total Transaksi</h3>
        <span class="count"><?= htmlspecialchars($checkoutCount); ?></span>
        <p class="subtext">Transaksi sejak awal</p>
      </div>
    </section>

    <!-- Sales Chart Section -->
    <div class="chart-container">
      <div class="chart-header">
        <h2><i class="fas fa-chart-line"></i> Sales Overview</h2>
        <div class="transaction-status">
          <span class="status-badge status-success">Completed: 24</span>
          <span class="status-badge status-pending">Pending: 5</span>
          <span class="status-badge status-failed">Failed: 2</span>
        </div>
      </div>
      <div class="chart-placeholder">
        [Sales Chart Visualization Would Appear Here]
      </div>
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-wallet"></i></div>
          <div class="stat-content">
            <h4>Total Revenue</h4>
            <p>Rp 12,450,000</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
          <div class="stat-content">
            <h4>This Month</h4>
            <p>Rp 3,250,000</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-percentage"></i></div>
          <div class="stat-content">
            <h4>Conversion</h4>
            <p>72%</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
          <div class="stat-content">
            <h4>New Customers</h4>
            <p>18</p>
          </div>
        </div>
      </div>
    </div>



        </button>
      </div>
    </div>
  </div>

  <?php include '../includes/admin_footer.php'; ?>

  <!-- Chart.js Script -->
  <script src=" https://cdn.jsdelivr.net/npm/chart.js "></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.createElement('canvas');
      ctx.height = 300;
      document.querySelector('.chart-placeholder').innerHTML = '';
      document.querySelector('.chart-placeholder').appendChild(ctx);
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Monthly Sales',
            data: [4500000, 5200000, 4800000, 6100000, 5900000, 6800000],
            backgroundColor: 'rgba(232, 62, 140, 0.1)',
            borderColor: '#e83e8c',
            borderWidth: 2,
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { position: 'top' },
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function (value) {
                  return 'Rp ' + value.toLocaleString();
                }
              }
            }
          }
        }
      });
    });
  </script>
</body>
</html>