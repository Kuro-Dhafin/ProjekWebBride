<section id="home" class="relative h-screen flex items-center justify-center text-center bg-mistyrose overflow-hidden">
  <!-- Background Decoration -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-20 left-20 w-32 h-32 rounded-full bg-softpink animate-float"></div>
    <div class="absolute bottom-20 right-20 w-40 h-40 rounded-full bg-blush animate-float-delay"></div>
  </div>

  <!-- Main Container -->
  <div class="relative z-10 w-full max-w-4xl px-6 lg:px-8">

  
    <!-- Hero Content -->
    <div class="mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-700 mb-6 font-serif leading-tight">
        Find Your Perfect Wedding Vendor
      </h2>
      <p class="text-gray-600 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
        Elegant. Professional. Trusted.
      </p>
      
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <button id="exploreBtn"
           class="px-8 py-3.5 rounded-full bg-blush text-white hover:bg-softpink 
                  transition-all duration-300 text-lg font-medium shadow-md hover:shadow-lg">
          Explore Vendors
        </button>
        <a href="#about" 
           class="px-8 py-3.5 rounded-full border-2 border-blush text-blush hover:bg-blush hover:text-white 
                  transition-all duration-300 text-lg font-medium shadow-sm hover:shadow-md">
          Learn More
        </a>
      </div>

      <!-- Hidden Auth Options (Shown when Explore is clicked) -->
      <div id="authOptions" class="hidden mt-8 space-y-4 max-w-xs mx-auto">
        <a href="login.php" 
           class="block w-full px-6 py-3 text-center rounded-full border-2 border-blush text-blush hover:bg-blush hover:text-white 
                  transition-all duration-300 font-medium">
           Login
        </a>
        <a href="register.php" 
           class="block w-full px-6 py-3 text-center rounded-full bg-blush text-white hover:bg-softpink 
                  transition-all duration-300 font-medium">
           Register
        </a>
        <p class="text-center text-gray-500 text-sm">
            or <a href="#vendors" class="text-blush underline">continue as guest</a>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
              const guestLink = document.querySelector('a[href="#vendors"]');
              if (guestLink) {
              guestLink.addEventListener('click', function(e) {
                e.preventDefault();
                const vendorsSection = document.getElementById('vendors');
                if (vendorsSection) {
                vendorsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
              });
              }
            });
            </script>
        </p>
      </div>
    </div>

    <!-- Stats Counter -->
    <div class="bg-white/80 backdrop-blur-sm rounded-full p-5 shadow-sm max-w-2xl mx-auto">
      <div class="flex flex-col sm:flex-row justify-around gap-4">
        <div class="px-4">
          <div class="text-2xl md:text-3xl font-bold text-blush">500+</div>
          <div class="text-gray-600 text-sm md:text-base">Vendors</div>
        </div>
        <div class="px-4">
          <div class="text-2xl md:text-3xl font-bold text-blush">98%</div>
          <div class="text-gray-600 text-sm md:text-base">Satisfaction</div>
        </div>
        <div class="px-4">
          <div class="text-2xl md:text-3xl font-bold text-blush">10K+</div>
          <div class="text-gray-600 text-sm md:text-base">Weddings</div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
    .animate-float-delay {
      animation: float 6s ease-in-out 1s infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const exploreBtn = document.getElementById('exploreBtn');
      const authOptions = document.getElementById('authOptions');

      exploreBtn.addEventListener('click', function() {
        // Toggle the auth options
        authOptions.classList.toggle('hidden');
        
        // Smooth scroll to center the view
        if (!authOptions.classList.contains('hidden')) {
          authOptions.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
    });
  </script>
</section>