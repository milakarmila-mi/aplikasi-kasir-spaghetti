<!-- resources/views/order/confirm.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>…</head>
<body class="…">
  <div class="…">
    <h1 class="…">Pesanan #{{ $order->id }} Berhasil!</h1>
    <p class="…">Total: Rp{{ number_format($order->total, 0, ',', '.') }}</p>

    <div class="mt-4">
      <p>ID Pelanggan: <strong>{{ $order->customer_id }}</strong></p>
      <ul class="mt-2 list-disc list-inside">
        @foreach($order->items as $item)
          <li>{{ $item->quantity }} x {{ $item->product_name }} — Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</li>
        @endforeach
      </ul>
    </div>

    <a href="{{ route('kasir') }}" class="…">Kembali ke Menu</a>
  </div>
</body>
</html>
