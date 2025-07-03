<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

require_once '../includes/db.php';
include '../includes/admin_header.php';

$db = new Database();
$conn = $db->getConnection();

// Ambil semua transaksi
$stmt = $conn->prepare("
  SELECT transactions.*, users.name AS user_name 
  FROM transactions 
  JOIN users ON transactions.user_id = users.id 
  ORDER BY transactions.created_at DESC
");
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
  <h1 class="mb-4">📦 Semua Transaksi</h1>

  <!-- Export All Button -->
  <a href="export_transactions.php" class="btn btn-danger mb-3" target="_blank">
    <i class="fas fa-file-pdf"></i> Export PDF Semua Transaksi
  </a>

  <!-- Export by Date -->
  <form action="export_transactions.php" method="GET" class="row g-2 mb-4">
    <div class="col-auto">
      <label for="from" class="form-label">Dari</label>
      <input type="date" name="from" id="from" class="form-control" required>
    </div>
    <div class="col-auto">
      <label for="to" class="form-label">Sampai</label>
      <input type="date" name="to" id="to" class="form-control" required>
    </div>
    <div class="col-auto align-self-end">
      <button type="submit" class="btn btn-outline-danger">
        <i class="fas fa-file-pdf"></i> Export Berdasarkan Tanggal
      </button>
    </div>
  </form>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Total (Rp)</th>
        <th>Status</th>
        <th>Dibuat Pada</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($transactions as $tx): ?>
        <tr>
          <td><?= $tx['id'] ?></td>
          <td><?= htmlspecialchars($tx['user_name']) ?></td>
          <td>Rp<?= number_format($tx['total'], 0, ',', '.') ?></td>
          <td>
            <?php if ($tx['status'] === 'done'): ?>
              <span class="badge bg-success">Selesai</span>
            <?php else: ?>
              <span class="badge bg-warning text-dark">Belum Selesai</span>
            <?php endif; ?>
          </td>
          <td><?= date('d M Y H:i', strtotime($tx['created_at'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
