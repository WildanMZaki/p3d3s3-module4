<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Toko Online</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 720px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom: 1.5rem; }
        .header h2 { margin: 0; }
        .nav-actions { display: flex; align-items: center; gap: 12px; font-size: 14px; }
        .nav-link { color: #2563eb; text-decoration: underline; }
        .btn-link { background: none; border: none; color: #dc2626; text-decoration: underline; cursor: pointer; padding: 0; font-size: 14px; }
        .alert-error { color: #dc2626; margin-bottom: 1rem; font-size: 14px; }
        .alert-success { color: #16a34a; margin-bottom: 1rem; font-size: 14px; }
        .product-list { list-style: none; padding: 0; margin: 0; }
        .product-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #eee; }
        .product-info { display: flex; align-items: center; gap: 14px; }
        .product-img { width: 50px; height: 50px; object-fit: contain; }
        .product-placeholder { width: 50px; height: 50px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #888; }
        .product-name { font-weight: bold; margin-bottom: 2px; }
        .product-desc { font-size: 12px; color: #666; margin-bottom: 4px; }
        .product-meta { font-size: 13px; color: #444; }
        .btn-action { background: none; border: none; color: #2563eb; cursor: pointer; text-decoration: underline; font-size: 14px; padding: 0; }
        .text-disabled { color: #999; font-size: 13px; }
    </style>
</head>
<body>
    <header class="header">
        <div>
            <h2>Toko Online</h2>
            <small style="color: #666;">Program Toko Online Berbasis Web</small>
        </div>
        <div class="nav-actions">
            @auth
                <span>Halo, <b>{{ Auth::user()->nama_lengkap }}</b></span>
                <a href="{{ route('cart.index') }}" class="nav-link">[ Keranjang ({{ $totalItems }}) ]</a>
                <a href="{{ route('order.history') }}" class="nav-link">[ Riwayat Pesanan ]</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline; margin: 0;">
                    @csrf
                    <button type="submit" class="btn-link">[ Logout ]</button>
                </form>
            @else
                <span style="color: #666;">Pengunjung (Tamu)</span>
                <a href="{{ route('login') }}" class="nav-link">[ Login untuk Belanja ]</a>
            @endauth
        </div>
    </header>

    @if(session('error'))
        <div class="alert-error">[ {{ session('error') }} ]</div>
    @endif
    @if(session('success'))
        <div class="alert-success">[ {{ session('success') }} ]</div>
    @endif

    <p style="font-weight: bold; margin-bottom: 1rem;">Daftar Produk (Minimal 10 Barang):</p>

    <ul class="product-list">
        @foreach($products as $product)
            <li class="product-item">
                <div class="product-info">
                    @if($product->gambar && file_exists(public_path('images/' . $product->gambar)))
                        <img src="{{ asset('images/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="product-img">
                    @else
                        <div class="product-placeholder">[img]</div>
                    @endif
                    <div>
                        <div class="product-name">{{ $product->nama_barang }}</div>
                        <div class="product-desc">{{ $product->deskripsi }}</div>
                        <div class="product-meta">
                            Rp {{ number_format($product->harga, 0, ',', '.') }} | 
                            @if($product->stok > 0)
                                Stok: <b>{{ $product->stok }}</b>
                            @else
                                <span style="color: #dc2626; font-weight: bold;">Stok: 0 (Habis)</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    @if($product->stok > 0)
                        @auth
                            <form method="POST" action="{{ route('cart.tambah', $product->id_barang) }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-action">[Masukkan ke krj]</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">[Login untuk Beli]</a>
                        @endauth
                    @else
                        <span class="text-disabled">[Stok 0 - Tidak Bisa Dibeli]</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</body>
</html>
