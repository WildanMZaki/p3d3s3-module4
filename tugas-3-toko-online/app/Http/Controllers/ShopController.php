<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * 1. Halaman Katalog Produk (Dapat dilihat pengunjung tanpa login)
     */
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);
        $totalItems = count($cart);

        return view('shop.katalog', compact('products', 'totalItems'));
    }

    /**
     * 2. Halaman Keranjang Belanja (Wajib Login)
     */
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');

            foreach ($cart as $id_barang => $jumlah) {
                if (isset($products[$id_barang])) {
                    $product = $products[$id_barang];
                    $subtotal = $product->harga * $jumlah;
                    $total += $subtotal;

                    $cartItems[] = [
                        'id_barang'   => $product->id_barang,
                        'nama_barang' => $product->nama_barang,
                        'harga'       => $product->harga,
                        'stok'        => $product->stok,
                        'jumlah'      => $jumlah,
                        'subtotal'    => $subtotal,
                    ];
                }
            }
        }

        return view('shop.keranjang', compact('cartItems', 'total'));
    }

    /**
     * 3. Tambah Produk ke Keranjang (Wajib Login & Cek Ketersediaan Stok)
     */
    public function tambah(Request $request, $id_barang)
    {
        $product = Product::findOrFail($id_barang);

        // Aturan: Barang dengan stok 0 tidak dapat dibeli
        if ($product->stok <= 0) {
            return redirect()->back()->with('error', 'Stok barang habis, tidak dapat dibeli.');
        }

        $cart = session()->get('cart', []);
        $currentQty = $cart[$id_barang] ?? 0;

        // Aturan: Jumlah yang dibeli tidak boleh melebihi stok
        if ($currentQty + 1 > $product->stok) {
            return redirect()->back()->with('error', "Jumlah tidak boleh melebihi stok yang tersedia (sisa {$product->stok}).");
        }

        $cart[$id_barang] = $currentQty + 1;
        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->nama_barang} berhasil ditambahkan ke keranjang.");
    }

    /**
     * 4. Ubah Jumlah Produk di Keranjang (+ atau -)
     */
    public function ubahJumlah(Request $request, $id_barang)
    {
        $product = Product::findOrFail($id_barang);
        $cart = session()->get('cart', []);
        $aksi = $request->input('aksi');

        if (isset($cart[$id_barang])) {
            if ($aksi === 'tambah') {
                if ($cart[$id_barang] + 1 > $product->stok) {
                    return redirect()->back()->with('error', "Jumlah melebihi stok yang tersedia ({$product->stok}).");
                }
                $cart[$id_barang]++;
            } elseif ($aksi === 'kurang') {
                $cart[$id_barang]--;
                if ($cart[$id_barang] <= 0) {
                    unset($cart[$id_barang]);
                }
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * 5. Hapus 1 Item dari Keranjang
     */
    public function hapus($id_barang)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id_barang])) {
            unset($cart[$id_barang]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    /**
     * 6. Kosongkan Seluruh Keranjang
     */
    public function kosongkan()
    {
        session()->forget('cart');

        return redirect()->route('cart.index');
    }

    /**
     * 7. Halaman Konfirmasi Checkout (Wajib Login)
     */
    public function checkoutView()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $products = Product::whereIn('id_barang', array_keys($cart))->get()->keyBy('id_barang');
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id_barang => $jumlah) {
            if (isset($products[$id_barang])) {
                $product = $products[$id_barang];
                $subtotal = $product->harga * $jumlah;
                $total += $subtotal;

                $cartItems[] = [
                    'id_barang'   => $product->id_barang,
                    'nama_barang' => $product->nama_barang,
                    'harga'       => $product->harga,
                    'jumlah'      => $jumlah,
                    'subtotal'    => $subtotal,
                ];
            }
        }

        $user = Auth::user();

        return view('shop.checkout', compact('cartItems', 'total', 'user'));
    }

    /**
     * 8. Proses Checkout Transaksional
     */
    public function checkoutProcess(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => ['required', 'string'],
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $user = Auth::user();

        return DB::transaction(function () use ($cart, $request, $user) {
            // Lock baris produk untuk mencegah race condition stok
            $products = Product::whereIn('id_barang', array_keys($cart))->lockForUpdate()->get()->keyBy('id_barang');

            // Validasi ketersediaan stok saat ini
            foreach ($cart as $id_barang => $jumlah) {
                if (!isset($products[$id_barang]) || $products[$id_barang]->stok < $jumlah) {
                    $nama = $products[$id_barang]->nama_barang ?? 'Barang';
                    return redirect()->route('cart.index')->with('error', "Stok untuk {$nama} tidak mencukupi untuk checkout.");
                }
            }

            // Hitung total harga
            $totalHarga = 0;
            foreach ($cart as $id_barang => $jumlah) {
                $product = $products[$id_barang];
                $totalHarga += $product->harga * $jumlah;
            }

            // Generate ID Order Unik: ORD + timestamp (format VARCHAR 15)
            $idOrder = 'ORD' . date('ymdHis');

            // 1. Simpan Pesanan ke Tabel orders
            Order::create([
                'id_order'          => $idOrder,
                'id_user'           => $user->id_user,
                'tanggal_order'     => now(),
                'total_harga'       => $totalHarga,
                'alamat_pengiriman' => $request->input('alamat_pengiriman'),
            ]);

            // 2. Simpan Detail Pesanan ke order_details & Potong Stok Produk
            foreach ($cart as $id_barang => $jumlah) {
                $product = $products[$id_barang];

                OrderDetail::create([
                    'id_order'     => $idOrder,
                    'id_barang'    => $id_barang,
                    'harga_satuan' => $product->harga,
                    'jumlah_beli'  => $jumlah,
                ]);

                // Kurangi stok barang
                $product->decrement('stok', $jumlah);
            }

            // 3. Kosongkan Keranjang Belanja di Session
            session()->forget('cart');

            return redirect()->route('order.history')->with('success', "Pesanan #{$idOrder} berhasil dibuat!");
        });
    }

    /**
     * 9. Riwayat Pesanan User (Wajib Login)
     */
    public function riwayat()
    {
        $user = Auth::user();
        $orders = Order::where('id_user', $user->id_user)
            ->with(['details.product'])
            ->orderBy('tanggal_order', 'desc')
            ->get();

        return view('shop.riwayat', compact('orders'));
    }
}
