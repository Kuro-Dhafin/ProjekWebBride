<?php 
include('../partials/header.php'); 
require_once('../includes/db.php');?>

<section class="py-10 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold mb-6 text-center">Photography Vendors</h2>

    <!-- Top Rated Carousel with Arrows -->
    <div class="mb-10 relative w-full overflow-hidden">
      <div id="carousel" class="flex transition-all duration-700 ease-in-out">
        <?php
        $topVendors = [
          ["name" => "Moment Capture", "image" => "https://res.cloudinary.com/dwuwc16mu/image/upload/v1751214431/pexels-minan1398-758898_u9rb5l.jpg", "rating" => 4.9],
          ["name" => "Shutter Bliss", "image" => "https://res.cloudinary.com/dwuwc16mu/image/upload/v1751214684/pexels-jonathanborba-3397027_urbm3c.jpg", "rating" => 4.8],
        ];
        foreach ($topVendors as $v) {
          echo "
          <div class='min-w-full flex-shrink-0 px-4'>
            <div class='bg-gray-100 p-4 rounded-lg shadow'>
              <img src='{$v['image']}' alt='{$v['name']}' class='w-full h-60 object-cover rounded'>
              <h3 class='text-xl font-semibold mt-2 text-center'>{$v['name']}</h3>
              <p class='text-yellow-500 text-center'>Rating: ★ {$v['rating']}</p>
            </div>
          </div>";
        }
        ?>
      </div>

      <!-- Navigation Arrows -->
      <button onclick="prevSlide()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200 z-10">
        ←
      </button>
      <button onclick="nextSlide()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200 z-10">
        →
      </button>
    </div>

    <!-- grid dengan link -->
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $vendors = [
        ["id" => 1, "name" => "Studio Lens"],
        ["id" => 2, "name" => "FotoHolic"],
        ["id" => 3, "name" => "SnapFrame"],
      ];
      foreach ($vendors as $v) {
        echo "
        <a href='vendors_detail.php?id={$v['id']}' class='block border p-4 rounded shadow hover:shadow-lg'>
          <h3 class='text-pink-600 font-bold text-lg'>{$v['name']}</h3>
          <p class='text-sm text-gray-500'>Lihat detail vendor</p>
        </a>
        ";
      }
      ?>
    </div>

  </div>
</section>

<script>
  let currentSlide = 0;
  const totalSlides = <?php echo count($topVendors); ?>;

  function setSlide(index) {
    if (index >= 0 && index < totalSlides) {
      document.getElementById('carousel').style.transform = `translateX(-${index * 100}%)`;
      currentSlide = index;
    }
  }

  function nextSlide() {
    setSlide((currentSlide + 1) % totalSlides);
  }

  function prevSlide() {
    setSlide((currentSlide - 1 + totalSlides) % totalSlides);
  }

  // Inisialisasi posisi slide saat halaman dimuat
  document.addEventListener('DOMContentLoaded', function() {
    setSlide(0);
  });
</script>

<?php include('../partials/footer.php'); ?>
