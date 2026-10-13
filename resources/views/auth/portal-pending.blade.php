<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal belum tersedia · Bank Sampah</title>
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 1rem; background: #f4f7f5; color: #17202a; font-family: Arial, sans-serif; }
        main { width: min(100%, 520px); padding: 2rem; background: white; border: 1px solid #d8e1db; border-radius: 8px; }
        h1 { color: #14532d; }
        p { line-height: 1.6; }
        button { padding: .7rem 1rem; border: 0; border-radius: 4px; color: white; background: #166534; font: inherit; cursor: pointer; }
    </style>
</head>
<body>
    <main>
        <h1>Login berhasil</h1>
        <p>Halo, {{ auth()->user()->name }}. Akun Anda ({{ auth()->user()->role }}) berhasil masuk, tetapi portal untuk peran ini belum tersedia.</p>
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </main>
</body>
</html>
