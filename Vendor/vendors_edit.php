<?php
include('../partials/header.php');
include('../includes/db.php');


$db  = new Database();
$pdo = $db->getConnection();

// Ambil vendor_id dari URL
$vendor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query data vendor
$stmt = $pdo->prepare("SELECT * FROM vendors WHERE id = ?");
$stmt->execute([$vendor_id]);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vendor) {
    echo "<p class='text-center text-red-500'>Vendor tidak ditemukan.</p>";
    include('../partials/footer.php');
    exit;
}
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6 max-w-xl">
    <h2 class="text-2xl font-bold mb-6 text-center">Edit Vendor</h2>
    <form action="vendor_edit_process.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="id" value="<?= $vendor['id'] ?>">

      <label class="block text-gray-700">Nama Vendor</label>
      <input type="text" name="company_name" value="<?= htmlspecialchars($vendor['company_name']) ?>" class="w-full border rounded px-3 py-2" required>

      <label class="block text-gray-700">Lokasi</label>
      <input type="text" name="location" value="<?= htmlspecialchars($vendor['location']) ?>" class="w-full border rounded px-3 py-2" required>

      <label class="block text-gray-700">Tipe Layanan</label>
      <input type="text" name="service_type" value="<?= htmlspecialchars($vendor['service_type']) ?>" class="w-full border rounded px-3 py-2" required>

      <label class="block text-gray-700">Deskripsi</label>
      <textarea name="description" class="w-full border rounded px-3 py-2" rows="4" required><?= htmlspecialchars($vendor['description']) ?></textarea>

      <label class="block text-gray-700">Harga</label>
      <input type="number" name="price" value="<?= htmlspecialchars($vendor['price']) ?>" class="w-full border rounded px-3 py-2" required>

      <label class="block text-gray-700">Foto Profil (biarkan kosong jika tidak ingin ganti)</label>
      <input type="file" name="profile_image" class="w-full border rounded px-3 py-2">

      <button type="submit" class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700">Simpan Perubahan</button>
    </form>
  </div>
</section>

<?php
include('../partials/footer.php');
?>
