<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
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
        .item-block {
            margin-bottom: 12px;
        }
        .item-name {
            font-weight: bold;
            margin-bottom: 4px;
        }
        .item-calc {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-qty {
            background: none;
            border: none;
            color: #2563eb;
            cursor: pointer;
            font-size: 14px;
            padding: 0 4px;
        }
        .btn-del {
            background: none;
            border: none;
            color: #2563eb;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            margin-left: 8px;
            padding: 0;
        }
        .total-divider {
            border-top: 1px solid #ccc;
            margin: 1rem 0;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 1.5rem;
        }
        .btn-clear {
            background: none;
            border: none;
            color: #2563eb;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            padding: 0;
        }
        .btn-back {
            display: block;
            margin-top: 1rem;
            color: #2563eb;
            text-decoration: underline;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>Keranjang belanja</h3>
        <span style="font-size: 14px; color: #666;">Tanpa login</span>
    </div>

    @if(count($cartItems) > 0)
        @foreach($cartItems as $item)
            <div class="item-block">
                <div class="item-name">{{ $item['nama'] }}</div>
                <div class="item-calc">
                    <div>
                        Rp {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['jumlah'] }} = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>
                    <div class="qty-controls">
                        <form method="POST" action="{{ route('cart.ubah', $item['id']) }}" style="display:inline; margin: 0;">
                            @csrf
                            <input type="hidden" name="aksi" value="kurang">
                            <button type="submit" class="btn-qty">[-]</button>
                        </form>

                        <span>{{ $item['jumlah'] }}</span>

                        <form method="POST" action="{{ route('cart.ubah', $item['id']) }}" style="display:inline; margin: 0;">
                            @csrf
                            <input type="hidden" name="aksi" value="tambah">
                            <button type="submit" class="btn-qty">[+]</button>
                        </form>

                        <form method="POST" action="{{ route('cart.hapus', $item['id']) }}" style="display:inline; margin: 0;">
                            @csrf
                            <button type="submit" class="btn-del">[hps]</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="total-divider"></div>

        <div class="total-row">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <form method="POST" action="{{ route('cart.kosongkan') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-clear">[ Kosongkan keranjang ]</button>
        </form>

        <a href="{{ route('cart.index') }}" class="btn-back">[ Kembali ke daftar barang ]</a>
    @else
        <p style="color: #666;">Keranjang belanja kosong.</p>
        <a href="{{ route('cart.index') }}" class="btn-back">[ Lihat daftar barang ]</a>
    @endif
</body>
</html>
