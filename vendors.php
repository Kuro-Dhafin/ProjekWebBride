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
      <!-- Dummy Vendor 1 -->
      <div class="border rounded-lg p-6 shadow hover:shadow-lg flex items-end" style="background-image: url('https://res.cloudinary.com/dwuwc16mu/image/upload/v1751419573/pexels-alex-andrews-271121-821749_b6ectp.jpg'); background-size: cover; background-position: center; min-height: 220px;">
        <div class="bg-white bg-opacity-80 p-4 rounded w-full">
          <h3 class="text-xl font-semibold text-pink-600">Art Lens Studio</h3>
          <p class="text-sm text-gray-500">Category: Photography</p>
          <p class="mt-2 text-gray-700 text-sm">Kami menyediakan jasa dokumentasi pernikahan untuk indoor dan outdoor. </p>
        </div>
      </div>
      <!-- Dummy Vendor 2 -->
      <div class="border rounded-lg p-6 shadow hover:shadow-lg flex items-end" style="background-image: url('https://res.cloudinary.com/dwuwc16mu/image/upload/v1751214684/pexels-vireshstudio-2060240_pcv7as.jpg'); background-size: cover; background-position: center; min-height: 220px;">
        <div class="bg-white bg-opacity-80 p-4 rounded w-full">
          <h3 class="text-xl font-semibold text-pink-600">Sumatra Wedding Hall</h3>
          <p class="text-sm text-gray-500">Category: Venue</p>
          <p class="mt-2 text-gray-700 text-sm">Gedung pernikahan premium untuk adat Sumatera dengan fasilitas lengkap.</p>
        </div>
      </div>
      <!-- Dummy Vendor 3 -->
      <div class="border rounded-lg p-6 shadow hover:shadow-lg flex items-end" style="background-image: url('https://res.cloudinary.com/dwuwc16mu/image/upload/v1751214680/pexels-mkvisuals-2781104_vkt7ll.jpg'); background-size: cover; background-position: center; min-height: 220px;">
        <div class="bg-white bg-opacity-80 p-4 rounded w-full">
          <h3 class="text-xl font-semibold text-pink-600">Java Classic Style</h3>
          <p class="text-sm text-gray-500">Category: Wedding Style</p>
          <p class="mt-2 text-gray-700 text-sm">Paket dekorasi dan baju adat pernikahan khas Jawa dengan penata rias profesional.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('partials/footer.php'); ?>
