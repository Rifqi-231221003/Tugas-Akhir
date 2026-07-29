@extends('layouts.app')

@section('title', 'Exachanger - Trusted Digital Currency Exchange')

@section('meta_description', 'Exchange digital currencies instantly at Exachanger. Best rates for PayPal, Skrill, Neteller, AirTM, Payoneer, USDT, USDC. Fast, secure, and trusted platform.')
@section('meta_keywords', 'digital currency exchange, PayPal exchange, Skrill exchange, Neteller exchange, USDT exchange, crypto exchange, best exchange rate')
@section('canonical', url('/'))

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* ========================================== */
        /* HOME PAGE SPECIFIC STYLES */
        /* ========================================== */
        .hero {
            background: #4f79a7;
            color: white;
            padding: 80px 0 120px;
            text-align: center;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
            opacity: 0.95;
            max-width: 800px;
            margin: 1rem auto 0;
        }

        .exchange-box {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: -80px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .exchange-box h4 {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .exchange-box label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4f79a7;
            box-shadow: 0 0 0 3px rgba(79, 121, 167, 0.1);
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ddd;
            border-radius: 12px;
            height: 50px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px;
            right: 10px;
        }

        .select2-dropdown {
            border-radius: 12px;
            border: 1px solid #ddd;
        }

        .product-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
        }

        .product-option-img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 12px;
        }

        .product-option-name {
            font-size: 14px;
            font-weight: 500;
        }

        .product-option-code {
            font-size: 11px;
            color: #999;
            margin-left: 8px;
        }

        .result-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-top: 1.5rem;
        }

        .result-label {
            color: #666;
            font-size: 0.85rem;
        }

        .result-amount {
            font-size: 1.75rem;
            font-weight: 800;
            color: #4f79a7;
        }

        .rate-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #4f79a7;
        }

        .warning-text {
            color: #dc3545;
            font-size: 0.85rem;
        }

        .btn-exchange {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-exchange:hover {
            background: #3b5f87;
            transform: translateY(-2px);
        }

        .blockchain-select {
            margin-top: 1rem;
        }

        .blockchain-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .blockchain-option {
            display: flex;
            align-items: center;
            padding: 8px 12px;
        }

        .blockchain-option-img {
            width: 25px;
            height: 25px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 10px;
        }

        .live-exchange-container {
            background: #f0f7ff;
            border-radius: 15px;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #e0e8f0;
        }

        .live-exchange-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #4f79a7;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .live-exchange-title i {
            font-size: 0.8rem;
        }

        .live-exchange-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .live-exchange-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e8f0;
            animation: fadeInUp 0.5s ease;
        }

        .live-exchange-item:last-child {
            border-bottom: none;
        }

        .live-exchange-user {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 140px;
            flex-shrink: 0;
        }

        .live-exchange-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #4f79a7, #3b5f87);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
            flex-shrink: 0;
        }

        .live-exchange-name {
            font-weight: 600;
            color: #333;
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .live-exchange-detail {
            flex: 1;
            text-align: left;
            color: #666;
            font-size: 0.8rem;
            padding: 0 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .live-exchange-amount {
            font-weight: 700;
            color: #28a745;
            min-width: 90px;
            text-align: right;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .live-exchange-time {
            font-size: 0.7rem;
            color: #999;
            min-width: 70px;
            text-align: right;
            flex-shrink: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .live-pulse {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.2); opacity: 0; }
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 1.5rem; }
            .hero p { font-size: 0.85rem; padding: 0 15px; }
            .exchange-box { margin-top: -60px; padding: 20px; }
            .exchange-box h4 { font-size: 1.2rem; text-align: center; }
            .result-info { padding: 15px; }
            .result-info .row { flex-direction: column; text-align: center; }
            .result-info .col-md-4 { margin-bottom: 12px; }
            .result-amount { font-size: 1.3rem; }
            .rate-value { font-size: 0.9rem; }
            .warning-text { font-size: 0.75rem; display: block; text-align: center; }
            .live-exchange-container { padding: 12px; }
            .live-exchange-item { flex-wrap: wrap; padding: 10px 0; }
            .live-exchange-user { min-width: 100%; margin-bottom: 8px; }
            .live-exchange-name { white-space: normal; word-break: break-word; }
            .live-exchange-detail { width: 100%; text-align: left; margin-left: 42px; padding: 0; font-size: 0.7rem; white-space: normal; margin-bottom: 5px; }
            .live-exchange-amount { text-align: left; margin-left: 42px; min-width: 100%; margin-top: 5px; }
            .live-exchange-time { text-align: left; margin-left: 42px; min-width: 100%; margin-top: 3px; }
            .select2-container--default .select2-selection--single { height: 45px; }
            .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 33px; }
            .select2-container--default .select2-selection--single .select2-selection__arrow { height: 43px; }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .live-exchange-item { flex-wrap: nowrap; }
            .live-exchange-user { min-width: 120px; }
            .live-exchange-detail { margin-left: 0; text-align: center; white-space: nowrap; }
            .live-exchange-amount, .live-exchange-time { margin-left: 0; text-align: right; min-width: auto; }
        }

        @media (max-width: 375px) {
            .result-amount { font-size: 1.1rem; }
            .rate-value { font-size: 0.8rem; }
            .live-exchange-name { font-size: 0.75rem; }
            .live-exchange-detail { font-size: 0.65rem; }
        }
    </style>
@endpush

@section('content')
    <section class="hero">
        <div class="container">
            <h1 class="fw-bold">Exachanger</h1>
            <p>
                Multi-platform digital currencies exchange including PayPal, Skrill, Neteller, AirTM, Payoneer, USDT, USDC, and many more.
            </p>
        </div>
    </section>

    <div class="container" id="exchange">
        <div class="exchange-box">
            <h4><i class="fas fa-exchange-alt me-2"></i> Exchange your USD</h4>

            <div class="row g-3">
                <div class="col-md-4">
                    <label>Amount</label>
                    <input type="number" id="amount" class="form-control" placeholder="0.00" value="1.00" step="any" max="9999" oninput="if(this.value > 9999) this.value = 9999">
                </div>

                <div class="col-md-4">
                    <label>From</label>
                    <select id="fromCurrency" class="form-select" style="width: 100%;">
                        <option value="">-- Select Product --</option>
                        @foreach($uniqueProducts as $product)
                            <option value="{{ $product['product_code'] }}" 
                                    data-img="{{ $product['img'] }}"
                                    data-name="{{ $product['product_name'] }}"
                                    data-code="{{ $product['product_code'] }}"
                                    data-category="{{ $product['category'] }}">
                                {{ $product['product_name'] }}
                            </option>
                        @endforeach
                    </select>
                    
                    <div id="fromBlockchainContainer" class="blockchain-select" style="display: none;">
                        <label class="blockchain-label"><i class="fas fa-link me-1"></i> Blockchain Network (From)</label>
                        <select id="fromBlockchain" class="form-select" style="width: 100%;">
                            <option value="">-- Select Blockchain --</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label>To</label>
                    <select id="toCurrency" class="form-select" style="width: 100%;" disabled>
                        <option value="">-- Select From First --</option>
                    </select>
                    
                    <div id="toBlockchainContainer" class="blockchain-select" style="display: none;">
                        <label class="blockchain-label"><i class="fas fa-link me-1"></i> Blockchain Network (To)</label>
                        <select id="toBlockchain" class="form-select" style="width: 100%;">
                            <option value="">-- Select Blockchain --</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="result-info">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="result-label">YOU WILL GET</div>
                        <div class="result-amount" id="result">0.00 USD</div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="result-label">EXCHANGE RATE</div>
                        <div class="rate-value" id="exchangeRate">-</div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="warning-text" id="warningMessage"></span>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-12">
                    <button class="btn-exchange w-100" id="btnExchangeNow">
                        <i class="fas fa-exchange-alt me-2"></i> Exchange Now
                    </button>
                </div>
            </div>

            <div class="live-exchange-container" id="liveExchangeContainer">
                <div class="live-exchange-title">
                    <i class="fas fa-sync-alt fa-fw"></i>
                    <span>LIVE EXCHANGE ACTIVITY</span>
                    <span class="live-pulse"></span>
                </div>
                <div class="live-exchange-list" id="liveExchangeList">
                    <div class="text-center text-muted py-2">
                        <i class="fas fa-spinner fa-spin"></i> Loading exchange activities...
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery (WAJIB sebelum Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Pass PHP variables to JavaScript -->
    <script>
        window.exchangeData = @json($exchangeData);
        window.uniqueProducts = @json($uniqueProducts);
        window.liveNames = @json($liveNames);
        window.blockchainMap = @json($blockchainMap);
        window.routeTransactionCreate = '{{ route("transaction.create") }}';
        
        window.productMap = {};
        @foreach($products as $product)
        window.productMap['{{ $product->product_code }}'] = {
            product_code: '{{ $product->product_code }}',
            product_name: '{{ $product->product_name }}',
            category: '{{ $product->category }}',
            img: '{{ asset('img/product/' . $product->img) }}'
        };
        @endforeach
        
        window.availableProducts = [];
        @foreach($uniqueProducts as $product)
        window.availableProducts.push({
            code: '{{ $product['product_code'] }}',
            name: '{{ $product['product_name'] }}',
            category: '{{ $product['category'] }}'
        });
        @endforeach
    </script>
    
    <!-- External JavaScript files -->
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/live_exchange.js') }}"></script>
@endpush