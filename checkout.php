<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $data = json_decode($_POST['orderData'], true);
  $method = $_POST['method'];

  // Baca nomor terakhir dari file counter.txt
  $counterFile = 'counter.txt';
  if (!file_exists($counterFile)) {
    file_put_contents($counterFile, '0');
  }

  $lastNumber = (int)file_get_contents($counterFile);
  $transactionId = $lastNumber + 1;

  // Simpan nomor baru ke file
  file_put_contents($counterFile, $transactionId);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Pembayaran</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #ffe9e4;
      padding: 30px;
    }
    .receipt {
      max-width: 400px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #6d4c41;
      margin-bottom: 0;
    }
    .store-info {
      text-align: center;
      font-size: 0.9em;
      white-space: pre-wrap;
      color: #444;
      margin-bottom: 15px;
    }
    .item {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px dotted #999;
      padding: 5px 0;
    }
    .note {
      font-size: 0.9em;
      color: #555;
      margin-left: 10px;
    }
    .total {
      font-weight: bold;
      text-align: right;
      margin-top: 15px;
    }
    .thanks {
      text-align: center;
      margin-top: 25px;
      color: #6d4c41;
    }
    .qris-section {
      text-align: center;
      margin-top: 20px;
    }
    .qris-section img {
      max-width: 200px;
      margin-top: 10px;
    }
    .transaction-id {
      font-size: 0.9em;
      color: #444;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="receipt">
    <?php
      echo "<h2>HIME NO COFFEE</h2>";
      echo "<div class='store-info'>Jl. Peta Barat, Kalideres\nJakarta Barat\nTelp: 0813-1770-3715\n" . date('Y-m-d H:i:s') . "</div>";
    ?>

    <div class="transaction-id">Nomor Transaksi: <strong><?= $transactionId ?></strong></div>
    <p>Metode Pembayaran: <strong><?= htmlspecialchars($method) ?></strong></p>
    <hr>

    <?php
      $total = 0;
      foreach ($data as $item) {
       
        echo '<div class="item">';
        echo '<span>' . htmlspecialchars($item["item"]) . '</span>';
        echo '<span>Rp ' . number_format($item["price"], 0, ',', '.') . '</span>';
        echo '</div>';
        if (!empty($item["note"])) {
          echo '<div class="note">* ' . htmlspecialchars($item["note"]) . '</div>';
        }
        $total += $item["price"];
      }
    ?>
    <div class="total">Total: Rp <?= number_format($total, 0, ',', '.') ?></div>

    <?php if (strtolower($method) === 'kasir'): ?>
    <div class="thanks" style="margin-top: 20px; font-weight: bold;">
        Tunjukkan struk ini ke kasir Untuk Melakukan Pembayaran.
    </div>
    <?php endif; ?>

    <?php if (strtolower($method) === 'qris'): ?>
    <div class="qris-section">
      <p>Silakan scan QRIS berikut untuk pembayaran:</p>
      <img src="image/qris.jpg" alt="QRIS Code">
    </div>
    <?php endif; ?>

    <div class="thanks">Terima kasih telah memesan! ☕</div>
    <div style="text-align: center; margin-top: 20px;">
    <a href="index.html" style="text-decoration: none;">
        <button style="padding: 10px 20px; background-color: #6d4c41; color: white; border: none; border-radius: 6px; cursor: pointer;">
        Kembali ke Beranda
    </button>
    </a>
    </div>
</body>
</html>
