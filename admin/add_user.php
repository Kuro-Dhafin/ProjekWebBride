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
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $image = null;

  if (!empty($_FILES['profile_image']['name'])) {
    $targetDir = '../uploads/';
    $image = basename($_FILES['profile_image']['name']);
    move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetDir . $image);
  }

  $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, profile_image) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$name, $email, $password, $role, $image]);
  $success = 'User berhasil ditambahkan!';
}
?>

<div class="container py-5">
  <h2 class="mb-4">Tambah User/Vendor</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nama</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <select name="role" class="form-control" required>
        <option value="">-- Pilih Role --</option>
        <option value="vendor">Vendor</option>
        <option value="client">Client</option>
        <option value="member">Member</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Foto Profil (opsional)</label>
      <input type="file" name="profile_image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="manage_users.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include '../includes/admin_footer.php'; ?>
