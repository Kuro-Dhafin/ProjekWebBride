<?php
session_start();
include('partials/header.php');
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold mb-6 text-center text-pink-600">Keranjang Saya</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
      <table class="w-full border rounded shadow mb-6">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="p-4">Nama Vendor</th>
            <th class="p-4">Harga</th>
          </tr>
        </thead>
        <tbody>
            <form action="remove_from_cart.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                <input type="hidden" name="index" value="<?php echo $index; ?>">
                <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
            </form>
          <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item):
              $total += $item['price'];
          ?>
            <tr class="border-t">
              <td class="p-4"><?php echo htmlspecialchars($item['vendor_name']); ?></td>
              <td class="p-4">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="text-right font-bold text-lg text-pink-700 mb-4">
        Total: Rp <?php echo number_format($total, 0, ',', '.'); ?>
      </div>

      <div class="text-right">
        <a href="checkout.php" class="inline-block bg-pink-600 text-white px-6 py-2 rounded hover:bg-pink-700">Checkout</a>
      </div>

    <?php else: ?>
      <p class="text-center text-gray-500">Keranjang Anda kosong.</p>
    <?php endif; ?>
  </div>
</section>

<?php include('partials/footer.php'); ?>
