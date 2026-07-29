@extends('layouts.app')

@section('title', $title)

@section('meta_description', $description)

@section('canonical', $canonical)

@push('styles')
    <style>
        .hero {
            background: #4f79a7;
            color: white;
            padding: 60px 0 80px;
            text-align: center;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 2rem;
        }

        .hero p {
            font-size: 1rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 10px auto 0;
        }

        .exchange-box {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: -50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .exchange-box h4 {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
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
            box-shadow: 0 0 0 3px rgba(79,121,167,0.1);
        }

        .btn-exchange {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-exchange:hover {
            background: #3b5f87;
            transform: translateY(-2px);
        }

        .blockchain-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-pair {
            background: linear-gradient(135deg, #e8f4fd 0%, #d4e8f5 100%);
            border-radius: 20px;
            padding: 25px 20px;
            margin-bottom: 30px;
            text-align: center;
            border: 1px solid rgba(79,121,167,0.2);
        }
        
        .info-pair .product-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            object-fit: cover;
            vertical-align: middle;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .info-pair .product-name-large {
            font-weight: 800;
            font-size: 1.6rem;
            color: #2c3e50;
            margin: 0 12px;
        }
        
        .info-pair .rate-badge {
            background: #28a745;
            color: white;
            padding: 10px 28px;
            border-radius: 40px;
            display: inline-block;
            margin-top: 20px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(40,167,69,0.3);
        }

        /* LIVE EXCHANGE ACTIVITY */
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

        /* BLOCKCHAIN ROW */
        .blockchain-row {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .blockchain-col {
            flex: 1;
            min-width: 200px;
        }

        /* CUSTOM DROPDOWN STYLES */
        .custom-dropdown {
            position: relative;
            width: 100%;
        }
        
        .custom-dropdown-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background-color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            box-sizing: border-box;
        }
        
        .custom-dropdown-select img {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            object-fit: cover;
        }
        
        .custom-dropdown-select span {
            flex: 1;
            font-size: 14px;
        }
        
        .custom-dropdown-select .arrow {
            color: #999;
            transition: transform 0.3s;
        }
        
        .custom-dropdown-select.open .arrow {
            transform: rotate(180deg);
        }
        
        .custom-dropdown-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;
            margin-top: 5px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .custom-dropdown-options.show {
            display: block;
        }
        
        .custom-dropdown-option {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .custom-dropdown-option:hover {
            background-color: #f0f7ff;
        }
        
        .custom-dropdown-option.selected {
            background-color: #e8f4fd;
        }
        
        .custom-dropdown-option img {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            object-fit: cover;
        }
        
        .custom-dropdown-option span {
            font-size: 14px;
            color: #333;
        }
        
        .hidden-select {
            display: none;
        }

        /* AMOUNT & RESULT SECTION - LAYOUT HORIZONTAL */
        .amount-result-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-top: 1.5rem;
        }
        
        .result-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        
        .amount-wrapper {
            flex: 0 0 400px;
            min-width: 150px;
        }
        
        @media (max-width: 768px) {
            .amount-wrapper {
                flex: 1;
            }
        }
        
        .amount-wrapper label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
        }
        
        .amount-wrapper input {
            width: 100%;
        }
        
        .result-wrapper {
            text-align: right;
            min-width: 160px;
        }
        
        .result-wrapper .result-label {
            font-size: 0.75rem;
            color: #666;
            margin-bottom: 4px;
        }
        
        .result-wrapper .result-value {
            font-size: 1.4rem;
            font-weight: 800;
            color: #4f79a7;
            line-height: 1.2;
            white-space: nowrap;
        }
        
        .result-wrapper .warning-text {
            font-size: 0.7rem;
            color: #dc3545;
            margin-top: 4px;
            text-align: right;
        }
        
        /* Highlight untuk amount input */
        .amount-wrapper input {
            border: 2px solid #ffc107 !important;
            background-color: #fffbe6;
            animation: pulse-yellow 1.5s ease-in-out infinite;
        }
        
        .amount-wrapper label {
            color: #ffc107;
            font-weight: 700;
        }
        
        .amount-wrapper label i {
            color: #ffc107;
        }
        
        @keyframes pulse-yellow {
            0% {
                border-color: #ffc107;
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
            }
            70% {
                border-color: #ffc107;
                box-shadow: 0 0 0 5px rgba(255, 193, 7, 0);
            }
            100% {
                border-color: #ffc107;
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }
        
        .required-star {
            color: #ffc107;
            margin-left: 4px;
            font-size: 14px;
        }

        /* DESKTOP MODE */
        @media (min-width: 769px) {
            .result-wrapper .warning-text {
                text-align: right;
            }
        }

        /* HP MODE */
        @media (max-width: 768px) {
            .hero h1 { font-size: 1.5rem; }
            .hero { padding: 40px 0 60px; }
            .exchange-box { margin-top: -40px; padding: 20px; }
            .exchange-box h4 { font-size: 1.2rem; text-align: center; }
            
            /* INFO PAIR - 1 BARIS DI HP */
            .info-pair {
                padding: 15px 10px;
            }
            .info-pair div {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: nowrap;
                gap: 5px;
            }
            .info-pair .product-icon {
                width: 28px;
                height: 28px;
            }
            .info-pair .product-name-large {
                font-size: 0.85rem;
                margin: 0 3px;
                white-space: nowrap;
            }
            .info-pair .fa-exchange-alt {
                font-size: 0.7rem;
            }
            .info-pair .rate-badge {
                font-size: 0.8rem;
                padding: 5px 12px;
                margin-top: 12px;
            }
            
            /* AMOUNT & RESULT - STACK DI HP */
            .result-row {
                flex-direction: column;
                align-items: stretch;
            }
            .amount-wrapper {
                min-width: 100%;
                margin-bottom: 10px;
            }
            .result-wrapper {
                text-align: left;
                min-width: 100%;
            }
            .result-wrapper .warning-text {
                text-align: left;
            }
            .result-wrapper .result-value {
                white-space: normal;
                font-size: 1.2rem;
            }
            
            /* Live exchange activity responsive */
            .live-exchange-item {
                flex-wrap: wrap;
                padding: 10px 0;
            }
            .live-exchange-user {
                min-width: 100%;
                margin-bottom: 8px;
            }
            .live-exchange-name {
                white-space: normal;
                word-break: break-word;
            }
            .live-exchange-detail {
                width: 100%;
                margin-left: 42px;
                padding: 0;
                font-size: 0.7rem;
                white-space: normal;
                margin-bottom: 5px;
            }
            .live-exchange-amount {
                text-align: left;
                margin-left: 42px;
                min-width: 100%;
                margin-top: 5px;
            }
            .live-exchange-time {
                text-align: left;
                margin-left: 42px;
                min-width: 100%;
                margin-top: 3px;
            }
            
            .blockchain-row {
                flex-direction: column;
                gap: 15px;
            }
            .custom-dropdown-select {
                padding: 10px 12px;
            }
            .custom-dropdown-option {
                padding: 8px 12px;
            }
        }

        /* Tablet kecil */
        @media (min-width: 576px) and (max-width: 768px) {
            .live-exchange-item {
                flex-wrap: nowrap;
            }
            .live-exchange-user {
                min-width: 120px;
            }
            .live-exchange-detail {
                margin-left: 0;
                text-align: center;
                white-space: nowrap;
            }
            .live-exchange-amount, .live-exchange-time {
                margin-left: 0;
                text-align: right;
                min-width: auto;
            }
        }

        /* HP kecil */
        @media (max-width: 375px) {
            .live-exchange-name {
                font-size: 0.75rem;
            }
            .live-exchange-detail {
                font-size: 0.65rem;
            }
            .result-wrapper .result-value {
                font-size: 1rem;
            }
            .result-wrapper .warning-text {
                font-size: 0.65rem;
            }
            .info-pair .product-name-large {
                font-size: 0.75rem;
            }
            .info-pair .product-icon {
                width: 22px;
                height: 22px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero">
        <div class="container">
            <h1>Exchange {{ $exchange->product1 }} to {{ $exchange->product2 }}</h1>
            <p>Get the best rate for {{ $exchange->product1 }} to {{ $exchange->product2 }} exchange</p>
        </div>
    </section>

    <div class="container" id="exchange">
        <div class="exchange-box">
            <h4><i class="fas fa-exchange-alt me-2"></i> Exchange {{ $exchange->product1 }} to {{ $exchange->product2 }}</h4>

            <div class="info-pair">
                <div>
                    @if(isset($productImages[$exchange->product1]))
                        <img src="{{ asset('img/product/' . $productImages[$exchange->product1]) }}" class="product-icon" alt="{{ $exchange->product1 }}">
                    @endif
                    <span class="product-name-large">{{ $exchange->product1 }}</span>
                    <i class="fas fa-exchange-alt mx-2 text-primary fa-lg"></i>
                    @if(isset($productImages[$exchange->product2]))
                        <img src="{{ asset('img/product/' . $productImages[$exchange->product2]) }}" class="product-icon" alt="{{ $exchange->product2 }}">
                    @endif
                    <span class="product-name-large">{{ $exchange->product2 }}</span>
                </div>
                <div class="rate-badge">
                    Rate: 1 {{ $exchange->product1 }} = {{ number_format($exchange->rate, 2) }} {{ $exchange->product2 }}
                </div>
            </div>

            <!-- BLOCKCHAIN SECTION -->
            <div class="blockchain-row" id="blockchainRow">
                <div class="blockchain-col" id="fromBlockchainContainer" style="display: none;">
                    <label class="blockchain-label"><i class="fas fa-link me-1"></i> Blockchain Network (From)</label>
                    <div id="fromBlockchainDropdown" class="custom-dropdown"></div>
                    <select id="fromBlockchain" class="hidden-select"></select>
                </div>
                <div class="blockchain-col" id="toBlockchainContainer" style="display: none;">
                    <label class="blockchain-label"><i class="fas fa-link me-1"></i> Blockchain Network (To)</label>
                    <div id="toBlockchainDropdown" class="custom-dropdown"></div>
                    <select id="toBlockchain" class="hidden-select"></select>
                </div>
            </div>

            <!-- AMOUNT & RESULT SECTION - HORIZONTAL -->
            <div class="amount-result-section">
                <div class="result-row">
                    <div class="amount-wrapper">
                        <label><i class="fas fa-dollar-sign me-1"></i> AMOUNT (USD) <span class="required-star">*</span></label>
                        <input type="number" id="amount" class="form-control" placeholder="0.00" value="1.00" step="any" max="9999" oninput="if(this.value > 9999) this.value = 9999">
                    </div>
                    <div class="result-wrapper">
                        <div class="result-label">YOU WILL GET</div>
                        <div class="result-value" id="result">0.00 {{ $exchange->product2 }}</div>
                        <div class="warning-text" id="warningMessage"></div>
                    </div>
                </div>
            </div>

            <!-- EXCHANGE BUTTON -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <button class="btn-exchange" id="btnExchangeNow">
                        <i class="fas fa-exchange-alt me-2"></i> Exchange Now
                    </button>
                </div>
            </div>

            <div class="live-exchange-container">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    
    <script>
        // ==========================================
        // PASS PHP VARIABLES TO JAVASCRIPT
        // ==========================================
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
        
        window.fromProductName = '{{ $exchange->product1 }}';
        window.toProductName = '{{ $exchange->product2 }}';
        window.rate = {{ $exchange->rate }};
        window.exchangeFee = {{ $exchange->fee }};
        window.feeType = '{{ $exchange->fee_type }}';
        window.minAmount = {{ $exchange->min }};
        window.fromProductCode = '{{ $fromProductCode ?? "" }}';
        window.toProductCode = '{{ $toProductCode ?? "" }}';
    </script>
    
    <!-- External JavaScript files -->
    <script src="{{ asset('js/exchange-detail.js') }}"></script>
    <script src="{{ asset('js/live_exchange.js') }}"></script>
@endpush