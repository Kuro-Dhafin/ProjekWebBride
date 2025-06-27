<?php include('partials/header.php'); ?>

<section id="vendors" class="py-20 text-center bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold mb-4">Top Vendors</h2>

    <!-- Pilihan Kategori -->
    <div class="flex flex-wrap justify-center gap-4 mt-4 mb-10">
      <a href="vendors_photography.php" class="bg-gray-100 border px-4 py-2 rounded-full text-sm hover:bg-pink-200">Photography</a>
      <a href="vendors_style.php" class="bg-gray-100 border px-4 py-2 rounded-full text-sm hover:bg-pink-200">Wedding Style</a>
      <a href="vendors_venue.php" class="bg-gray-100 border px-4 py-2 rounded-full text-sm hover:bg-pink-200">Venue</a>
    </div>

    <!-- Ringkasan -->
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Dummy Vendor -->
      <div class="border rounded-lg p-6 shadow hover:shadow-lg">
        <h3 class="text-xl font-semibold text-pink-600">Art Lens Studio</h3>
        <p class="text-sm text-gray-500">Category: Photography</p>
        <p class="mt-2 text-gray-700 text-sm">Kami menyediakan jasa dokumentasi pernikahan untuk indoor dan outdoor. </p>
      </div>
      <div class="border rounded-lg p-6 shadow hover:shadow-lg">
        <h3 class="text-xl font-semibold text-pink-600">Sumatra Wedding Hall</h3>
        <p class="text-sm text-gray-500">Category: Venue</p>
        <p class="mt-2 text-gray-700 text-sm">Gedung pernikahan premium untuk adat Sumatera dengan fasilitas lengkap.</p>
      </div>
      <div class="border rounded-lg p-6 shadow hover:shadow-lg">
        <h3 class="text-xl font-semibold text-pink-600">Java Classic Style</h3>
        <p class="text-sm text-gray-500">Category: Wedding Style</p>
        <p class="mt-2 text-gray-700 text-sm">Paket dekorasi dan baju adat pernikahan khas Jawa dengan penata rias profesional.</p>
      </div>
    </div>
  </div>
</section>

<?php include('partials/footer.php'); ?>
