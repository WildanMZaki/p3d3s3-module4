<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Halaman daftar barang yang dijual
     */
    public function index()
    {
        $barangs = Barang::all();
        $cart = session()->get('cart', []);
        $totalItems = count($cart);

        return view('barang.index', compact('barangs', 'totalItems'));
    }

    /**
     * Halaman keranjang belanja
     */
    public function keranjang()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $barangIds = array_keys($cart);
            $barangs = Barang::whereIn('id', $barangIds)->get()->keyBy('id');

            foreach ($cart as $id => $jumlah) {
                if (isset($barangs[$id])) {
                    $barang = $barangs[$id];
                    $subtotal = $barang->harga * $jumlah;
                    $total += $subtotal;

                    $cartItems[] = [
                        'id'       => $barang->id,
                        'nama'     => $barang->nama,
                        'harga'    => $barang->harga,
                        'jumlah'   => $jumlah,
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        return view('barang.keranjang', compact('cartItems', 'total'));
    }

    /**
     * Tambah produk ke keranjang
     */
    public function tambah($id)
    {
        $barang = Barang::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    /**
     * Ubah jumlah produk (+ atau -). Otomatis hapus jika jumlah menjadi 0
     */
    public function ubahJumlah(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        $aksi = $request->input('aksi');

        if (isset($cart[$id])) {
            if ($aksi === 'tambah') {
                $cart[$id]++;
            } elseif ($aksi === 'kurang') {
                $cart[$id]--;
                if ($cart[$id] <= 0) {
                    unset($cart[$id]);
                }
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.keranjang');
    }

    /**
     * Hapus 1 item dari keranjang
     */
    public function hapus($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.keranjang');
    }

    /**
     * Kosongkan seluruh isi keranjang
     */
    public function kosongkan()
    {
        session()->forget('cart');

        return redirect()->route('cart.keranjang');
    }
}
