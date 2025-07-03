<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

require_once '../includes/db.php';
$db = new Database();
$conn = $db->getConnection();

// Handle delete
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role IN ('vendor', 'client', 'member')");
  $stmt->execute([$id]);
  header("Location: manage_users.php?success=deleted");
  exit;
}

// Handle search
$keyword = $_GET['search'] ?? '';
$query = "SELECT * FROM users WHERE role IN ('vendor', 'client', 'member')";
$params = [];

if (!empty($keyword)) {
  $query .= " AND (name LIKE :kw OR email LIKE :kw OR role LIKE :kw)";
  $params[':kw'] = '%' . $keyword . '%';
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/admin_header.php';
?>

<div class="container py-5">
  <h1 class="mb-4">Manage Users & Vendors</h1>

  <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
    <div class="alert alert-success">User berhasil dihapus.</div>
  <?php endif; ?>

  <form method="GET" class="mb-3">
    <div class="input-group">
      <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau role..." value="<?= htmlspecialchars($keyword) ?>">
      <button class="btn btn-outline-secondary" type="submit">Cari</button>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-success">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Image</th>
          <th style="width: 150px;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $i => $user): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
              <?php if ($user['profile_image']): ?>
                <img src="../uploads/<?= $user['profile_image'] ?>" alt="Foto" class="img-thumbnail" width="50">
              <?php else: ?>
                <span class="text-muted">-</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="?delete=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">
                <i class="fas fa-trash-alt"></i> Hapus
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <a href="add_user.php" class="btn btn-success mt-3">
    <i class="fas fa-plus-circle"></i> Tambah User/Vendor
  </a>
</div>

<?php include '../includes/admin_footer.php'; ?>
