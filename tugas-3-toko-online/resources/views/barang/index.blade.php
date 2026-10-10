<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Alat Tulis</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 2rem;
            max-width: 480px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            margin-bottom: 1rem;
        }
        .header h3 {
            margin: 0;
        }
        .cart-link {
            text-decoration: none;
            color: #2563eb;
            font-size: 14px;
        }
        .item-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }
        .item-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .item-img {
            color: #666;
            font-size: 13px;
        }
        .btn-add {
            background: none;
            border: none;
            color: #2563eb;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Toko Alat Tulis</h3>
        <a href="{{ route('cart.keranjang') }}" class="cart-link">[ Keranjang ({{ $totalItems }}) ]</a>
    </div>

    <p style="margin-top: 0; font-weight: bold;">Daftar barang</p>

    <ul class="item-list">
        @foreach($barangs as $item)
            <li class="item-row">
                <div class="item-info">
                    @if($item->gambar)
                        <img src="{{ asset('images/' . $item->gambar) }}" alt="{{ $item->nama }}" style="width: 44px; height: 44px; object-fit: contain; vertical-align: middle;">
                    @else
                        <span class="item-img">[img]</span>
                    @endif
                    <span>{{ $item->nama }}</span>
                    <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                </div>
                <div>
                    <form method="POST" action="{{ route('cart.tambah', $item->id) }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-add">[Masukkan ke krj]</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</body>
</html>
