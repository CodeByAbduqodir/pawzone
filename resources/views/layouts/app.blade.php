<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#f4f7fb">
    <title>@yield('title', 'PawZone - Uy hayvonlari platformasi')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --bg: #f4f7fb;
            --surface: rgba(255, 255, 255, 0.82);
            --surface-strong: #ffffff;
            --line: rgba(15, 23, 42, 0.08);
            --text: #10233f;
            --muted: #667085;
            --primary: #3b82f6;
            --primary-strong: #2563eb;
            --primary-soft: rgba(59, 130, 246, 0.12);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
            --shadow-soft: 0 10px 24px rgba(15, 23, 42, 0.06);
            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 16px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.10), transparent 28%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.08), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef3f9 100%);
            overflow-x: hidden;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            inset: auto;
            width: 22rem;
            height: 22rem;
            border-radius: 999px;
            filter: blur(60px);
            opacity: 0.45;
            pointer-events: none;
            z-index: 0;
        }

        body::before {
            top: -8rem;
            left: -8rem;
            background: rgba(59, 130, 246, 0.18);
        }

        body::after {
            bottom: -10rem;
            right: -8rem;
            background: rgba(16, 185, 129, 0.16);
        }

        a {
            color: inherit;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .site-shell {
            position: relative;
            z-index: 1;
        }

        .page-wrap {
            padding: 1.5rem 0 4rem;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.78) !important;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 10px 32px rgba(15, 23, 42, 0.06);
        }

        .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text) !important;
            letter-spacing: -0.04em;
        }

        .brand-mark {
            width: 2.75rem;
            height: 2.75rem;
            display: grid;
            place-items: center;
            border-radius: 0.95rem;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            color: #fff;
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.25);
        }

        .nav-link {
            color: var(--muted) !important;
            font-weight: 600;
            border-radius: 999px;
            padding: 0.65rem 1rem !important;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active,
        .nav-link.fw-bold {
            color: var(--text) !important;
            background: rgba(59, 130, 246, 0.10);
        }

        .dropdown-menu {
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 0.55rem;
        }

        .dropdown-item,
        .dropdown-item-text {
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.08);
        }

        .glass-container,
        .hero-surface,
        .section-card,
        .table-card,
        .form-card,
        .auth-card,
        .support-note {
            background: var(--surface);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
            border-radius: var(--radius-xl);
        }

        .glass-container {
            padding: clamp(1.25rem, 2vw, 2rem);
        }

        .hero-surface {
            padding: clamp(1.4rem, 3vw, 2.4rem);
        }

        .section-card,
        .table-card,
        .form-card,
        .auth-card {
            padding: clamp(1.15rem, 2vw, 1.6rem);
        }

        .page-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--line);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.10);
            color: var(--primary-strong);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .page-title {
            margin: 0.65rem 0 0;
            font-size: clamp(1.9rem, 3vw, 2.9rem);
            line-height: 1.05;
        }

        .page-subtitle {
            margin: 0.75rem 0 0;
            max-width: 64ch;
            color: var(--muted);
        }

        .page-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.25fr) minmax(280px, 0.75fr);
            gap: 1rem;
            align-items: center;
        }

        @media (max-width: 991.98px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            background: rgba(16, 185, 129, 0.10);
            color: #0f766e;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0.85rem 0 0;
            font-size: clamp(2rem, 4vw, 3.5rem);
            line-height: 1.03;
        }

        .hero-subtitle {
            margin: 0.95rem 0 0;
            color: var(--muted);
            font-size: 1.05rem;
            max-width: 58ch;
        }

        .hero-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            margin-top: 1.1rem;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 0.9rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--line);
            color: var(--text);
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: var(--shadow-soft);
        }

        .chip-soft {
            background: rgba(59, 130, 246, 0.10);
            color: var(--primary-strong);
        }

        .chip-success {
            background: rgba(16, 185, 129, 0.10);
            color: #047857;
        }

        .btn {
            border-radius: 999px;
            font-weight: 700;
        }

        .btn-gradient,
        .btn-gradient-success,
        .btn-gradient-secondary {
            position: relative;
            overflow: hidden;
            border: none;
            color: #fff;
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), #7c3aed);
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, #10b981, #06b6d4);
        }

        .btn-gradient-secondary {
            background: linear-gradient(135deg, #0f172a, #334155);
        }

        .btn-gradient:hover,
        .btn-gradient-success:hover,
        .btn-gradient-secondary:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.16);
        }

        .badge-modern {
            padding: 0.55rem 0.85rem;
            border-radius: 999px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .badge-available {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .badge-resolved {
            background: rgba(100, 116, 139, 0.12);
            color: #334155;
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            background: var(--surface-strong);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .card-img-top {
            object-fit: cover;
        }

        .category-filter-card {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.85rem 1rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid var(--line);
            box-shadow: var(--shadow-soft);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .category-filter-card:hover,
        .category-filter-card.active {
            transform: translateY(-1px);
            border-color: rgba(59, 130, 246, 0.22);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.09);
        }

        .category-filter-card.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.10));
        }

        .category-icon {
            font-size: 1.2rem;
            line-height: 1;
        }

        .category-name {
            font-weight: 700;
            color: var(--text);
        }

        .stat-card {
            padding: 1.1rem 1.15rem;
        }

        .stat-value {
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .stat-label {
            margin-top: 0.35rem;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .support-note {
            padding: 1rem 1.1rem;
            background: rgba(59, 130, 246, 0.08);
        }

        .table-card .table,
        .section-card .table {
            margin-bottom: 0;
        }

        .table thead th {
            color: var(--muted);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .table > :not(caption) > * > * {
            background: transparent;
            border-bottom-color: rgba(15, 23, 42, 0.06);
            vertical-align: middle;
        }

        .form-control,
        .form-select {
            min-height: 48px;
            border-radius: 14px;
            border: 1px solid #d7e0ec;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(59, 130, 246, 0.48);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.12);
        }

        .form-label {
            font-weight: 700;
            color: var(--text);
        }

        .input-group-text {
            border-radius: 14px;
            border-color: #d7e0ec;
            background: #fff;
        }

        .alert {
            border-radius: 18px;
            border: 1px solid transparent;
            box-shadow: var(--shadow-soft);
        }

        .alert-success {
            background: #ecfdf5;
            border-color: #bbf7d0;
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border-color: #fde68a;
            color: #92400e;
        }

        .alert-info {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--muted);
        }

        .empty-state .emoji {
            font-size: 3rem;
            margin-bottom: 0.75rem;
        }

        .hero-panel {
            border-radius: 28px;
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.10));
            border: 1px solid rgba(59, 130, 246, 0.10);
        }

        .profile-avatar {
            width: 2.5rem;
            height: 2.5rem;
            display: inline-grid;
            place-items: center;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            color: #fff;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.20);
        }

        .meta-grid {
            display: grid;
            gap: 0.85rem;
        }

        .meta-item {
            padding: 0.95rem 1rem;
            border-radius: 18px;
            background: rgba(15, 23, 42, 0.03);
            border: 1px solid rgba(15, 23, 42, 0.05);
        }

        footer {
            position: relative;
            z-index: 1;
            margin-top: 3rem;
            background: #0f172a;
            color: rgba(255, 255, 255, 0.82);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        footer a {
            color: #fff;
            opacity: 0.82;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        footer a:hover {
            opacity: 1;
            transform: translateX(2px);
        }

        @media (max-width: 767.98px) {
            .page-wrap {
                padding-top: 1rem;
            }

            .glass-container,
            .hero-surface {
                border-radius: 22px;
            }

            .category-filter-card {
                padding: 0.75rem 0.9rem;
            }
        }
    </style>

    @yield('styles')
    @stack('styles')
</head>

<body>
    <div class="site-shell">
        @include('partials.header')

        <main class="page-wrap">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
