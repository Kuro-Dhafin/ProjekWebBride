  </header>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WedStory Lite</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Custom soft color palette -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            softpeach: '#FFD8C9',
            blush: '#F5C3BC',
            mistyrose: '#F2D7D5',
            paleblush: '#F8E9E9',
            softpink: '#F9C5D1'
          }
        }
      }
    }
  </script>
</head>
<body class="bg-paleblush text-gray-700 font-sans">
  <header class="py-4 bg-gradient-to-r from-softpeach to-blush shadow-sm">
    <div class="container mx-auto flex justify-between items-center px-4">
    <h1 class="text-2xl font-bold text-black font-serif tracking-wider">Sunne Wedding</h1>
      <nav class="space-x-6">
        <a href="index.php" class="text-gray-600 hover:text-white transition-colors duration-300">Home</a>
        <a href="vendors.php" class="text-gray-600 hover:text-white transition-colors duration-300">Vendors</a>
        <a href="cart.php" class="text-gray-600 hover:text-white transition-colors duration-300">Vendors</a>
      </nav>
    </div>
</header>