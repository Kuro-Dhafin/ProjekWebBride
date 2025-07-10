<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

require '../vendor/autoload.php';
require_once '../includes/db.php';
include '../includes/admin_header.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = new Database();
$conn = $db->getConnection();

$role = $_POST['role'] ?? '';
$subject = $_POST['subject'] ?? '';
$body = $_POST['body'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($role, ['vendor', 'client', 'member'])) {
  $stmt = $conn->prepare("SELECT email, name FROM users WHERE role = ?");
  $stmt->execute([$role]);
  $recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'lizdefliz@gmail.com';
    $mail->Password   = 'bqly emha qryc cvgj';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('lizdefliz@gmail.com', 'Sunne Admin');

    foreach ($recipients as $r) {
      $mail->addAddress($r['email'], $r['name']);
    }

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = nl2br($body);

    $mail->send();
    $success = "Email berhasil dikirim ke semua $role.";
  } catch (Exception $e) {
    $error = "Gagal mengirim email: {$mail->ErrorInfo}";
  }
}
?>

<div class="container py-4">
  <h1 class="mb-4">Broadcast Email</h1>

  <?php if (isset($success)): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="role" class="form-label">Kirim ke:</label>
      <select name="role" id="role" class="form-control" required>
        <option value="">-- Pilih --</option>
        <option value="vendor">Vendors</option>
        <option value="client">Clients</option>
        <option value="member">Members</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="subject" class="form-label">Subjek Email:</label>
      <input type="text" name="subject" id="subject" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="body" class="form-label">Isi Pesan:</label>
      <textarea name="body" id="body" class="form-control" rows="6" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Kirim Email</button>
    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include '../includes/admin_footer.php'; ?>
