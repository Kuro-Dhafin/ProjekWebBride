<?php
require_once '../includes/db.php';
require_once '../vendor/autoload.php'; // Autoload DomPDF

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

// Cek role admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

$db = new Database();
$conn = $db->getConnection();

// Ambil data transaksi dari database
$stmt = $conn->prepare("SELECT t.id, t.total, t.status, t.created_at, u.name AS user_name, u.email 
                        FROM transactions t
                        JOIN users u ON t.user_id = u.id
                        ORDER BY t.created_at DESC");
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buat konten HTML untuk PDF
$html = '<h2 style="text-align: center;">Laporan Transaksi</h2>';
$html .= '<table width="100%" border="1" cellpadding="10" cellspacing="0">';
$html .= '<thead>
            <tr>
              <th>ID</th>
              <th>Nama User</th>
              <th>Email</th>
              <th>Total</th>
              <th>Status</th>
              <th>Tanggal</th>
            </tr>
          </thead><tbody>';

foreach ($transactions as $trx) {
  $html .= '<tr>
              <td>' . $trx['id'] . '</td>
              <td>' . htmlspecialchars($trx['user_name']) . '</td>
              <td>' . htmlspecialchars($trx['email']) . '</td>
              <td>Rp ' . number_format($trx['total'], 0, ',', '.') . '</td>
              <td>' . ucfirst($trx['status']) . '</td>
              <td>' . date('d M Y H:i', strtotime($trx['created_at'])) . '</td>
            </tr>';
}

$html .= '</tbody></table>';

// Inisialisasi DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Tampilkan PDF di browser
$dompdf->stream("laporan_transaksi.pdf", ["Attachment" => false]); // true untuk force download
exit;
