<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="msvalidate.01" content="0C7540A83849F74EFE08C9E68C009D03" />
    
    <title>@yield('title', 'Exachanger - Trusted Digital Currency Exchange')</title>
    <meta name="description" content="@yield('meta_description', 'Exchange digital currencies instantly at Exachanger. Best rates for PayPal, Skrill, Neteller, AirTM, Payoneer, USDT, USDC. Fast and secure.')">
    <meta name="keywords" content="@yield('meta_keywords', 'digital currency exchange, PayPal exchange, Skrill exchange, Neteller exchange')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="author" content="Exachanger">
    <meta name="robots" content="index, follow">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8f9fa;
        }
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #4f79a7 !important;
        }
        .nav-link {
            font-weight: 500;
            color: #333 !important;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #4f79a7 !important;
        }
        .nav-link.active {
            color: #4f79a7 !important;
            font-weight: 600;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 60px 0 30px;
            margin-top: 3rem;
        }
        .footer h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        .footer a {
            color: #ccc;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
        }
        .footer ul {
            padding-left: 0;
        }
        .footer li {
            list-style: none;
            margin-bottom: 0.75rem;
        }
        .contact-info p {
            margin-bottom: 0.75rem;
            color: #ccc;
        }
        .contact-info i {
            width: 30px;
            color: #4f79a7;
        }
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #aaa;
            font-size: 0.85rem;
        }
        .chat-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #25D366;
            color: white;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.3s;
            text-decoration: none;
        }
        .chat-float:hover {
            transform: scale(1.1);
            color: white;
        }
        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
            }
            .footer .row {
                text-align: center;
            }
            .footer .col-md-4, 
            .footer .col-md-3, 
            .footer .col-md-5 {
                margin-bottom: 30px;
            }
            .footer h5 {
                margin-bottom: 1rem;
                font-size: 1rem;
            }
            .contact-info {
                text-align: left;
                max-width: 280px;
                margin: 0 auto;
            }
            .copyright {
                font-size: 0.7rem;
                padding-top: 1.5rem;
                margin-top: 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Core Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>