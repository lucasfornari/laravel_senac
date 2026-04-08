<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk — Controle de Chamados</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:           #07101f;
            --bg-nav:       #050d19;
            --bg-card:      #0c1828;
            --bg-input:     #081422;
            --border:       rgba(32,160,210,0.15);
            --border-md:    rgba(32,160,210,0.30);
            --border-hi:    rgba(32,160,210,0.55);
            --cyan:         #1ab8e8;
            --cyan-glow:    rgba(0,207,255,0.12);
            --green:        #00e5a0;
            --green-65:     rgba(0,229,160,0.65);
            --green-40:     rgba(0,229,160,0.40);
            --green-15:     rgba(0,229,160,0.15);
            --green-glow:   rgba(0,229,160,0.20);
            --text:         #cce8f5;
            --text-dim:     #7aaec8;
            --text-muted:   #3d7a9a;
            --sidebar-w:    220px;
            --nav-h:        60px;
            --sp-xs:  0.5rem;
            --sp-sm:  0.75rem;
            --sp-md:  1rem;
            --sp-lg:  1.5rem;
            --r-sm:   6px;
            --r-md:   10px;
            --r-lg:   14px;
            --ch-sm:  150px;
            --ch-md:  190px;
            --ch-lg:  210px;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--bg-nav);
            border-right: 1px solid var(--border-md);
            display: flex;
            flex-direction: column;
            z-index: 300;
            overflow: hidden;
        }

        .sidebar-top {
            padding: 1.25rem var(--sp-md);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: var(--sp-sm);
            height: var(--nav-h);
        }

        .sidebar-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--cyan), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-icon svg {
            width: 16px;
            height: 16px;
            fill: #050d19;
        }

        .sidebar-brand {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .sidebar-brand em {
            color: var(--green);
            font-style: normal;
        }

        .sidebar-nav {
            flex: 1;
            padding: var(--sp-md) var(--sp-sm);
            display: flex;
            flex-direction: column;
            gap: 3px;
            overflow-y: auto;
        }

        .sidebar-section {
            font-size: 0.6rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: var(--sp-sm) var(--sp-sm) var(--sp-xs);
            margin-top: var(--sp-xs);
        }

        .side-item {
            display: flex;
            align-items: center;
            gap: var(--sp-sm);
            text-decoration: none;
            color: var(--text-muted);
            padding: 0.62rem var(--sp-sm);
            border-radius: var(--r-md);
            border: 1px solid transparent;
            font-size: 0.87rem;
            font-weight: 400;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
            cursor: pointer;
        }

        .side-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: 0.6;
            transition: opacity 0.15s;
        }

        .side-item:hover {
            background: rgba(0,229,160,0.06);
            color: var(--text-dim);
            border-color: var(--border);
        }

        .side-item:hover svg { opacity: 0.9; }

        .side-item.active {
            background: rgba(0,229,160,0.10);
            color: var(--text);
            border-color: var(--border-md);
            font-weight: 500;
        }

        .side-item.active svg {
            opacity: 1;
            filter: drop-shadow(0 0 4px var(--green-glow));
        }

        .side-item .badge {
            margin-left: auto;
            background: var(--green-15);
            color: var(--green);
            font-size: 0.65rem;
            font-weight: 600;
            padding: 1px 6px;
            border-radius: 999px;
            border: 1px solid rgba(0,229,160,0.3);
        }

        .sidebar-footer {
            padding: var(--sp-sm);
            border-top: 1px solid var(--border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: var(--sp-sm);
            padding: var(--sp-xs) var(--sp-sm);
            border-radius: var(--r-md);
            cursor: pointer;
            transition: background 0.15s;
        }

        .sidebar-user:hover { background: rgba(32,160,210,0.06); }

        .sidebar-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cyan), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            color: #050d19;
            flex-shrink: 0;
        }

        .sidebar-user-info { overflow: hidden; }

        .sidebar-user-name {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-dim);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.68rem;
            color: var(--text-muted);
        }

        /* ══════════════════════════════════════
           NAVBAR
        ══════════════════════════════════════ */
        .navbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            z-index: 200;
            height: var(--nav-h);
            background: var(--bg-nav);
            border-bottom: 1px solid var(--border-md);
            display: flex;
            align-items: center;
            padding: 0 var(--sp-lg);
            gap: var(--sp-md);
            box-shadow: 0 2px 20px rgba(0,0,0,0.4);
        }

        .nav-page {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-dim);
            letter-spacing: 0.06em;
        }

        .nav-space { flex: 1; }

        .nav-kpis {
            display: flex;
            align-items: stretch;
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border-md);
            border-radius: var(--r-md);
            overflow: hidden;
            flex-shrink: 0;
        }

        .nav-kpi {
            padding: 0.28rem var(--sp-md);
            background: var(--bg-card);
            text-align: center;
            min-width: 88px;
        }

        .nav-kpi-label {
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            line-height: 1;
            margin-bottom: 2px;
        }

        .nav-kpi-val {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--green);
            line-height: 1;
        }

        .nav-kpi-val.big { font-size: 1rem; }

        .nav-date {
            display: flex;
            flex-direction: column;
            gap: 3px;
            flex-shrink: 0;
        }

        .nav-date-label {
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .nav-date-row { display: flex; gap: var(--sp-xs); }

        .nav-sel {
            background: var(--bg-input);
            border: 1px solid var(--border-md);
            border-radius: var(--r-sm);
            color: var(--text-dim);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            padding: 0.22rem 0.5rem;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            transition: border-color 0.18s;
        }

        .nav-sel:focus { border-color: var(--cyan); }
        .nav-sel.wide  { min-width: 90px; }

        .nav-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cyan), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: #05111a;
            cursor: pointer;
            flex-shrink: 0;
            border: 2px solid transparent;
            transition: border-color 0.2s;
        }

        .nav-avatar:hover { border-color: var(--green); }

        /* ══════════════════════════════════════
           PAGE
        ══════════════════════════════════════ */
        .page {
            margin-left: var(--sidebar-w);
            margin-top: var(--nav-h);
            padding: var(--sp-lg);
            display: flex;
            flex-direction: column;
            gap: var(--sp-md);
            min-height: calc(100vh - var(--nav-h));
        }

        /* ══════════════════════════════════════
           FILTER BAR
        ══════════════════════════════════════ */
        .filters {
            display: flex;
            align-items: flex-end;
            gap: var(--sp-md);
            flex-wrap: wrap;
            padding: var(--sp-sm) var(--sp-md);
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
        }

        .filter-field {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-field label {
            font-size: 0.63rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .filter-sel {
            background: var(--bg-input);
            border: 1.5px solid var(--border-md);
            border-radius: var(--r-sm);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            padding: 0.4rem 2rem 0.4rem var(--sp-sm);
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            min-width: 140px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%233d7a9a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.55rem center;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .filter-sel:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px var(--cyan-glow);
        }

        .filter-note {
            margin-left: auto;
            font-size: 0.72rem;
            color: var(--text-muted);
            font-style: italic;
            align-self: center;
        }

        /* ══════════════════════════════════════
           CARDS
        ══════════════════════════════════════ */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: var(--sp-md) var(--sp-lg);
            box-shadow: 0 2px 16px rgba(0,0,0,0.22);
            display: flex;
            flex-direction: column;
            gap: var(--sp-sm);
            animation: cardIn 0.38s ease both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card:nth-child(1) { animation-delay: 0.00s; }
        .card:nth-child(2) { animation-delay: 0.05s; }
        .card:nth-child(3) { animation-delay: 0.10s; }
        .card:nth-child(4) { animation-delay: 0.15s; }
        .card:nth-child(5) { animation-delay: 0.20s; }
        .card:nth-child(6) { animation-delay: 0.25s; }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 0.67rem;
            font-weight: 500;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .card-title::before {
            content: '';
            width: 3px;
            height: 11px;
            border-radius: 2px;
            background: var(--green);
            box-shadow: 0 0 8px var(--green-glow);
            flex-shrink: 0;
        }

        .chart-box {
            position: relative;
            width: 100%;
            flex: 1;
            min-height: var(--ch-sm);
        }

        .chart-box canvas {
            position: absolute;
            inset: 0;
            width: 100% !important;
            height: 100% !important;
        }

        .chart-box--md { min-height: var(--ch-md); }
        .chart-box--lg { min-height: var(--ch-lg); }

        /* ══════════════════════════════════════
           DASHBOARD GRIDS
        ══════════════════════════════════════ */
        .dash-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--sp-md);
        }

        .dash-col {
            display: flex;
            flex-direction: column;
            gap: var(--sp-md);
        }

        .dash-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--sp-md);
        }

        /* ══════════════════════════════════════
           PROFILE MODAL
        ══════════════════════════════════════ */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(4,10,22,0.55);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
            padding: calc(var(--nav-h) + 8px) var(--sp-lg) 0;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.18s ease;
        }

        .modal-backdrop.open {
            opacity: 1;
            pointer-events: all;
        }

        .profile-modal {
            background: var(--bg-card);
            border: 1px solid var(--border-md);
            border-radius: var(--r-lg);
            width: 272px;
            box-shadow: 0 12px 48px rgba(0,0,0,0.65), 0 0 0 1px rgba(0,0,0,0.4);
            transform: translateY(-10px) scale(0.97);
            transition: transform 0.22s cubic-bezier(.22,.68,0,1.2);
            overflow: hidden;
        }

        .modal-backdrop.open .profile-modal {
            transform: translateY(0) scale(1);
        }

        .pm-header {
            padding: var(--sp-md);
            background: linear-gradient(135deg, rgba(0,207,255,0.06), rgba(0,229,160,0.04));
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: var(--sp-sm);
        }

        .pm-avatar-lg {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--cyan), var(--green));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #05111a;
            flex-shrink: 0;
            box-shadow: 0 0 16px var(--green-glow);
        }

        .pm-info { overflow: hidden; }

        .pm-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pm-email {
            font-size: 0.73rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 1px;
        }

        .pm-body { padding: var(--sp-xs) 0; }

        .pm-item {
            display: flex;
            align-items: center;
            gap: var(--sp-sm);
            padding: 0.58rem var(--sp-md);
            color: var(--text-dim);
            font-size: 0.87rem;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.14s, color 0.14s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
        }

        .pm-item:hover { background: rgba(32,160,210,0.08); color: var(--text); }

        .pm-item svg { width: 15px; height: 15px; flex-shrink: 0; opacity: 0.65; }
        .pm-item:hover svg { opacity: 1; }

        .pm-divider { height: 1px; background: var(--border); margin: var(--sp-xs) 0; }

        .pm-item.danger { color: #e07070; }
        .pm-item.danger:hover { background: rgba(255,80,80,0.08); color: #ff7b7b; }
        .pm-item.danger svg { opacity: 1; }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media (max-width: 1100px) {
            .nav-kpis { display: none; }
            :root { --sidebar-w: 60px; }
            .sidebar-brand, .sidebar-section,
            .side-item span, .sidebar-user-info,
            .side-item .badge { display: none; }
            .side-item { justify-content: center; padding: 0.62rem; }
            .sidebar-top { justify-content: center; padding: var(--sp-sm); }
            .sidebar-brand-wrap { display: none; }
            .sidebar-user { justify-content: center; }
            .sidebar-user-avatar { margin: 0; }
        }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .sidebar { display: none; }
            .navbar { left: 0; }
            .page { margin-left: 0; }
            .dash-grid   { grid-template-columns: 1fr; }
            .dash-bottom { grid-template-columns: 1fr; }
            .nav-date    { display: none; }
        }
    </style>
</head>
<body>

{{-- ══ SIDEBAR ══ --}}
<aside class="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12h6M9 16h6M17 4H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"/>
            </svg>
        </div>
        <div class="sidebar-brand-wrap">
            <span class="sidebar-brand">Help<em>Desk</em></span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <span class="sidebar-section">Principal</span>

        <a href="#" class="side-item active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="#" class="side-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/>
                <line x1="9" y1="17" x2="15" y2="17"/><line x1="9" y1="9" x2="11" y2="9"/>
            </svg>
            <span>Gestão de Tickets</span>
            <span class="badge">124</span>
        </a>

        <span class="sidebar-section">Administração</span>

        <a href="#" class="side-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Usuários</span>
        </a>

        <a href="#" class="side-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <span>Relatórios</span>
        </a>

        <a href="#" class="side-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
            <span>Configurações</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Usuário' }}</div>
                <div class="sidebar-user-role">Administrador</div>
            </div>
        </div>
    </div>
</aside>

{{-- ══ NAVBAR ══ --}}
<header class="navbar">
    <span class="nav-page">Controle de Chamados</span>
    <div class="nav-space"></div>

    <div class="nav-kpis">
        <div class="nav-kpi">
            <div class="nav-kpi-label">Técnicos</div>
            <div class="nav-kpi-val">8</div>
        </div>
        <div class="nav-kpi">
            <div class="nav-kpi-label">Chamados Abertos</div>
            <div class="nav-kpi-val">124</div>
        </div>
        <div class="nav-kpi">
            <div class="nav-kpi-label">SLA Médio</div>
            <div class="nav-kpi-val big">4h 12m</div>
        </div>
    </div>

        <div class="nav-avatar" id="avatarBtn" role="button" tabindex="0" title="{{ auth()->user()->name ?? 'Usuário' }}">
        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
    </div>
</header>

{{-- ══ PROFILE MODAL ══ --}}
<div class="modal-backdrop" id="profileBackdrop">
    <div class="profile-modal" id="profileModal">
        <div class="pm-header">
            <div class="pm-avatar-lg">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            <div class="pm-info">
                <div class="pm-name">{{ auth()->user()->name ?? 'Usuário' }}</div>
                <div class="pm-email">{{ auth()->user()->email ?? '' }}</div>
            </div>
        </div>
        <div class="pm-body">
            <a href="#" class="pm-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                Meu Perfil
            </a>
            <a href="#" class="pm-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                Configurações
            </a>
            <div class="pm-divider"></div>
            <form method="POST" action="/logout" style="margin:0;">
                @csrf
                <button type="submit" class="pm-item danger">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Sair da Conta
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ══ PAGE ══ --}}
<main class="page">

    {{-- Filtros --}}
    <div class="filters">
        <div class="filter-field">
            <label for="f-categoria">Categoria</label>
            <select class="filter-sel" id="f-categoria">
                <option>Todas</option>
                <option>Infraestrutura</option>
                <option>Software</option>
                <option>Hardware</option>
                <option>Rede</option>
            </select>
        </div>
        <div class="filter-field">
            <label for="f-responsavel">Responsável</label>
            <select class="filter-sel" id="f-responsavel">
                <option>Todos</option>
            </select>
        </div>
        <div class="filter-field">
            <label for="f-prioridade">Prioridade</label>
            <select class="filter-sel" id="f-prioridade">
                <option>Todas</option>
                <option>Baixa</option>
                <option>Média</option>
                <option>Alta</option>
                <option>Crítica</option>
            </select>
        </div>
        <span class="filter-note">Nenhum filtro aplicado</span>
    </div>

    {{-- Grid principal --}}
    <div class="dash-grid">

        <div class="dash-col">
            <div class="card">
                <div class="card-head">
                    <span class="card-title">Status dos Chamados</span>
                </div>
                <div class="chart-box chart-box--md">
                    <canvas id="cStatus"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <span class="card-title">Categoria</span>
                </div>
                <div class="chart-box">
                    <canvas id="cCategoria"></canvas>
                </div>
            </div>
        </div>

        <div class="dash-col">
            <div class="card">
                <div class="card-head">
                    <span class="card-title">Prioridade</span>
                </div>
                <div class="chart-box chart-box--md">
                    <canvas id="cPrioridade"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <span class="card-title">SLA por Faixa</span>
                </div>
                <div class="chart-box">
                    <canvas id="cSla"></canvas>
                </div>
            </div>
        </div>

    </div>

    {{-- Grid inferior --}}
    <div class="dash-bottom">

        <div class="card">
            <div class="card-head">
                <span class="card-title">Chamados por Horário</span>
            </div>
            <div class="chart-box chart-box--lg">
                <canvas id="cHorario"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span class="card-title">Evolução Mensal</span>
            </div>
            <div class="chart-box chart-box--lg">
                <canvas id="cEvolucao"></canvas>
            </div>
        </div>

    </div>

</main>

<script>
/* ── Defaults ── */
Chart.defaults.color       = '#3d7a9a';
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.font.size   = 11;
Chart.defaults.borderColor = 'rgba(32,160,210,0.08)';

const G    = '#00e5a0';
const G65  = 'rgba(0,229,160,0.65)';
const G45  = 'rgba(0,229,160,0.45)';
const G25  = 'rgba(0,229,160,0.25)';
const G10  = 'rgba(0,229,160,0.10)';
const MUT  = '#3d7a9a';
const DIM  = '#7aaec8';
const GRID = 'rgba(32,160,210,0.08)';
const bar  = { borderRadius: 4, borderSkipped: false };

/* ── Status (horizontal) ── */
new Chart(document.getElementById('cStatus'), {
    type: 'bar',
    data: {
        labels: ['ABERTO','EM ANDAMENTO','RESOLVIDO','CANCELADO'],
        datasets: [{
            data: [38, 29, 26, 7],
            backgroundColor: [G, G65, G45, G25],
            ...bar,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.parsed.x}%` } }
        },
        scales: {
            x: { max: 50, grid: { color: GRID }, ticks: { callback: v => v+'%', color: MUT } },
            y: { grid: { display: false }, ticks: { color: DIM, font: { size: 10 } } }
        }
    }
});

/* ── Categoria (horizontal) ── */
new Chart(document.getElementById('cCategoria'), {
    type: 'bar',
    data: {
        labels: ['Software','Hardware','Rede','Infraestrutura'],
        datasets: [{
            data: [42, 24, 20, 14],
            backgroundColor: [G, G65, G45, G25],
            ...bar,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.parsed.x}%` } }
        },
        scales: {
            x: { max: 55, grid: { color: GRID }, ticks: { callback: v => v+'%', color: MUT } },
            y: { grid: { display: false }, ticks: { color: DIM, font: { size: 10 } } }
        }
    }
});

/* ── Prioridade (vertical) ── */
new Chart(document.getElementById('cPrioridade'), {
    type: 'bar',
    data: {
        labels: ['Baixa','Média','Alta','Crítica'],
        datasets: [{
            data: [30, 40, 20, 10],
            backgroundColor: [G25, G45, G65, G],
            hoverBackgroundColor: G,
            ...bar,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.parsed.y}%` } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { color: MUT } },
            y: { grid: { color: GRID }, ticks: { callback: v => v+'%', color: MUT } }
        }
    }
});

/* ── SLA (vertical) ── */
new Chart(document.getElementById('cSla'), {
    type: 'bar',
    data: {
        labels: ['≤1h','≤4h','≤8h','≤24h','>24h'],
        datasets: [{
            data: [18, 32, 27, 15, 8],
            backgroundColor: G65,
            hoverBackgroundColor: G,
            ...bar,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.parsed.y}%` } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { color: MUT } },
            y: { grid: { color: GRID }, ticks: { callback: v => v+'%', color: MUT } }
        }
    }
});

/* ── Chamados por Horário (histogram) ── */
new Chart(document.getElementById('cHorario'), {
    type: 'bar',
    data: {
        labels: Array.from({ length: 24 }, (_, i) => `${String(i).padStart(2,'0')}h`),
        datasets: [{
            data: [1,0,0,0,0,1,3,8,14,16,18,15,12,16,17,14,10,8,6,4,3,2,1,1],
            backgroundColor: G65,
            hoverBackgroundColor: G,
            borderRadius: 3,
            borderSkipped: false,
            barPercentage: 0.85,
            categoryPercentage: 0.9,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: c => ` ${c.parsed.y} chamados` } }
        },
        scales: {
            x: { grid: { display: false }, ticks: { color: MUT, maxRotation: 0 } },
            y: { grid: { color: GRID }, ticks: { color: MUT } }
        }
    }
});

/* ── Evolução Mensal (linha) ── */
new Chart(document.getElementById('cEvolucao'), {
    type: 'line',
    data: {
        labels: ['Jul','Ago','Set','Out','Nov','Dez','Jan'],
        datasets: [
            {
                label: 'Abertos',
                data: [98, 112, 87, 134, 119, 95, 124],
                borderColor: G,
                backgroundColor: (ctx) => {
                    const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, ctx.chart.height);
                    g.addColorStop(0, 'rgba(0,229,160,0.16)');
                    g.addColorStop(1, 'rgba(0,229,160,0.01)');
                    return g;
                },
                pointBackgroundColor: G,
                pointBorderColor: '#07101f',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2.5,
                tension: 0.38,
                fill: true,
            },
            {
                label: 'Resolvidos',
                data: [84, 103, 79, 118, 108, 91, 110],
                borderColor: 'rgba(26,184,232,0.8)',
                backgroundColor: 'transparent',
                pointBackgroundColor: 'rgba(26,184,232,0.8)',
                pointBorderColor: '#07101f',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                borderDash: [5, 3],
                tension: 0.38,
                fill: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                align: 'end',
                labels: {
                    color: MUT,
                    boxWidth: 10,
                    boxHeight: 2,
                    padding: 12,
                    font: { size: 10 }
                }
            },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            x: { grid: { display: false }, ticks: { color: MUT } },
            y: { grid: { color: GRID }, ticks: { color: MUT } }
        }
    }
});

/* ── Profile modal ── */
(function () {
    const btn      = document.getElementById('avatarBtn');
    const backdrop = document.getElementById('profileBackdrop');
    const modal    = document.getElementById('profileModal');

    const open  = () => { backdrop.classList.add('open');    btn.setAttribute('aria-expanded','true'); };
    const close = () => { backdrop.classList.remove('open'); btn.setAttribute('aria-expanded','false'); };

    btn.addEventListener('click', e => { e.stopPropagation(); backdrop.classList.contains('open') ? close() : open(); });
    btn.addEventListener('keydown', e => { if (e.key==='Enter'||e.key===' ') { e.preventDefault(); open(); } });
    backdrop.addEventListener('click', e => { if (!modal.contains(e.target)) close(); });
    document.addEventListener('keydown', e => { if (e.key==='Escape') close(); });
})();
</script>
</body>
</html>