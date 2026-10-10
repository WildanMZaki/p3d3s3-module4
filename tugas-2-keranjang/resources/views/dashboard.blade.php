<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 2rem;
        }

        .box {
            max-width: 450px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .btn-logout {
            background: none;
            border: none;
            color: #2563eb;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="header">
            <h3 style="margin: 0;">Dashboard</h3>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">[ Logout ]</button>
            </form>
        </div>

        <p>Selamat datang, <b>{{ $user->nama_lengkap }}</b>!</p>
        <p>Halaman ini hanya bisa dibuka setelah login.</p>
        <p><small>Username: {{ $user->username }}</small></p>
    </div>
</body>

</html>