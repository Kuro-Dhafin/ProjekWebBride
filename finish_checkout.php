<?php
session_start();

// Bersihkan keranjang
unset($_SESSION['cart']);

include('partials/header.php');
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-green-600 mb-4">Transaksi Berhasil!</h2>
    <p class="text-gray-700 mb-6">Terima kasih telah menggunakan layanan kami.</p>
    <a href="index.php" class="px-6 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">Kembali ke Beranda</a>
  </div>
</section>

<?php include('partials/footer.php'); ?>
