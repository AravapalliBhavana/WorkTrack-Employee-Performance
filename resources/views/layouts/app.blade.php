<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'WorkTrack') · WorkTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--ink:#17233b;--muted:#75819a;--line:#e8edf5;--primary:#625bf6;--bg:#f5f7fb}
        *{box-sizing:border-box}body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--ink);font-size:14px}h1,h2,h3,h4,.navbar-brand{font-family:'Manrope',sans-serif;font-weight:800;letter-spacing:-.035em}
        .app-shell{min-height:100vh}.sidebar{width:248px;background:#151c34;position:fixed;inset:0 auto 0 0;padding:28px 17px;color:#fff;z-index:20;display:flex;flex-direction:column}.brand{display:flex;align-items:center;gap:11px;color:#fff;text-decoration:none;font:800 20px Manrope;margin:0 8px 38px}.brand-mark{display:grid;place-items:center;background:linear-gradient(135deg,#817aff,#5548e8);width:38px;height:38px;border-radius:13px;box-shadow:0 7px 20px #6558f55c}.nav-caption{font-size:10px;letter-spacing:.15em;color:#75809e;font-weight:700;margin:0 12px 10px}.sidebar .nav-link{display:flex;align-items:center;gap:13px;color:#aeb8d0;padding:12px 13px;border-radius:11px;margin-bottom:5px;font-weight:600;transition:.2s}.sidebar .nav-link i{font-size:17px;width:20px}.sidebar .nav-link:hover,.sidebar .nav-link.active{background:#2b3150;color:#fff}.sidebar .nav-link.active{box-shadow:inset 3px 0 #827aff}.side-bottom{margin-top:auto;border-top:1px solid #303650;padding:18px 7px 0}.user-avatar{width:38px;height:38px;border-radius:13px;display:grid;place-items:center;background:#e8e7ff;color:#5e56df;font-weight:800;flex-shrink:0}.main-area{margin-left:248px;min-height:100vh}.topbar{height:76px;background:#fff;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 34px}.content-wrap{padding:30px 34px 42px;max-width:1600px;margin:auto}.eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:.13em;color:var(--muted);font-weight:700}.page-title{font-size:27px;margin:4px 0 0}.subtle{color:var(--muted)}.card{border:1px solid var(--line);border-radius:17px;box-shadow:0 4px 20px #1e315308;background:#fff}.card-header{background:#fff;border-bottom:1px solid var(--line);padding:18px 21px;border-radius:17px 17px 0 0!important}.card-body{padding:21px}.stat-card{position:relative;overflow:hidden;min-height:138px}.stat-icon{width:43px;height:43px;border-radius:14px;display:grid;place-items:center;font-size:20px}.stat-number{font:800 30px Manrope;letter-spacing:-.05em;margin-top:14px}.stat-label{color:var(--muted);font-weight:600;font-size:12px}.stat-change{font-size:11px;font-weight:700;color:#159c76}.btn{border-radius:10px;font-weight:700;padding:9px 15px}.btn-primary{background:var(--primary);border-color:var(--primary)}.btn-primary:hover{background:#5149df;border-color:#5149df}.btn-soft{background:#efeeff;color:#5b54e8;border:0}.table{--bs-table-bg:transparent;margin:0}.table thead th{font-size:10px;text-transform:uppercase;letter-spacing:.09em;color:#8a95aa;font-weight:800;border-bottom:1px solid var(--line);padding:13px 17px;white-space:nowrap}.table tbody td{padding:15px 17px;border-color:#f0f2f7;vertical-align:middle}.table tbody tr:last-child td{border-bottom:0}.badge-soft{padding:7px 10px;border-radius:8px;font-size:10px;font-weight:800;letter-spacing:.02em}.status-pending{background:#fff4dc;color:#b9780c}.status-in_progress{background:#e9edff;color:#4c60ce}.status-completed{background:#e1f7ef;color:#138461}.status-blocked{background:#ffe8e8;color:#d34d4d}.priority-high{color:#d94e60}.priority-medium{color:#d58b1d}.priority-low{color:#199b76}.progress{height:6px;border-radius:10px;background:#edf0f6}.progress-bar{background:var(--primary);border-radius:10px}.form-control,.form-select{border-color:#e1e6ef;border-radius:10px;padding:11px 13px;font-size:13px}.form-control:focus,.form-select:focus{border-color:#9c97ff;box-shadow:0 0 0 .2rem #625bf61c}.form-label{font-size:12px;font-weight:700;color:#4c5870}.section-title{font-size:16px;margin:0}.empty-state{padding:38px 20px;text-align:center;color:var(--muted)}.empty-state i{font-size:28px;color:#a8a6f9}.alert{border:0;border-radius:12px}.mobile-toggle{display:none}
        @media(max-width:900px){.sidebar{width:76px;padding:22px 10px}.brand{margin:0 auto 34px}.brand-text,.nav-caption,.sidebar .nav-link span,.side-bottom .user-meta,.side-bottom .logout-label{display:none}.sidebar .nav-link{justify-content:center;padding:13px 8px}.sidebar .nav-link i{width:auto;font-size:20px}.side-bottom{padding:16px 0}.main-area{margin-left:76px}.topbar{padding:0 20px}.content-wrap{padding:24px 20px}}
        @media(max-width:560px){.sidebar{display:none}.main-area{margin-left:0}.topbar{height:65px;padding:0 16px}.content-wrap{padding:20px 14px}.page-title{font-size:23px}.topbar-role{display:none}}
    </style>
</head>
<body>
@if(auth()->check())
<div class="app-shell">
    <aside class="sidebar">
        <a href="{{ route('dashboard') }}" class="brand"><span class="brand-mark"><i class="bi bi-layers-half"></i></span><span class="brand-text">worktrack</span></a>
        <div class="nav-caption">WORKSPACE</div>
        <nav class="nav flex-column mb-4">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2-fill"></i><span>Overview</span></a>
            <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}"><i class="bi bi-check2-square"></i><span>Task board</span></a>
            <a class="nav-link {{ request()->routeIs('updates.*') ? 'active' : '' }}" href="{{ route('updates.index') }}"><i class="bi bi-journal-check"></i><span>Daily updates</span></a>
            <a class="nav-link {{ request()->routeIs('todos.*') ? 'active' : '' }}" href="{{ route('todos.index') }}"><i class="bi bi-list-check"></i><span>To-do lists</span></a>
            <a class="nav-link {{ request()->routeIs('evaluations.*') ? 'active' : '' }}" href="{{ route('evaluations.index') }}"><i class="bi bi-graph-up-arrow"></i><span>Performance</span></a>
        </nav>
        @if(auth()->user()->role === 'manager')
        <div class="nav-caption">MANAGEMENT</div><nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('employees.create') ? 'active' : '' }}" href="{{ route('employees.create') }}"><i class="bi bi-people"></i><span>Team members</span></a>
            <a class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}" href="{{ route('tasks.create') }}"><i class="bi bi-plus-square"></i><span>Assign a task</span></a>
            <a class="nav-link {{ request()->routeIs('evaluations.create') ? 'active' : '' }}" href="{{ route('evaluations.create') }}"><i class="bi bi-star"></i><span>New evaluation</span></a>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"><i class="bi bi-bar-chart-line"></i><span>Reports & analytics</span></a>
        </nav>
        @endif
        <div class="side-bottom"><div class="d-flex align-items-center gap-2"><div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div><div class="user-meta flex-grow-1 overflow-hidden"><div class="fw-bold text-truncate">{{ auth()->user()->name }}</div><small style="color:#9ca8c4">{{ ucfirst(auth()->user()->role) }}</small></div></div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">@csrf<button class="nav-link w-100 border-0 bg-transparent"><i class="bi bi-box-arrow-left"></i><span class="logout-label">Sign out</span></button></form>
        </div>
    </aside>
    <div class="main-area"><header class="topbar"><div><div class="eyebrow">{{ ucfirst(auth()->user()->role) }} workspace</div><div class="fw-bold" style="font-family:Manrope">{{ now()->format('l, d M Y') }}</div></div><div class="d-flex align-items-center gap-3"><span class="topbar-role subtle">{{ auth()->user()->role === 'manager' ? 'Team performance at a glance' : 'Your work, all in one place' }}</span><div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div><form method="POST" action="{{ route('logout') }}" class="m-0">@csrf<button type="submit" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-2" title="Sign out"><i class="bi bi-box-arrow-right"></i><span class="d-none d-sm-inline">Logout</span></button></form></div></header>
    <main class="content-wrap">
        @if(session('success'))<div class="alert alert-success d-flex align-items-center gap-2"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger"><div class="fw-bold mb-1">Please check the following:</div><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        @yield('content')
    </main></div>
</div>
@else
@yield('guest-content')
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body></html>
