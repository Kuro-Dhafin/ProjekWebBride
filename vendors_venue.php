<?php
include('partials/header.php');
include(__DIR__ . '/includes/db.php');

// Ambil data vendor dengan tipe layanan 'Venue' atau dekorasi venue
try {
    if (!isset($pdo)) {
        throw new Exception('Database connection not established.');
    }
    $stmt = $pdo->prepare("SELECT * FROM vendors WHERE service_type LIKE ? OR service_type LIKE ?");
    $stmt->execute(['%venue%', '%dekorasi%']);
    $vendors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $vendors = [];
    echo '<p class="text-red-500 text-center">Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-extrabold text-center text-pink-700 mb-10 font-serif tracking-wide">Luxury Venue & Decoration</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
      <?php foreach ($vendors as $vendor): ?>
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-pink-100 group hover:shadow-2xl transition">
          <div class="relative">
            <img src="uploads/<?= htmlspecialchars($vendor['profile_image']) ?>" alt="<?= htmlspecialchars($vendor['company_name']) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-pink-900/60 to-transparent opacity-80"></div>
            <span class="absolute top-4 left-4 bg-white/90 text-pink-700 font-bold px-5 py-1 rounded-full text-xs shadow-lg border border-pink-200">Rp <?= number_format($vendor['price'], 0, ',', '.') ?></span>
          </div>
          <div class="p-7 flex flex-col gap-2">
            <h3 class="text-2xl font-extrabold text-pink-700 font-serif mb-1"><?= htmlspecialchars($vendor['company_name']) ?></h3>
            <p class="text-gray-500 text-sm mb-2 flex items-center gap-1">
              <svg class="w-4 h-4 text-pink-400 inline" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2C6.13 2 3 5.13 3 9c0 5.25 7 9 7 9s7-3.75 7-9c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 10 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
              <?= htmlspecialchars($vendor['location']) ?>
            </p>
            <p class="text-xs uppercase text-pink-500 tracking-wider mb-2"><?= htmlspecialchars($vendor['service_type']) ?></p>
            <p class="text-gray-700 text-sm mb-3 italic line-clamp-3"><?= htmlspecialchars(mb_strimwidth($vendor['description'], 0, 100, '...')) ?></p>
            <a href="vendor_detail.php?id=<?= $vendor['id'] ?>" class="mt-2 inline-block px-6 py-2 bg-gradient-to-r from-pink-700 to-pink-400 text-white rounded-full font-semibold shadow hover:from-pink-800 hover:to-pink-500 transition text-center">Lihat Detail</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (empty($vendors)): ?>
      <p class="text-center text-gray-400 mt-12">Belum ada venue atau dekorasi yang tersedia.</p>
    <?php endif; ?>
  </div>
</section>

<?php include('partials/footer.php'); ?>