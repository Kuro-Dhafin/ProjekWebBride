<?php
require_once '../vendor/autoload.php';
require_once '../includes/db.php';

use Dompdf\Dompdf;

$db = new Database();
$conn = $db->getConnection();

// Ambil semua transaksi
$stmt = $conn->prepare("
    SELECT t.*, u.name, u.email 
    FROM transactions t 
    JOIN users u ON t.user_id = u.id
    ORDER BY t.created_at DESC
");
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Siapkan isi HTML untuk PDF
$html = '<h2>Daftar Transaksi</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="6" width="100%">';
$html .= '<thead><tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
          </tr></thead><tbody>';

foreach ($transactions as $i => $tx) {
    $html .= "<tr>
                <td>".($i+1)."</td>
                <td>{$tx['name']}</td>
                <td>{$tx['email']}</td>
                <td>Rp " . number_format($tx['total'], 0, ',', '.') . "</td>
                <td>{$tx['status']}</td>
                <td>{$tx['created_at']}</td>
              </tr>";
}
$html .= '</tbody></table>';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("data_transaksi.pdf", ["Attachment" => false]); // tampilkan langsung di browser
exit;
