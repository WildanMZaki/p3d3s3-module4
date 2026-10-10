<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Online</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 360px; }
        .error { color: #dc2626; margin-bottom: 1rem; font-size: 14px; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 4px; font-size: 14px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 8px 16px; cursor: pointer; }
        .back-link { display: block; margin-top: 1rem; color: #2563eb; text-decoration: underline; font-size: 14px; }
    </style>
</head>
<body>
    <h2 style="margin-top: 0;">Login Pengguna</h2>
    <p style="font-size: 13px; color: #666;">Masuk untuk dapat memasukkan barang ke keranjang dan checkout.</p>

    @error('loginError')
        <div class="error">[ {{ $message }} ]</div>
    @enderror

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="ali / siti" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="rahasia123 / siti456" required>
        </div>
        <button type="submit">Masuk</button>
    </form>

    <a href="{{ route('katalog') }}" class="back-link">&larr; Kembali ke Katalog Toko</a>
</body>
</html>