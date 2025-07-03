<?php
session_start();
require_once 'includes/db.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    switch ($user['role']) {
      case 'admin':
        header("Location: admin/dashboard.php");
        break;
      case 'vendor':
        header("Location: vendor/dashboard.php");
        break;
      case 'client':
      case 'member': // jika ada role 'member' dianggap client
        header("Location: client/dashboard.php");
        break;
      default:
        echo "Role tidak dikenal.";
        exit;
    }
    exit;
  } else {
    echo "Login gagal. Email atau password salah.";
  }
}
?>

<!-- Form login sangat sederhana -->
<form method="POST" action="">
  <label>Email:</label><br>
  <input type="email" name="email" required><br><br>

  <label>Password:</label><br>
  <input type="password" name="password" required><br><br>

  <button type="submit">Login</button>
</form>
