<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin · Bank Sampah</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 1rem; background: #f4f7f5; color: #17202a; font-family: Arial, sans-serif; }
        main { width: min(100%, 420px); padding: 2rem; background: white; border: 1px solid #d8e1db; border-radius: 8px; box-shadow: 0 12px 30px #14532d12; }
        h1 { margin-top: 0; color: #14532d; }
        p { color: #64748b; line-height: 1.5; }
        label { display: block; margin: 1rem 0 .35rem; font-weight: 600; }
        input[type=text], input[type=password] { width: 100%; padding: .7rem; border: 1px solid #94a3b8; border-radius: 4px; font: inherit; }
        .remember { display: flex; gap: .5rem; align-items: center; margin: 1rem 0; }
        .errors { padding: .75rem; background: #fee2e2; color: #991b1b; border-radius: 4px; }
        button { width: 100%; padding: .75rem; border: 0; border-radius: 4px; color: white; background: #166534; font: inherit; font-weight: 700; cursor: pointer; }
    </style>
</head>
<body>
    <main>
        <h1>Masuk Admin</h1>
        <p>Masuk menggunakan username atau email dan kata sandi yang terdaftar.</p>
        @if ($errors->any())
            <div class="errors" role="alert">{{ $errors->first() }}</div>
        @endif
        <form method="post" action="{{ route('login.store') }}">
            @csrf
            <label for="identifier">Username atau email</label>
            <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" autocomplete="username" required autofocus>
            <label for="password">Kata sandi</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
            <label class="remember"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
            <button type="submit">Masuk</button>
        </form>
    </main>
</body>
</html>
