<?php
session_start();
include('partials/header.php');
?>

<section class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold mb-6 text-center text-pink-600">Checkout</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
      <table class="w-full border rounded shadow mb-6">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="p-4">Nama Vendor</th>
            <th class="p-4">Harga</th>
          </tr>
        </thead>
        <tbody>
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

      <div class="text-right text-lg font-semibold text-pink-700 mb-4">
        Total Pembayaran: Rp <?php echo number_format($total, 0, ',', '.'); ?>
      </div>

      <form action="finish_checkout.php" method="POST" class="text-right">
        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Konfirmasi & Bayar</button>
      </form>
    <?php else: ?>
      <p class="text-center text-gray-500">Keranjang kosong.</p>
    <?php endif; ?>
  </div>
</section>

<?php include('partials/footer.php'); ?>
