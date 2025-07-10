<?php
session_start();
$base = '/projekWebBride';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WedStory Lite</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
  <header class="py-4 bg-gradient-to-r from-softpeach to-blush shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-4">
      <div class="flex items-center gap-3">
        <img src="https://res.cloudinary.com/dwuwc16mu/image/upload/v1751458620/w_ag1gxp.png" alt="Logo" class="w-10 h-10 rounded-full shadow-md border-2 border-pink-300 bg-white">
        <span class="text-2xl font-extrabold text-pink-600 font-serif tracking-wider drop-shadow">WedStory</span>
      </div>
      <nav class="space-x-6 flex items-center">
        <a href="<?= $base ?>/index.php" class="text-gray-600 hover:text-pink-600 font-semibold transition-colors duration-300">Home</a>
        <?php if (isset($_SESSION['user'])): ?>
          <span class="ml-4 px-4 py-1 bg-white rounded-full text-pink-600 font-semibold shadow border border-pink-200">
            <?= htmlspecialchars($_SESSION['user']['name'] ?? $_SESSION['user']['email']) ?>
          </span>
          <a href="<?= $base ?>/logout.php" class="ml-2 px-4 py-1 bg-pink-600 text-white rounded-full font-semibold shadow hover:bg-pink-700 transition">Logout</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
