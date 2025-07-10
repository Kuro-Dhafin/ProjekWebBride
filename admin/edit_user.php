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


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  echo "<div class='container'><div class='alert alert-danger'>User tidak ditemukan.</div></div>";
  include '../includes/admin_footer.php';
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $role  = $_POST['role'] ?? '';

  $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
  $stmt->execute([$name, $email, $role, $id]);

  header("Location: manage_users.php?success=updated");
  exit;
}
?>

<div class="container py-4">
  <h2 class="mb-4">Edit User</h2>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama:</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email:</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Role:</label>
      <select name="role" class="form-select" required>
        <option value="client" <?= $user['role'] == 'client' ? 'selected' : '' ?>>Client</option>
        <option value="member" <?= $user['role'] == 'member' ? 'selected' : '' ?>>Member</option>
        <option value="vendor" <?= $user['role'] == 'vendor' ? 'selected' : '' ?>>Vendor</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="manage_users.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include '../includes/admin_footer.php'; ?>
