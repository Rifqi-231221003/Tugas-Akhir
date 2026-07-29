@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan | Exachanger')

@push('styles')
    <style>
        /* Sembunyikan breadcrumb di halaman 404 */
        .breadcrumb-container,
        nav[aria-label="breadcrumb"],
        .breadcrumb {
            display: none !important;
        }

        .error-hero {
            background: #4f79a7;
            color: white;
            padding: 80px 0 100px;
            text-align: center;
        }

        .error-hero h1 {
            font-weight: 700;
            font-size: 2rem;
        }

        .error-hero p {
            font-size: 1rem;
            opacity: 0.95;
            max-width: 800px;
            margin: 1rem auto 0;
        }

        .error-box {
            background: white;
            border-radius: 20px;
            padding: 50px 30px;
            margin-top: -60px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
            text-align: center;
        }

        .error-code {
            font-size: 120px;
            font-weight: 800;
            background: linear-gradient(135deg, #4f79a7, #6b9bc2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 16px;
        }

        .error-description {
            font-size: 16px;
            color: #666;
            max-width: 500px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }

        .error-illustration {
            margin: 30px 0;
        }

        .error-illustration svg {
            width: 200px;
            height: auto;
        }

        .btn-error {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-error:hover {
            background: #3b5f87;
            transform: translateY(-2px);
            color: white;
        }

        .btn-error-outline {
            background: transparent;
            color: #4f79a7;
            border: 2px solid #4f79a7;
            padding: 10px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-error-outline:hover {
            background: #4f79a7;
            color: white;
            transform: translateY(-2px);
        }

        .error-help {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }

        .error-help a {
            color: #4f79a7;
            text-decoration: none;
        }

        .error-help a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .error-hero { padding: 60px 0 80px; }
            .error-hero h1 { font-size: 1.5rem; }
            .error-hero p { font-size: 0.85rem; }
            .error-box { margin-top: -50px; padding: 30px 20px; }
            .error-code { font-size: 80px; }
            .error-title { font-size: 22px; }
            .error-description { font-size: 14px; }
            .btn-error, .btn-error-outline { padding: 10px 20px; font-size: 14px; }
        }

        @media (max-width: 480px) {
            .error-code { font-size: 60px; }
            .error-illustration svg { width: 150px; }
        }
    </style>
@endpush

@section('content')
    <section class="error-hero">
        <div class="container">
            <h1 class="fw-bold">Exachanger</h1>
            <p>Multi-platform digital currencies exchange including PayPal, Skrill, Neteller, AirTM, Payoneer, USDT, USDC, and many more.</p>
        </div>
    </section>

    <div class="container">
        <div class="error-box">
            <div class="error-code">404</div>

            <h2 class="error-title">Page Not Found</h2>

            <div class="error-description">
                Sorry, the page you are looking for cannot be found.<br>
                It may have been moved, removed, or never existed.
            </div>

            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="{{ url('/') }}" class="btn-error">
                    <i class="fas fa-home me-2"></i> Back to Home
                </a>
                <a href="javascript:history.back()" class="btn-error-outline">
                    <i class="fas fa-arrow-left me-2"></i> Previous Page
                </a>
            </div>

            <div class="error-help">
                <i class="fas fa-headset me-2" style="color: #4f79a7;"></i>
                Need assistance? <a href="{{ url('/contact-us') }}">Contact our support</a>
            </div>
        </div>
    </div>
@endsection