<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · Bank Sampah</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #18352a;
            background: #f5f8f6;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            --green-950: #103b2a;
            --green-900: #174a35;
            --green-700: #268355;
            --green-100: #e7f4eb;
            --ink-muted: #718177;
            --line: #e7ede9;
            --surface: #fff;
            --shadow: 0 12px 35px rgb(31 61 45 / 5%);
        }
        * { box-sizing: border-box; }
        body { min-width: 320px; min-height: 100vh; margin: 0; }
        a { color: inherit; }
        button, input, select { font: inherit; }
        .app-shell { min-height: 100vh; }
        .sidebar {
            position: fixed; inset: 0 auto 0 0; z-index: 5; display: flex; width: 248px;
            flex-direction: column; padding: 28px 18px 20px; color: #eaf5ee;
            background: linear-gradient(165deg, #174a35, #103b2a 75%);
        }
        .brand { display: flex; align-items: center; gap: 12px; padding: 0 10px 30px; }
        .brand-mark {
            display: grid; width: 42px; height: 42px; place-items: center; border-radius: 14px;
            color: #174a35; background: #d4efdc; font-size: 21px; font-weight: 800;
        }
        .brand-copy strong { display: block; font-size: 14px; letter-spacing: .01em; }
        .brand-copy span { display: block; margin-top: 4px; color: #adc8b8; font-size: 11px; }
        .nav-caption { padding: 0 12px 10px; color: #8ead9b; font-size: 10px; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; }
        .side-nav { display: grid; gap: 5px; }
        .side-nav a {
            display: flex; align-items: center; gap: 12px; min-height: 44px; padding: 0 12px;
            border-radius: 10px; color: #c4d8cb; font-size: 13px; font-weight: 550; text-decoration: none;
            transition: color .15s ease, background .15s ease;
        }
        .side-nav a:hover, .side-nav a.active { color: #fff; background: rgb(255 255 255 / 12%); }
        .side-nav a.active { box-shadow: inset 3px 0 #82d6a0; }
        .nav-icon { display: grid; width: 20px; place-items: center; color: #a8c8b3; font-size: 16px; }
        .sidebar-bottom { margin-top: auto; padding: 14px 10px 0; border-top: 1px solid rgb(255 255 255 / 12%); }
        .sidebar-bottom p { margin: 0 0 12px; color: #adc8b8; font-size: 11px; line-height: 1.6; }
        .logout-button { width: 100%; min-height: 40px; border: 1px solid rgb(255 255 255 / 18%); border-radius: 9px; color: #f5fffa; background: transparent; cursor: pointer; text-align: left; padding: 0 12px; }
        .logout-button:hover { background: rgb(255 255 255 / 9%); }
        .main-column { min-height: 100vh; margin-left: 248px; }
        .topbar {
            position: sticky; top: 0; z-index: 3; display: flex; min-height: 72px; align-items: center;
            justify-content: space-between; padding: 0 clamp(22px, 4vw, 58px); border-bottom: 1px solid var(--line);
            background: rgb(255 255 255 / 92%); backdrop-filter: blur(10px);
        }
        .breadcrumb { color: var(--ink-muted); font-size: 12px; }
        .breadcrumb strong { color: #294b3a; font-weight: 650; }
        .profile { display: flex; align-items: center; gap: 11px; }
        .avatar { display: grid; width: 36px; height: 36px; place-items: center; border-radius: 50%; color: #1b6740; background: #e1f2e6; font-size: 13px; font-weight: 750; }
        .profile-copy strong { display: block; font-size: 12px; }
        .profile-copy span { display: block; margin-top: 3px; color: var(--ink-muted); font-size: 10px; }
        main { width: min(100%, 1440px); margin: 0 auto; padding: 34px clamp(22px, 4vw, 58px) 52px; font-size: 15px; line-height: 1.55; }
        h1, h2, h3, p { margin-top: 0; }
        h2 { margin-bottom: 0; color: #18352a; font-size: 24px; letter-spacing: -.025em; line-height: 1.3; }
        .page-heading { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; margin-bottom: 27px; }
        .page-heading p { margin: 8px 0 0; color: var(--ink-muted); font-size: 13px; }
        .page-heading h2 { font-size: 24px; }
        .content-heading { margin-bottom: 17px; }
        .eyebrow { margin-bottom: 8px; color: var(--green-700); font-size: 10px; font-weight: 750; letter-spacing: .15em; text-transform: uppercase; }
        .cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
        .panel { margin: 0; border: 1px solid var(--line); border-radius: 15px; background: var(--surface); box-shadow: var(--shadow); }
        .panel:not(.metric-card):not(.section-card):not(.table-wrap):not(.welcome-panel) { padding: 24px; }
        .panel h2 { margin-bottom: 16px; }
        .panel h3 { margin-bottom: 12px; color: #244333; font-size: 17px; }
        .metric-card { position: relative; min-height: 146px; overflow: hidden; padding: 20px; }
        .metric-card::after { position: absolute; right: -25px; bottom: -40px; width: 120px; height: 120px; border-radius: 50%; background: var(--metric-tint, #eff8f1); content: ""; }
        .metric-top { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; gap: 10px; color: #62756a; font-size: 14px; font-weight: 600; }
        .metric-icon { display: grid; width: 36px; height: 36px; place-items: center; border-radius: 11px; color: var(--metric-color, #278153); background: var(--metric-tint, #eff8f1); font-size: 16px; font-weight: 800; }
        .metric-value { position: relative; z-index: 1; display: block; margin-top: 15px; color: #193b2c; font-size: clamp(23px, 2.5vw, 30px); font-weight: 750; letter-spacing: -.04em; line-height: 1.1; }
        .metric-foot { position: relative; z-index: 1; display: block; margin-top: 7px; color: #718177; font-size: 12px; }
        .welcome-panel {
            display: flex; min-height: 162px; align-items: center; justify-content: space-between; gap: 20px;
            margin-bottom: 24px; padding: 28px 32px; overflow: hidden; border: 0;
            color: white; background: radial-gradient(circle at 90% 10%, rgb(147 219 164 / 27%), transparent 28%), linear-gradient(112deg, #174a35, #26774b);
        }
        .welcome-panel h1 { margin-bottom: 8px; font-size: clamp(21px, 2.4vw, 29px); letter-spacing: -.04em; }
        .welcome-panel p { margin-bottom: 0; color: #d0e7d7; font-size: 15px; }
        .welcome-date { flex: 0 0 auto; padding: 12px 15px; border: 1px solid rgb(255 255 255 / 22%); border-radius: 12px; color: #e4f2e8; background: rgb(255 255 255 / 9%); font-size: 13px; }
        .dashboard-grid { display: grid; grid-template-columns: minmax(0, 1.65fr) minmax(260px, .9fr); gap: 17px; margin-top: 25px; }
        .section-card { min-width: 0; padding: 20px; }
        .section-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 17px; }
        .section-head h3 { margin: 0; color: #244333; font-size: 16px; }
        .section-head a { color: var(--green-700); font-size: 13px; font-weight: 650; text-decoration: none; }
        .section-head a:hover { text-decoration: underline; }
        .table-wrap { min-width: 0; overflow-x: auto; }
        .panel.table-wrap { padding: 12px 20px 18px; }
        table { width: 100%; border-collapse: collapse; white-space: nowrap; }
        th { padding: 12px 14px; border-bottom: 1px solid #e4ece6; color: #586d60; background: #f6f9f7; font-size: 12px; font-weight: 700; text-align: left; }
        td { padding: 14px; border-top: 1px solid #edf1ee; color: #43584a; font-size: 14px; line-height: 1.5; vertical-align: middle; }
        tbody tr:hover { background: #f8fbf9; }
        td strong { color: #284635; font-weight: 650; }
        td a:not(.button) { color: var(--green-700); font-weight: 600; text-decoration: none; }
        td a:not(.button):hover { text-decoration: underline; }
        td .actions { gap: 10px; }
        .status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 6px 10px; border-radius: 30px; color: #247247; background: #eaf6ed; font-size: 12px; font-weight: 650; }
        .status-pill::before { width: 5px; height: 5px; border-radius: 50%; background: #45a96d; content: ""; }
        .empty-state { padding: 27px 12px; color: var(--ink-muted); font-size: 14px; text-align: center; }
        .member-list { display: grid; }
        .member-row { display: flex; align-items: center; gap: 11px; padding: 12px 0; border-top: 1px solid #edf1ee; }
        .member-row:first-child { border-top: 0; padding-top: 0; }
        .member-avatar { display: grid; width: 35px; height: 35px; flex: 0 0 auto; place-items: center; border-radius: 11px; color: #27764a; background: #eaf5ed; font-size: 12px; font-weight: 750; }
        .member-copy { min-width: 0; }
        .member-copy strong { display: block; overflow: hidden; color: #284635; font-size: 14px; text-overflow: ellipsis; white-space: nowrap; }
        .member-copy span { display: block; margin-top: 4px; color: #718177; font-size: 12px; }
        .quick-links { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-top: 24px; }
        .quick-link { display: flex; align-items: center; gap: 11px; min-height: 62px; padding: 12px; border: 1px solid var(--line); border-radius: 12px; color: #345343; background: white; box-shadow: var(--shadow); font-size: 14px; font-weight: 650; text-decoration: none; transition: transform .15s ease, border-color .15s ease; }
        .quick-link:hover { transform: translateY(-2px); border-color: #b8d8c1; }
        .quick-link span { display: grid; width: 32px; height: 32px; flex: 0 0 auto; place-items: center; border-radius: 10px; color: var(--green-700); background: var(--green-100); font-size: 15px; }
        .actions { display: flex; flex-wrap: wrap; gap: .625rem; align-items: center; }
        main > .actions, main > h2 { margin-bottom: 18px; }
        main > .actions h2 { margin: 0; }
        .button, button { display: inline-block; min-height: 42px; border: 0; border-radius: 8px; padding: .6rem .85rem; background: var(--green-700); color: white; cursor: pointer; text-decoration: none; font: inherit; font-weight: 600; }
        .button.secondary { background: #52665a; }
        .button.danger, button.danger { background: #b91c1c; }
        .cards:not(.dashboard-cards) { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        .metric strong { display: block; font-size: 1.5rem; margin-top: .5rem; }
        .form-actions { margin-top: 1rem; display: flex; gap: .5rem; }
        label { display: block; font-size: 14px; font-weight: 600; margin: .8rem 0 .35rem; }
        input, select { box-sizing: border-box; width: 100%; max-width: 520px; min-height: 44px; padding: .65rem .75rem; border: 1px solid #cbd8cf; border-radius: 8px; background: #fff; color: #18352a; }
        input:focus, select:focus { outline: 3px solid rgb(38 131 85 / 16%); border-color: var(--green-700); }
        main > form.panel { margin-bottom: 18px; }
        main > form.panel .actions { gap: 12px; }
        main > form.panel .actions label { flex: 1 1 220px; margin-top: 0; }
        .notice { border-radius: 9px; padding: .8rem; margin: 0 0 1rem; background: #dcfce7; }
        .error { background: #fee2e2; color: #991b1b; }
        .muted { color: var(--ink-muted); }
        @media (max-width: 1100px) {
            .sidebar { width: 220px; }
            .main-column { margin-left: 220px; }
            .cards { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .quick-links { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 760px) {
            .sidebar { position: static; width: auto; padding: 14px 16px 12px; }
            .brand { padding: 0 2px 14px; }
            .nav-caption, .sidebar-bottom { display: none; }
            .side-nav { display: flex; gap: 6px; overflow-x: auto; padding-bottom: 3px; }
            .side-nav a { flex: 0 0 auto; min-height: 36px; padding: 0 10px; font-size: 11px; }
            .nav-icon { width: auto; }
            .main-column { margin-left: 0; }
            .topbar { position: static; min-height: 58px; padding: 0 18px; }
            main { padding: 24px 17px 36px; }
            .dashboard-grid { grid-template-columns: 1fr; }
            .welcome-panel { align-items: flex-start; flex-direction: column; padding: 23px; }
            .welcome-date { align-self: flex-start; }
        }
        @media (max-width: 460px) {
            .cards, .quick-links { grid-template-columns: 1fr 1fr; gap: 10px; }
            .metric-card { min-height: 132px; padding: 15px; }
            .metric-top { align-items: flex-start; flex-direction: column-reverse; }
            .metric-value { margin-top: 12px; font-size: 22px; }
            .page-heading { align-items: flex-start; flex-direction: column; }
            .profile-copy { display: none; }
            .panel.table-wrap { padding: 8px 12px 14px; }
            .panel:not(.metric-card):not(.section-card):not(.table-wrap):not(.welcome-panel) { padding: 18px; }
            th, td { padding-right: 11px; padding-left: 11px; }
        }
    </style>
</head>
<body>
    @php($currentRoute = request()->route()?->getName())
    @php($currentTitle = trim($__env->yieldContent('title', 'Dashboard')))
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('admin.dashboard') }}" style="color:inherit;text-decoration:none">
                <span class="brand-mark">♻</span>
                <span class="brand-copy"><strong>Bank Sampah</strong><span>Panel administrasi</span></span>
            </a>
            <div class="nav-caption">Menu utama</div>
            <nav class="side-nav" aria-label="Navigasi admin">
                <a class="{{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="nav-icon">⌂</span>Dashboard</a>
                <a class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><span class="nav-icon">♙</span>Pengguna</a>
                <a class="{{ request()->routeIs('admin.nasabah.*') ? 'active' : '' }}" href="{{ route('admin.nasabah.index') }}"><span class="nav-icon">♧</span>Nasabah</a>
                <a class="{{ request()->routeIs('admin.kategori-sampah.*') ? 'active' : '' }}" href="{{ route('admin.kategori-sampah.index') }}"><span class="nav-icon">▤</span>Kategori sampah</a>
                <a class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}" href="{{ route('admin.transaksi.index') }}"><span class="nav-icon">↗</span>Transaksi</a>
                <a class="{{ request()->routeIs('admin.tabungan.*') ? 'active' : '' }}" href="{{ route('admin.tabungan.index') }}"><span class="nav-icon">◉</span>Tabungan</a>
                <a class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="{{ route('admin.laporan.index') }}"><span class="nav-icon">▥</span>Laporan</a>
            </nav>
            <div class="sidebar-bottom">
                <p>Kelola data bank sampah sekolah dalam satu tempat.</p>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-button">↪ &nbsp; Keluar dari akun</button>
                </form>
            </div>
        </aside>
        <div class="main-column">
            <div class="topbar">
                <div class="breadcrumb">Bank Sampah <span aria-hidden="true">/</span> <strong>{{ $currentTitle }}</strong></div>
                <div class="profile">
                    <span class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                    <span class="profile-copy"><strong>{{ auth()->user()->name }}</strong><span>{{ str_replace('_', ' ', auth()->user()->role) }}</span></span>
                </div>
            </div>
            <main>
                @if (session('success'))
                    <div class="notice">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="notice error">
                        <strong>Periksa kembali:</strong>
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
