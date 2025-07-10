<?php include('../partials/header.php'); ?>

<section id="vendors" class="py-20 bg-pink-50 text-center">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-4xl font-extrabold mb-8 text-pink-700 font-serif tracking-tight">Top Wedding Vendors</h2>

    <!-- Pilihan Kategori -->
    <div class="flex flex-wrap justify-center gap-4 mb-12">
      <a href="vendors_photography.php" class="bg-white border border-pink-300 text-pink-700 font-medium px-5 py-2 rounded-full text-sm hover:bg-pink-100 transition">Photography</a>
      <a href="vendors_style.php" class="bg-white border border-pink-300 text-pink-700 font-medium px-5 py-2 rounded-full text-sm hover:bg-pink-100 transition">Wedding Style</a>
      <a href="vendors_venue.php" class="bg-white border border-pink-300 text-pink-700 font-medium px-5 py-2 rounded-full text-sm hover:bg-pink-100 transition">Venue</a>
    </div>

    <?php
    require_once('../includes/db.php');
    $db = new Database();
    $pdo = $db->getConnection();
    $vendors = [];
    if ($pdo instanceof PDO) {
      $stmt = $pdo->prepare("SELECT * FROM vendors ORDER BY rating DESC, created_at DESC LIMIT 6");
      $stmt->execute();
      $vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
      <?php foreach ($vendors as $vendor): ?>
        <div class="bg-white border border-pink-100 rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group">
          <div class="relative aspect-video overflow-hidden">
            <img src="../uploads/<?= htmlspecialchars($vendor['profile_image']) ?>"
                 alt="<?= htmlspecialchars($vendor['company_name']) ?>"
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
            <span class="absolute top-3 left-3 bg-white text-pink-600 font-semibold text-xs px-3 py-1 rounded-full shadow border border-pink-300">
              Rp <?= number_format($vendor['price'], 0, ',', '.') ?>
            </span>
          </div>
          <div class="p-5 text-left flex flex-col justify-between h-full">
            <div>
              <h3 class="text-xl font-bold text-pink-700"><?= htmlspecialchars($vendor['company_name']) ?></h3>
              <p class="text-sm text-gray-500 mb-1"><?= htmlspecialchars($vendor['service_type']) ?></p>
              <p class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                <svg class="w-4 h-4 text-pink-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2C6.13 2 3 5.13 3 9c0 5.25 7 9 7 9s7-3.75 7-9c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 10 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
                <?= htmlspecialchars($vendor['location']) ?>
              </p>
              <p class="mt-2 text-gray-600 text-sm line-clamp-2">
                <?= htmlspecialchars(mb_strimwidth($vendor['description'], 0, 80, '...')) ?>
              </p>
            </div>
            <div class="mt-4">
              <a href="vendor_detail.php?vid=<?= $vendor['vid'] ?>"
                 class="inline-block px-6 py-2 bg-pink-600 text-white text-sm font-semibold rounded-full shadow hover:bg-pink-700 transition">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (empty($vendors)): ?>
        <div class="col-span-3 text-center text-gray-400">
          Belum ada vendor yang tersedia.
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include('../partials/footer.php'); ?>
