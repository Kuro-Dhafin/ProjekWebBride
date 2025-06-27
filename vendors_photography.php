<?php include('partials/header.php'); ?>

<section class="py-10 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold mb-6 text-center">Photography Vendors</h2>

    <!-- Top Rated Carousel with Arrows -->
    <div class="mb-10 relative w-full overflow-hidden">
      <!-- Slider -->
      <div id="carousel" class="flex transition-all duration-700 ease-in-out">
        <?php
        $topVendors = [
          ["name" => "Moment Capture", "image" => "assets/img/dummy1.jpg", "rating" => 4.9],
          ["name" => "Shutter Bliss", "image" => "assets/img/dummy2.jpg", "rating" => 4.8],
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
        &#8592;
      </button>
      <button onclick="nextSlide()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200 z-10">
        &#8594;
      </button>

      <!-- Dots -->
      <div class="flex justify-center mt-3 space-x-2">
        <button onclick="setSlide(0)" class="w-3 h-3 rounded-full bg-gray-400"></button>
        <button onclick="setSlide(1)" class="w-3 h-3 rounded-full bg-orange-500"></button>
      </div>
    </div>

    <!-- Vendor Grid with Popup -->
    <div class="grid md:grid-cols-3 gap-6">
      <?php
      $vendors = [
        ["id" => 1, "name" => "Studio Lens", "rating" => 4.5, "contact" => "081234567890", "testimoni" => "Foto bagus dan cepat."],
        ["id" => 2, "name" => "FotoHolic", "rating" => 4.4, "contact" => "089876543210", "testimoni" => "Hasil memuaskan."],
        ["id" => 3, "name" => "SnapFrame", "rating" => 4.6, "contact" => "082345678901", "testimoni" => "Profesional dan ramah."],
      ];
      foreach ($vendors as $v) {
        echo "
        <div onclick='showPopup({$v['id']})' class='cursor-pointer border p-4 rounded shadow hover:shadow-lg'>
          <h3 class='text-pink-600 font-bold text-lg'>{$v['name']}</h3>
          <p class='text-sm text-gray-500'>Click for more info</p>
        </div>

        <!-- Hidden Popup -->
        <div id='popup-{$v['id']}' class='hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50'>
          <div class='bg-white p-6 rounded-lg w-96 relative'>
            <button onclick='hidePopup({$v['id']})' class='absolute top-2 right-4 text-xl'>&times;</button>
            <h3 class='text-2xl font-bold text-pink-600 mb-2'>{$v['name']}</h3>
            <p class='text-yellow-500'>Rating: ★ {$v['rating']}</p>
            <p class='text-gray-700'>Contact: <span class='text-blue-500'>{$v['contact']}</span></p>
            <p class='italic mt-2'>“{$v['testimoni']}”</p>
          </div>
        </div>
        ";
      }
      ?>
    </div>
  </div>
</section>

<!-- JavaScript for Carousel & Popup -->
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
    currentSlide = (currentSlide + 1) % totalSlides;
    setSlide(currentSlide);
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    setSlide(currentSlide);
  }

  function showPopup(id) {
    document.getElementById('popup-' + id).classList.remove('hidden');
  }

  function hidePopup(id) {
    document.getElementById('popup-' + id).classList.add('hidden');
  }
</script>

<?php include('partials/footer.php'); ?>
