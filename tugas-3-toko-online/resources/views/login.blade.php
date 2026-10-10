<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 2rem;
        }

        .box {
            max-width: 320px;
        }

        .error {
            color: #dc2626;
            margin-bottom: 1rem;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 4px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            padding: 8px 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="box">
        <h2>Login</h2>
        <p>Masuk untuk membuka dashboard</p>

        @error('loginError')
        <div class="error">[ {{ $message }} ]</div>
        @enderror

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Masuk</button>
        </form>
    </div>
</body>

</html>