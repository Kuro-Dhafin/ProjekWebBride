<?php
require_once '../includes/db.php';
require_once '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

// Hanya admin yang boleh akses
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$db = new Database();
$conn = $db->getConnection();

// Ambil parameter filter tanggal jika ada
$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;

if ($from && $to) {
  $stmt = $conn->prepare("
    SELECT t.id, t.total, t.status, t.created_at, u.name AS user_name, u.email 
    FROM transactions t
    JOIN users u ON t.user_id = u.id
    WHERE t.created_at BETWEEN ? AND ?
    ORDER BY t.created_at DESC
  ");
  $stmt->execute([$from . ' 00:00:00', $to . ' 23:59:59']);
  $title = "Laporan Transaksi dari $from sampai $to";
} else {
  $stmt = $conn->prepare("
    SELECT t.id, t.total, t.status, t.created_at, u.name AS user_name, u.email 
    FROM transactions t
    JOIN users u ON t.user_id = u.id
    ORDER BY t.created_at DESC
  ");
  $stmt->execute();
  $title = "Laporan Semua Transaksi";
}

$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buat HTML
$html = "<h2 style='text-align: center;'>$title</h2><hr>";
$html .= "<table width='100%' border='1' cellpadding='8' cellspacing='0'>";
$html .= "<thead>
  <tr>
    <th>ID</th>
    <th>Nama User</th>
    <th>Email</th>
    <th>Total</th>
    <th>Status</th>
    <th>Tanggal</th>
  </tr>
</thead><tbody>";

foreach ($transactions as $tx) {
  $html .= "<tr>
    <td>{$tx['id']}</td>
    <td>" . htmlspecialchars($tx['user_name']) . "</td>
    <td>" . htmlspecialchars($tx['email']) . "</td>
    <td>Rp " . number_format($tx['total'], 0, ',', '.') . "</td>
    <td>" . ($tx['status'] === 'done' ? 'Selesai' : 'Belum') . "</td>
    <td>" . date('d M Y H:i', strtotime($tx['created_at'])) . "</td>
  </tr>";
}

$html .= "</tbody></table>";

// Generate PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("laporan_transaksi.pdf", ["Attachment" => false]);
exit;
