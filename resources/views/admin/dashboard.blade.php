@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="panel welcome-panel">
        <div>
            <div class="eyebrow" style="color:#b7e4c4">Ringkasan operasional</div>
            <h1>Selamat datang, {{ auth()->user()->name }}</h1>
            <p>Pantau aktivitas dan kondisi bank sampah sekolah hari ini.</p>
        </div>
        <div class="welcome-date">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
    </section>

    <div class="cards dashboard-cards">
        <section class="panel metric-card" style="--metric-color:#258050;--metric-tint:#e7f4eb">
            <div class="metric-top"><span>Nasabah terdaftar</span><span class="metric-icon">♧</span></div>
            <strong class="metric-value">{{ number_format($jumlahNasabah) }}</strong>
            <span class="metric-foot">Total profil nasabah</span>
        </section>
        <section class="panel metric-card" style="--metric-color:#3973a5;--metric-tint:#eaf2fa">
            <div class="metric-top"><span>Kategori sampah</span><span class="metric-icon">▤</span></div>
            <strong class="metric-value">{{ number_format($jumlahKategori) }}</strong>
            <span class="metric-foot">Jenis sampah yang dikelola</span>
        </section>
        <section class="panel metric-card" style="--metric-color:#b27827;--metric-tint:#fbf2e3">
            <div class="metric-top"><span>Transaksi setoran</span><span class="metric-icon">↗</span></div>
            <strong class="metric-value">{{ number_format($jumlahTransaksi) }}</strong>
            <span class="metric-foot">{{ number_format((float) $totalBerat, 3, ',', '.') }} kg total berat tercatat</span>
        </section>
        <section class="panel metric-card" style="--metric-color:#7654a5;--metric-tint:#f0eafa">
            <div class="metric-top"><span>Total nilai setoran</span><span class="metric-icon">Rp</span></div>
            <strong class="metric-value">Rp {{ number_format((float) $totalNilai, 0, ',', '.') }}</strong>
            <span class="metric-foot">Akumulasi nilai transaksi</span>
        </section>
    </div>

    <div class="cards" style="margin-top:16px">
        <section class="panel metric-card" style="--metric-color:#258050;--metric-tint:#e7f4eb;min-height:115px">
            <div class="metric-top"><span>Total saldo tabungan nasabah</span><span class="metric-icon">◉</span></div>
            <strong class="metric-value">Rp {{ number_format((float) $totalSaldo, 2, ',', '.') }}</strong>
        </section>
        <section class="panel metric-card" style="--metric-color:#3973a5;--metric-tint:#eaf2fa;min-height:115px">
            <div class="metric-top"><span>Rata-rata nilai per transaksi</span><span class="metric-icon">∿</span></div>
            <strong class="metric-value">Rp {{ number_format($jumlahTransaksi > 0 ? (float) $totalNilai / $jumlahTransaksi : 0, 2, ',', '.') }}</strong>
        </section>
    </div>

    <div class="dashboard-grid">
        <section class="panel section-card">
            <div class="section-head">
                <h3>Transaksi terbaru</h3>
                <a href="{{ route('admin.transaksi.index') }}">Lihat semua →</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>TANGGAL</th><th>NASABAH</th><th>PETUGAS</th><th>NILAI</th><th>STATUS</th></tr></thead>
                    <tbody>
                        @forelse ($transaksiTerbaru as $transaksi)
                            <tr>
                                <td>{{ $transaksi->tanggal_setoran->format('d M Y, H:i') }}</td>
                                <td><strong>{{ $transaksi->nasabah?->nama_siswa ?? '—' }}</strong></td>
                                <td>{{ $transaksi->petugas?->name ?? '—' }}</td>
                                <td><strong>Rp {{ number_format((float) $transaksi->total_nilai, 0, ',', '.') }}</strong></td>
                                <td><a class="status-pill" style="text-decoration:none" href="{{ route('admin.transaksi.show', $transaksi) }}">Rincian</a></td>
                            </tr>
                        @empty
                            <tr><td class="empty-state" colspan="5">Belum ada transaksi setoran yang tercatat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel section-card">
            <div class="section-head">
                <h3>Nasabah terbaru</h3>
                <a href="{{ route('admin.nasabah.index') }}">Lihat semua →</a>
            </div>
            <div class="member-list">
                @forelse ($nasabahTerbaru as $nasabah)
                    <a class="member-row" href="{{ route('admin.nasabah.show', $nasabah) }}" style="text-decoration:none">
                        <span class="member-avatar">{{ mb_substr($nasabah->nama_siswa, 0, 1) }}</span>
                        <span class="member-copy">
                            <strong>{{ $nasabah->nama_siswa }}</strong>
                            <span>Kelas {{ $nasabah->kelas }} · {{ $nasabah->created_at->diffForHumans() }}</span>
                        </span>
                    </a>
                @empty
                    <div class="empty-state">Belum ada nasabah terdaftar.</div>
                @endforelse
            </div>
        </section>
    </div>

    <section>
        <div class="section-head content-heading"><h3>Akses cepat</h3></div>
        <div class="quick-links">
            <a class="quick-link" href="{{ route('admin.nasabah.create') }}"><span>＋</span>Tambah nasabah</a>
            <a class="quick-link" href="{{ route('admin.kategori-sampah.create') }}"><span>▤</span>Tambah kategori</a>
            <a class="quick-link" href="{{ route('admin.users.create') }}"><span>♙</span>Buat pengguna</a>
            <a class="quick-link" href="{{ route('admin.laporan.index') }}"><span>▥</span>Buka laporan</a>
        </div>
    </section>
@endsection
