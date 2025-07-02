<?php
include('partials/header.php');
include('config/db.php'); // Pastikan ini berisi koneksi ke MySQL

// Ambil vendor_id dari URL
$vendor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query data vendor
$stmt = $pdo->prepare("SELECT * FROM vendors WHERE id = ?");
$stmt->execute([$vendor_id]);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika tidak ada vendor
if (!$vendor) {
    echo "<p class='text-center text-red-500'>Vendor tidak ditemukan.</p>";
    include('partials/footer.php');
    exit;
}

// Ambil galeri vendor
$galeri = $pdo->prepare("SELECT * FROM vendor_gallery WHERE vendor_id = ?");
$galeri->execute([$vendor_id]);
$images = $galeri->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6 flex flex-col md:flex-row justify-center items-start gap-16">

    <!-- Left Column: Vendor Info -->
    <div class="w-full md:w-1/2 flex flex-col items-center text-center">
      <!-- Profile Image -->
      <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-pink-500 mb-6 shadow-md">
        <img src="uploads/<?= htmlspecialchars($vendor['profile_image']) ?>" alt="Vendor Profile" class="object-cover w-full h-full">
      </div>

      <!-- Vendor Name -->
      <h2 class="text-3xl font-bold mb-2"><?= htmlspecialchars($vendor['company_name']) ?></h2>
      <p class="text-base text-gray-500">📍 <?= htmlspecialchars($vendor['location']) ?></p>
      <p class="uppercase text-sm text-pink-600 mb-4 tracking-wide"><?= htmlspecialchars($vendor['service_type']) ?> Vendor</p>

      <!-- Filosofi -->
      <div class="max-w-md mb-6">
        <h3 class="font-bold text-lg mb-3 text-gray-700">FILOSOFI SAYA</h3>
        <p class="text-gray-800 leading-relaxed">
          <?= nl2br(htmlspecialchars($vendor['description'])) ?>
        </p>
      </div>

      <!-- Harga dan Tombol Tambah ke Keranjang -->
      <div class="bg-gray-100 p-4 rounded shadow text-center">
        <p class="text-xl font-bold text-pink-600 mb-2">Rp <?= number_format($vendor['price'], 0, ',', '.') ?></p>
        <form action="/includes/add_to_cart.php" method="POST">
          <input type="hidden" name="vendor_id" value="<?= $vendor['id'] ?>">
          <input type="hidden" name="vendor_name" value="<?= htmlspecialchars($vendor['company_name']) ?>">
          <input type="hidden" name="price" value="<?= $vendor['price'] ?>">
          <button type="submit" class="mt-2 px-6 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">Tambah ke Keranjang</button>
        </form>
        <!-- Edit Button -->
        <a href="vendor_edit.php?id=<?= $vendor['id'] ?>" class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit Vendor</a>
      </div>
    </div>

    <!-- Right Column: Carousel -->
    <div class="w-full md:w-1/3">
      <div class="relative overflow-hidden rounded-lg shadow-lg">
        <div id="miniCarousel" class="flex transition-transform duration-500">
          <?php foreach ($images as $img): ?>
            <img src="uploads/<?= htmlspecialchars($img['image_path']) ?>" class="w-full h-72 object-cover flex-shrink-0 rounded">
          <?php endforeach; ?>
        </div>

        <!-- Arrows -->
        <button onclick="prevMini()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200">&#8592;</button>
        <button onclick="nextMini()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200">&#8594;</button>
      </div>
    </div>

  </div>
</section>

<script>
  let miniIndex = 0;
  function nextMini() {
    const container = document.getElementById('miniCarousel');
    const images = container.children.length;
    miniIndex = (miniIndex + 1) % images;
    container.style.transform = `translateX(-${miniIndex * 100}%)`;
  }
  function prevMini() {
    const container = document.getElementById('miniCarousel');
    const images = container.children.length;
    miniIndex = (miniIndex - 1 + images) % images;
    container.style.transform = `translateX(-${miniIndex * 100}%)`;
  }
</script>

<?php include('partials/footer.php'); ?>
