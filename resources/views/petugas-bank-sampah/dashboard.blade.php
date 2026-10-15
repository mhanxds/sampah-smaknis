<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Petugas · Bank Sampah</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #18352a;
            background: #f5f8f6;
            --green-900: #174a35;
            --green-700: #268355;
            --line: #e7ede9;
            --muted: #718177;
        }
        * { box-sizing: border-box; }
        body { min-width: 320px; min-height: 100vh; margin: 0; }
        .topbar { display: flex; min-height: 72px; align-items: center; justify-content: space-between; gap: 16px; padding: 12px clamp(18px, 5vw, 64px); border-bottom: 1px solid var(--line); background: #fff; }
        .brand { color: var(--green-900); font-size: 18px; font-weight: 750; text-decoration: none; }
        .user-area { display: flex; align-items: center; gap: 14px; color: var(--muted); font-size: 14px; }
        button { min-height: 40px; padding: 8px 14px; border: 0; border-radius: 8px; color: #fff; background: var(--green-700); cursor: pointer; font: inherit; font-weight: 600; }
        main { width: min(100% - 36px, 1200px); margin: 0 auto; padding: 36px 0 56px; }
        h1 { margin: 0; color: #18352a; font-size: clamp(25px, 3vw, 32px); letter-spacing: -.03em; }
        .intro { margin: 8px 0 26px; color: var(--muted); font-size: 15px; }
        .cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
        .card, .recent { border: 1px solid var(--line); border-radius: 14px; background: #fff; box-shadow: 0 12px 35px rgb(31 61 45 / 5%); }
        .card { min-height: 130px; padding: 20px; }
        .card span { color: var(--muted); font-size: 14px; }
        .card strong { display: block; margin-top: 12px; color: var(--green-900); font-size: clamp(23px, 2.5vw, 30px); }
        .recent { margin-top: 24px; padding: 22px; }
        .section-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        h2 { margin: 0; font-size: 19px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th { padding: 12px 14px; border-bottom: 1px solid #e4ece6; color: #586d60; background: #f6f9f7; font-size: 12px; text-align: left; }
        td { padding: 14px; border-top: 1px solid #edf1ee; color: #43584a; font-size: 14px; }
        .empty { color: var(--muted); text-align: center; }
        @media (max-width: 760px) {
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
            main { padding-top: 26px; }
            .recent { padding: 16px; }
        }
        @media (max-width: 460px) {
            .topbar { align-items: flex-start; flex-direction: column; }
            .user-area { width: 100%; justify-content: space-between; }
            .cards { grid-template-columns: 1fr 1fr; gap: 9px; }
            .card { min-height: 110px; padding: 14px; }
            .card span { font-size: 12px; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <a class="brand" href="{{ route('petugas.dashboard') }}">Bank Sampah · Petugas</a>
        <div class="user-area">
            <span>{{ auth()->user()->name }}</span>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
    </header>
    <main>
        <h1>Dashboard Petugas</h1>
        <p class="intro">Ringkasan kegiatan bank sampah sekolah.</p>

        <section class="cards" aria-label="Ringkasan">
            <article class="card"><span>Nasabah terdaftar</span><strong>{{ number_format($jumlahNasabah) }}</strong></article>
            <article class="card"><span>Transaksi setoran</span><strong>{{ number_format($jumlahTransaksi) }}</strong></article>
            <article class="card"><span>Total berat tercatat</span><strong>{{ number_format((float) $totalBerat, 3, ',', '.') }} kg</strong></article>
            <article class="card"><span>Total saldo nasabah</span><strong>Rp {{ number_format((float) $totalSaldo, 0, ',', '.') }}</strong></article>
        </section>

        <section class="recent">
            <div class="section-head"><h2>Setoran terbaru</h2></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Tanggal</th><th>Nasabah</th><th>Petugas</th><th>Total</th></tr></thead>
                    <tbody>
                        @forelse ($transaksiTerbaru as $transaksi)
                            <tr>
                                <td>{{ $transaksi->tanggal_setoran->format('d/m/Y H:i') }}</td>
                                <td>{{ $transaksi->nasabah?->nama_siswa ?? '—' }}</td>
                                <td>{{ $transaksi->petugas?->name ?? '—' }}</td>
                                <td>Rp {{ number_format((float) $transaksi->total_nilai, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td class="empty" colspan="4">Belum ada setoran yang tercatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
