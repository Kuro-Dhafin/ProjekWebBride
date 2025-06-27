<?php include('partials/header.php'); ?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6 flex flex-col md:flex-row justify-center items-start gap-16">

    <!-- vendor info -->
    <div class="w-full md:w-1/2 flex flex-col items-center text-center">
      <!-- foto profil -->
      <div class="w-36 h-36 rounded-full overflow-hidden border-4 border-pink-500 mb-6 shadow-md">
        <img src="assets/img/dummy1.jpg" alt="Vendor Profile" class="object-cover w-full h-full">
      </div>

      <!-- nama vendor -->
      <h2 class="text-3xl font-bold mb-2">SIRCE VENUE</h2>
      <p class="text-base text-gray-500">📍 SUMATERA BARAT, JAGAKARSA</p>
      <p class="uppercase text-sm text-pink-600 mb-6 tracking-wide">Wedding Vendor</p>

      <!-- teks -->
      <div class="max-w-md">
        <h3 class="font-bold text-lg mb-3 text-gray-700">FILOSOFI SAYA</h3>
        <p class="text-gray-800 leading-relaxed">
          Filosofi saya sebagai fotografer adalah berusaha menjadi jembatan antara klien dan audiens.
          Saya ingin sedekat mungkin dengan visi pribadi.
        </p>
      </div>
    </div>

    <!-- carousel -->
    <div class="w-full md:w-1/3">
      <div class="relative overflow-hidden rounded-lg shadow-lg">
        <div id="miniCarousel" class="flex transition-transform duration-500">
          <img src="assets/img/dummy2.jpg" class="w-full h-72 object-cover flex-shrink-0 rounded">
          <img src="assets/img/dummy3.jpg" class="w-full h-72 object-cover flex-shrink-0 rounded">
          <img src="assets/img/dummy4.jpg" class="w-full h-72 object-cover flex-shrink-0 rounded">
        </div>

        <!-- panah craouselnya -->
        <button onclick="prevMini()" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200">
          &#8592;
        </button>
        <button onclick="nextMini()" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-200">
          &#8594;
        </button>
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
