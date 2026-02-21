<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'PawZone - Uy hayvonlari do\'koni')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --dark: #1a1a2e;
            --light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* Отключение всех анимаций и трансформаций */
            transition: none !important;
            animation: none !important;
            transform: none !important;
        }

        /* Квадратные элементы без скругления */
        .btn,
        .card,
        .form-control,
        .input-group-text,
        .dropdown-menu,
        .badge,
        .glass-container,
        .category-filter-card {
            border-radius: 0 !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to bottom, #667eea, #764ba2, #f093fb);
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--dark);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        /* Glassmorphism Container */
        .glass-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 30px auto;
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%) !important;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 1.2rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 5px 10px;
        }

        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(5px);
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Button Styles */
        .btn-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .btn-gradient:hover::before {
            left: 100%;
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.6);
        }

        .btn-gradient-secondary {
            background: var(--secondary-gradient);
            box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
        }

        .btn-gradient-secondary:hover {
            box-shadow: 0 15px 35px rgba(245, 87, 108, 0.6);
        }

        .btn-gradient-success {
            background: var(--success-gradient);
            box-shadow: 0 10px 25px rgba(67, 233, 123, 0.4);
        }

        /* Badge Styles */
        .badge-modern {
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .badge-available {
            background: var(--success-gradient);
            color: white;
        }

        .badge-resolved {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        /* Price Styling */
        .price {
            font-size: 1.8rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 15px 0;
        }

        /* Footer */
        footer {
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            color: rgba(255, 255, 255, 0.8);
            margin-top: 100px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        footer a {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: white;
            transform: translateX(5px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Hero Section */
        .hero-section {
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            letter-spacing: -2px;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            font-weight: 300;
        }

        /* Feature Cards */
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* Category Filter Cards */
        .category-filter-card {
            background: white;
            border-radius: 20px;
            padding: 25px 15px;
            text-align: center;
            border: 3px solid transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .category-filter-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }

        .category-filter-card:hover::before {
            opacity: 0.1;
        }

        .category-filter-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.3);
            border-color: transparent;
        }

        .category-filter-card.active {
            background: var(--primary-gradient);
            border-color: transparent;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
            transform: translateY(-5px);
        }

        .category-filter-card.active .category-icon,
        .category-filter-card.active .category-name {
            color: white;
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .category-filter-card:hover .category-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .category-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            color: var(--dark);
            transition: color 0.3s ease;
            position: relative;
            z-index: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .glass-container {
                padding: 20px;
                border-radius: 20px;
            }

            .category-filter-card {
                padding: 20px 10px;
            }

            .category-icon {
                font-size: 2.5rem;
            }

            .category-name {
                font-size: 0.9rem;
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Header/Navbar -->
    @include('partials.header')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>