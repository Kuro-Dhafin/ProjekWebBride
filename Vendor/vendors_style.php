<?php
include('../partials/header.php');
require_once('../includes/db.php');

$db = new Database();
$pdo = $db->getConnection();
$vendors = [];

// Check connection
if (!$pdo) {
    die("Koneksi ke database gagal.");
}

// Get wedding vendors sorted by rating (highest first)
$stmt = $pdo->prepare("SELECT * FROM vendors 
                      WHERE service_type LIKE ? 
                      ORDER BY rating DESC, created_at DESC");
$stmt->execute(['%Wedding%']);
$vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-extrabold text-center text-pink-600 mb-10 font-serif tracking-wide">Exclusive Wedding Gallery</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      <?php foreach ($vendors as $vendor): ?>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition group border border-pink-100">
          <div class="relative">
            <img src="uploads/<?= htmlspecialchars($vendor['profile_image']) ?>" 
                 alt="<?= htmlspecialchars($vendor['company_name']) ?>" 
                 class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-pink-700/60 to-transparent opacity-70"></div>
            <span class="absolute top-4 left-4 bg-white/80 text-pink-600 font-semibold px-4 py-1 rounded-full text-xs shadow">
              Rp <?= number_format($vendor['price'], 0, ',', '.') ?>
            </span>
            <?php if ($vendor['rating']): ?>
              <span class="absolute top-4 right-4 bg-white/80 text-pink-600 font-semibold px-4 py-1 rounded-full text-xs shadow flex items-center">
                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <?= number_format($vendor['rating'], 1) ?>
              </span>
            <?php endif; ?>
          </div>
          <div class="p-6 flex flex-col gap-2">
            <h3 class="text-xl font-bold text-pink-700 font-serif"><?= htmlspecialchars($vendor['company_name']) ?></h3>
            <p class="text-gray-500 text-sm mb-2 flex items-center gap-1">
              <svg class="w-4 h-4 text-pink-400 inline" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2C6.13 2 3 5.13 3 9c0 5.25 7 9 7 9s7-3.75 7-9c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 10 6a2.5 2.5 0 0 1 0 5.5z"/>
              </svg>
              <?= htmlspecialchars($vendor['location']) ?>
            </p>
            <p class="text-xs uppercase text-pink-500 tracking-wider"><?= htmlspecialchars($vendor['service_type']) ?></p>
            <p class="text-gray-700 text-sm line-clamp-3"><?= htmlspecialchars(mb_strimwidth($vendor['description'], 0, 90, '...')) ?></p>
            <a href="vendor_detail.php?vid=<?= $vendor['vid'] ?>">Lihat Detail</a>
            <a href="vendor_edit.php?id=<?= $vendor['id'] ?>">Edit Vendor</a>
          </div>
        </div>
        
      <?php endforeach; ?>
    </div>
    <?php if (empty($vendors)): ?>
      <p class="text-center text-gray-400 mt-12">Belum ada vendor wedding yang tersedia.</p>
    <?php endif; ?>
  </div>
</section>

<?php include('../partials/footer.php'); ?>