<?php
require '../vendor/autoload.php';
require_once '../includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  die("Unauthorized.");
}

$db = new Database();
$conn = $db->getConnection();

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $role = $_POST['role'] ?? '';
  $subject = $_POST['subject'] ?? 'Informasi Transaksi Sunne';
  $message = $_POST['message'] ?? 'Terlampir adalah data transaksi.';

  // Ambil semua email sesuai role
  $stmt = $conn->prepare("SELECT email FROM users WHERE role = ?");
  $stmt->execute([$role]);
  $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

  $attachmentPath = '../generated/transactions.pdf'; // path PDF yang telah dibuat

  foreach ($emails as $email) {
    $mail = new PHPMailer(true);

    try {
      // Pengaturan SMTP (ganti sesuai hosting/emailmu)
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'lizdefliz@gmail.com';
      $mail->Password = 'bqly emha qryc cvgj'; // bisa pakai app password
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('lizdefliz@gmail.com', 'Sunne Admin');
      $mail->addAddress($email);
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $message;

      if (file_exists($attachmentPath)) {
        $mail->addAttachment($attachmentPath);
      }

      $mail->send();
    } catch (Exception $e) {
      echo "Gagal mengirim ke $email: {$mail->ErrorInfo}<br>";
    }
  }

  echo "<div style='padding: 20px; background: #d4edda;'>✅ Email berhasil dikirim ke semua user dengan role <b>$role</b>.</div>";
}
?>

<!-- Form untuk kirim email -->
<form method="POST" style="padding: 30px; max-width: 600px; margin: auto;">
  <h2>Kirim Email ke Semua User</h2>
  <label>Role:</label>
  <select name="role" class="form-control" required>
    <option value="vendor">Vendor</option>
    <option value="client">Client</option>
    <option value="member">Member</option>
  </select>

  <label>Subject:</label>
  <input type="text" name="subject" class="form-control" required value="Informasi Transaksi">

  <label>Pesan:</label>
  <textarea name="message" class="form-control" rows="5">Terlampir adalah data transaksi Anda.</textarea>

  <button type="submit" class="btn btn-success mt-3">Kirim Email</button>
</form>
