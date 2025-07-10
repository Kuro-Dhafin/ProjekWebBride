<?php
$base = '/projekWebBride';
include('../partials/header.php');
require_once('../includes/db.php');

$db = new Database();
$pdo = $db->getConnection();

// Ambil hanya gambar vendor, urutkan berdasarkan rating tertinggi lalu harga terendah
$stmt = $pdo->prepare("SELECT profile_image, company_name, rating, price FROM vendors WHERE profile_image IS NOT NULL AND profile_image != '' ORDER BY rating DESC, price ASC");
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-extrabold text-center text-pink-600 mb-10 font-serif tracking-wide">Wedding Gallery</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
      <?php foreach ($images as $img): ?>
        <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden border border-pink-100 group transition">
          <div class="relative">
            <img src="<?= $base ?>/uploads/<?= htmlspecialchars($img['profile_image']) ?>"
                 alt="<?= htmlspecialchars($img['company_name']) ?>"
                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent px-3 py-2">
              <div class="flex justify-between items-center text-xs text-white">
                <span class="font-semibold"><?= htmlspecialchars($img['company_name']) ?></span>
                <span class="bg-pink-600 px-2 py-0.5 rounded-full text-xs font-bold">★ <?= number_format($img['rating'],1) ?></span>
              </div>
              <span class="block text-pink-200 text-xs mt-1">Rp <?= number_format($img['price'], 0, ',', '.') ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      <?php if (empty($images)): ?>
        <div class="col-span-4 text-center text-gray-400">Belum ada foto vendor yang tersedia.</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include('../partials/footer.php'); ?>