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

// Handle delete
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role IN ('vendor', 'client', 'member')");
  $stmt->execute([$id]);
  header("Location: manage_users.php?success=deleted");
  exit;
}

// Get all vendors and clients
$stmt = $conn->prepare("SELECT * FROM users WHERE role IN ('vendor', 'client', 'member')");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users & Vendors</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
  <h1 class="mb-4">Manage Users & Vendors</h1>

  <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
    <div class="alert alert-success">User berhasil dihapus.</div>
  <?php endif; ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Image</th>
        <th>Action</th>
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
              <img src="../uploads/<?= $user['profile_image'] ?>" alt="" width="50">
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
          <td>
            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <a href="add_user.php" class="btn btn-success">Tambah User/Vendor</a>
</body>
</html>
<?php include '../includes/admin_footer.php'; ?>