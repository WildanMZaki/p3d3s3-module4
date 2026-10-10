<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Toko Online</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 640px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 8px; margin-bottom: 1rem; }
        .header h3 { margin: 0; }
        .alert-success { color: #16a34a; margin-bottom: 1rem; font-size: 14px; font-weight: bold; }
        .order-card { border-bottom: 1px solid #ccc; padding: 1rem 0; }
        .order-meta { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px; }
        .order-detail-list { list-style: none; padding: 0; margin: 0 0 8px 0; font-size: 14px; }
        .order-detail-item { display: flex; justify-content: space-between; padding: 4px 0; }
        .order-footer { display: flex; justify-content: space-between; font-size: 14px; margin-top: 8px; }
        .btn-back { display: block; margin-top: 1.5rem; color: #2563eb; text-decoration: underline; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Riwayat Pesanan</h3>
        <span style="font-size: 14px; color: #666;">Pengguna: <b>{{ Auth::user()->nama_lengkap }}</b></span>
    </div>

    @if(session('success'))
        <div class="alert-success">[ {{ session('success') }} ]</div>
    @endif

    @if(count($orders) > 0)
        @foreach($orders as $order)
            <div class="order-card">
                <div class="order-meta">
                    <span><b>No. Pesanan:</b> {{ $order->id_order }}</span>
                    <span style="color: #666;">{{ $order->tanggal_order->format('d/m/Y H:i') }}</span>
                </div>

                <ul class="order-detail-list">
                    @foreach($order->details as $detail)
                        <li class="order-detail-item">
                            <span>- {{ $detail->product->nama_barang ?? $detail->id_barang }} (x{{ $detail->jumlah_beli }}) @ Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                            <span>Rp {{ number_format($detail->harga_satuan * $detail->jumlah_beli, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="order-footer">
                    <span style="color: #666; font-size: 13px;">Alamat: {{ $order->alamat_pengiriman ?? '-' }}</span>
                    <span><b>Total Bayar:</b> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    @else
        <p style="color: #666;">Belum ada pesanan yang pernah dibuat.</p>
    @endif

    <a href="{{ route('katalog') }}" class="btn-back">[ &larr; Kembali ke Katalog Belanja ]</a>
</body>
</html>
