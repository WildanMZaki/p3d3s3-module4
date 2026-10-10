<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Online</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 580px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 8px; margin-bottom: 1rem; }
        .header h3 { margin: 0; }
        .alert-error { color: #dc2626; margin-bottom: 1rem; font-size: 14px; }
        .alert-success { color: #16a34a; margin-bottom: 1rem; font-size: 14px; }
        .item-block { margin-bottom: 14px; }
        .item-name { font-weight: bold; margin-bottom: 4px; }
        .item-calc { display: flex; justify-content: space-between; align-items: center; font-size: 14px; }
        .qty-controls { display: flex; align-items: center; gap: 6px; }
        .btn-qty { background: none; border: none; color: #2563eb; cursor: pointer; font-size: 14px; padding: 0 4px; }
        .btn-qty:disabled { color: #ccc; cursor: not-allowed; }
        .btn-del { background: none; border: none; color: #dc2626; cursor: pointer; text-decoration: underline; font-size: 14px; margin-left: 8px; padding: 0; }
        .total-divider { border-top: 1px solid #ccc; margin: 1rem 0; }
        .total-row { display: flex; justify-content: space-between; font-weight: bold; font-size: 15px; margin-bottom: 1.5rem; }
        .actions { display: flex; justify-content: space-between; align-items: center; }
        .btn-checkout { color: #16a34a; text-decoration: underline; font-weight: bold; font-size: 15px; }
        .btn-clear { background: none; border: none; color: #dc2626; cursor: pointer; text-decoration: underline; font-size: 14px; padding: 0; }
        .btn-back { display: block; margin-top: 1rem; color: #2563eb; text-decoration: underline; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Keranjang belanja</h3>
        <span style="font-size: 14px; color: #666;">Pembeli: <b>{{ Auth::user()->nama_lengkap }}</b></span>
    </div>

    @if(session('error'))
        <div class="alert-error">[ {{ session('error') }} ]</div>
    @endif
    @if(session('success'))
        <div class="alert-success">[ {{ session('success') }} ]</div>
    @endif

    @if(count($cartItems) > 0)
        @foreach($cartItems as $item)
            <div class="item-block">
                <div class="item-name">{{ $item['nama_barang'] }} <small style="color: #888;">(Stok: {{ $item['stok'] }})</small></div>
                <div class="item-calc">
                    <div>
                        Rp {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['jumlah'] }} = 
                        <b>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</b>
                    </div>
                    <div class="qty-controls">
                        <form method="POST" action="{{ route('cart.ubah', $item['id_barang']) }}" style="display:inline; margin: 0;">
                            @csrf
                            <input type="hidden" name="aksi" value="kurang">
                            <button type="submit" class="btn-qty">[-]</button>
                        </form>

                        <span>{{ $item['jumlah'] }}</span>

                        <form method="POST" action="{{ route('cart.ubah', $item['id_barang']) }}" style="display:inline; margin: 0;">
                            @csrf
                            <input type="hidden" name="aksi" value="tambah">
                            <button type="submit" class="btn-qty" {{ $item['jumlah'] >= $item['stok'] ? 'disabled title="Maksimal stok tercapai"' : '' }}>[+]</button>
                        </form>

                        <form method="POST" action="{{ route('cart.hapus', $item['id_barang']) }}" style="display:inline; margin: 0;">
                            @csrf
                            <button type="submit" class="btn-del">[hps]</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="total-divider"></div>

        <div class="total-row">
            <span>Total Bayar (Ongkir diabaikan):</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <div class="actions">
            <form method="POST" action="{{ route('cart.kosongkan') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-clear">[ Kosongkan keranjang ]</button>
            </form>

            <a href="{{ route('checkout.view') }}" class="btn-checkout">[ Lanjut ke Checkout &rarr; ]</a>
        </div>

        <a href="{{ route('katalog') }}" class="btn-back">[ &larr; Kembali ke katalog ]</a>
    @else
        <p style="color: #666;">Keranjang belanja Anda kosong.</p>
        <a href="{{ route('katalog') }}" class="btn-back">[ &larr; Kembali ke katalog ]</a>
    @endif
</body>
</html>
