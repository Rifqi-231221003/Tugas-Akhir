@extends('layouts.app')

@section('title', 'Track Transaction - Exachanger | Check Your Transaction Status')

@section('meta_description', 'Track your digital currency exchange transaction status at Exachanger. Enter your transaction ID to get real-time updates on PayPal, Skrill, USDT, and other currency exchanges.')

@section('meta_keywords', 'track transaction, exchange status, check transaction, Exachanger tracking, digital currency tracking')

@section('canonical', url('/track-transaction'))

@push('styles')
    <style>
        /* ========================================== */
        /* TRACK TRANSACTION PAGE SPECIFIC STYLES */
        /* ========================================== */
        .track-hero {
            background: linear-gradient(135deg, #4f79a7, #3b5f87);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .track-hero h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .track-hero p {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        .track-box {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-top: -50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .track-box h4 {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #4f79a7;
            box-shadow: 0 0 0 3px rgba(79, 121, 167, 0.1);
        }

        .btn-track {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-track:hover {
            background: #3b5f87;
            transform: translateY(-2px);
        }

        .result-container {
            margin-top: 30px;
        }

        .alert {
            border-radius: 12px;
        }

        /* ========================================== */
        /* TRACK TRANSACTION MOBILE RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .track-hero h1 {
                font-size: 1.8rem;
            }
            .track-box {
                margin-top: -30px;
                padding: 30px 20px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="track-hero">
        <div class="container">
            <h1>Track Your Transaction</h1>
            <p>We are ready to help and serve you wholeheartedly. Exachanger treats customers like royalty!</p>
        </div>
    </section>

    <div class="container">
        <div class="track-box">
            <h4><i class="fas fa-search me-2"></i> Track Your Order</h4>
            
            <form action="{{ route('track.transaction.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Transaction ID</label>
                    <input type="text" name="trx_id" class="form-control @error('trx_id') is-invalid @enderror" 
                           placeholder="Enter your transaction ID (e.g., TRX-XXXXXXXXX)" 
                           value="{{ old('trx_id') }}" required>
                    @error('trx_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-2 d-block">Enter the Transaction ID you received after uploading your payment proof.</small>
                </div>
                <button type="submit" class="btn-track">
                    <i class="fas fa-arrow-right me-2"></i> Track Order
                </button>
            </form>

            @if(session('error'))
                <div class="result-container">
                    <div class="alert alert-danger text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script khusus track-transaction jika diperlukan
    </script>
@endpush