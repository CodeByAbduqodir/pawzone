<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PawZone') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f7fb;
            --surface: rgba(255, 255, 255, 0.86);
            --line: rgba(15, 23, 42, 0.08);
            --text: #10233f;
            --muted: #667085;
            --primary: #3b82f6;
        }

        * { box-sizing: border-box; }
        html, body { margin: 0; min-height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(59, 130, 246, 0.12), transparent 28%),
                radial-gradient(circle at top right, rgba(16, 185, 129, 0.08), transparent 24%),
                linear-gradient(180deg, #f8fbff 0%, #eef3f9 100%);
        }
        .wrap {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
        }
        .card {
            width: min(960px, 100%);
            background: var(--surface);
            backdrop-filter: blur(18px);
            border: 1px solid var(--line);
            box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
            border-radius: 28px;
            padding: clamp(24px, 5vw, 48px);
        }
        h1, h2, h3 { font-family: 'Poppins', sans-serif; letter-spacing: -0.04em; margin: 0; }
        h1 { font-size: clamp(2.2rem, 5vw, 4rem); line-height: 1.02; }
        p { color: var(--muted); line-height: 1.6; }
        .grid {
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 24px;
            align-items: center;
        }
        @media (max-width: 900px) {
            .grid { grid-template-columns: 1fr; }
        }
        .kicker {
            display: inline-flex;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .chips { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .chip {
            display: inline-flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            font-weight: 600;
        }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 999px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #7c3aed);
            color: #fff;
            box-shadow: 0 12px 24px rgba(59, 130, 246, 0.22);
        }
        .btn-secondary {
            background: #fff;
            color: var(--text);
            border: 1px solid var(--line);
        }
        .panel {
            border-radius: 24px;
            padding: 20px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(16, 185, 129, 0.10));
            border: 1px solid rgba(59, 130, 246, 0.10);
        }
        .panel h3 { font-size: 1.1rem; margin-bottom: 8px; }
        .panel .meta { display: grid; gap: 10px; margin-top: 16px; }
        .panel .meta div { padding: 12px 14px; border-radius: 16px; background: rgba(255,255,255,0.75); border: 1px solid var(--line); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="grid">
                <div>
                    <span class="kicker">PawZone</span>
                    <h1>Hayvonlar uchun sodda va chiroyli platforma</h1>
                    <p>
                        Yo'qolgan va topilgan hayvonlar bo'yicha e'lonlar, foydalanuvchi kabineti va admin boshqaruvi
                        birlashgan, qulay ko'rinishda.
                    </p>

                    <div class="chips">
                        <span class="chip">Katalog</span>
                        <span class="chip">Kabinet</span>
                        <span class="chip">Moderatsiya</span>
                    </div>

                    <div class="actions">
                        <a class="btn btn-primary" href="{{ route('pets.index') }}">E'lonlarni ko'rish</a>
                        @auth
                            <a class="btn btn-secondary" href="{{ route('dashboard') }}">Kabinet</a>
                        @else
                            <a class="btn btn-secondary" href="{{ route('login') }}">Kirish</a>
                        @endauth
                    </div>
                </div>

                <div class="panel">
                    <h3>Qisqa ko'rinish</h3>
                    <p class="mb-0">UI endi bir xil uslubda ishlaydi: toza fon, yumshoq kartalar va oson o'qiladigan kontent.</p>
                    <div class="meta">
                        <div>✨ Modern glassy surfaces</div>
                        <div>📱 Mobile-first layout</div>
                        <div>🎯 Aniq harakat tugmalari</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
