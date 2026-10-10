<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pesanan - Toko Online</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 580px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 8px; margin-bottom: 1rem; }
        .header h3 { margin: 0; }
        .item-list { list-style: none; padding: 0; margin: 0 0 1rem 0; }
        .item-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .total-row { display: flex; justify-content: space-between; font-weight: bold; font-size: 15px; margin: 1rem 0; }
        .buyer-info { margin: 1.5rem 0; font-size: 14px; color: #444; border-top: 1px solid #ccc; padding-top: 1rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 4px; font-weight: bold; font-size: 14px; }
        textarea { width: 100%; padding: 8px; box-sizing: border-box; font-family: inherit; font-size: 14px; }
        button { padding: 10px 20px; cursor: pointer; font-weight: bold; }
        .btn-back { display: block; margin-top: 1rem; color: #2563eb; text-decoration: underline; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Konfirmasi Checkout</h3>
        <a href="{{ route('cart.index') }}" style="color: #2563eb; text-decoration: underline; font-size: 14px;">[ &larr; Keranjang ]</a>
    </div>

    <p style="font-weight: bold; margin-bottom: 8px;">Barang yang akan dibeli:</p>
    <ul class="item-list">
        @foreach($cartItems as $item)
            <li class="item-row">
                <span>{{ $item['nama_barang'] }} (x{{ $item['jumlah'] }})</span>
                <span>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
            </li>
        @endforeach
    </ul>

    <div class="total-row">
        <span>Total Bayar (Ongkir diabaikan):</span>
        <span style="color: #16a34a;">Rp {{ number_format($total, 0, ',', '.') }}</span>
    </div>

    <div class="buyer-info">
        <div><b>Pembeli:</b> {{ $user->nama_lengkap }} ({{ $user->username }})</div>
        <div><b>Email:</b> {{ $user->email }} | <b>No. HP:</b> {{ $user->no_hp ?? '-' }}</div>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div class="form-group">
            <label for="alamat_pengiriman">Alamat Pengiriman *</label>
            <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" required placeholder="Tuliskan alamat tujuan pengiriman lengkap...">{{ old('alamat_pengiriman', $user->alamat) }}</textarea>
        </div>

        <button type="submit">[ Konfirmasi & Selesaikan Pesanan ]</button>
    </form>

    <a href="{{ route('cart.index') }}" class="btn-back">[ Batal & Kembali ke Keranjang ]</a>
</body>
</html>
