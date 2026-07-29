@extends('layouts.app')

@section('title', 'Exchange Rate - Exachanger | Best Digital Currency Exchange Rates')

@section('meta_description', 'Check real-time exchange rates for PayPal, Skrill, Neteller, AirTM, Payoneer, USDT, USDC and more. Best rates and low fees for digital currency exchange.')

@section('meta_keywords', 'exchange rate, digital currency exchange rate, PayPal rate, Skrill rate, Neteller rate, USDT rate, USDC rate, live exchange rate, best exchange rate, real-time rates')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* ========================================== */
        /* EXCHANGE RATE PAGE SPECIFIC STYLES */
        /* ========================================== */
        .page-header {
            background: linear-gradient(135deg, #4f79a7, #3b5f87);
            color: white;
            padding: 60px 0;
            text-align: center;
        }

        .page-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        .exchange-rate-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .rate-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #e0e8f0;
        }

        .rate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }

        .rate-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            flex-wrap: wrap;
            gap: 10px;
        }

        .rate-pair {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .product-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f0f7ff;
            padding: 8px 16px;
            border-radius: 40px;
        }

        .product-img {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-name {
            font-weight: 700;
            font-size: 1rem;
            color: #333;
        }

        .arrow-icon {
            color: #4f79a7;
            font-size: 1.2rem;
        }

        .rate-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .rate-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #28a745;
        }

        .rate-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #888;
            letter-spacing: 0.5px;
        }

        .fee-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #fff3e0;
            color: #e67e22;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .min-amount {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e8f4fd;
            color: #4f79a7;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .rate-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-exchange-rate {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-exchange-rate:hover {
            background: #3b5f87;
            transform: translateY(-2px);
            color: white;
        }

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 10px 15px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4f79a7;
            box-shadow: 0 0 0 3px rgba(79,121,167,0.1);
        }

        /* Select2 Custom Styles */
        .select2-container--default .select2-selection--single {
            border: 1px solid #ddd;
            border-radius: 12px;
            height: 46px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #666;
            margin-bottom: 10px;
        }

        .filter-warning {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-top: 15px;
            text-align: center;
            display: none;
        }

        /* ========================================== */
        /* EXCHANGE RATE MOBILE RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .page-header { padding: 40px 0; }
            .page-header h1 { font-size: 1.8rem; }
            .page-header p { font-size: 0.9rem; padding: 0 15px; }
            .exchange-rate-container { margin: 30px auto; padding: 0 15px; }
            .filter-section { padding: 15px; }
            .filter-section .row { gap: 15px; }
            .filter-section .col-md-5, .filter-section .col-md-2 { width: 100%; }
            .filter-section .btn-exchange-rate { width: 100%; margin-top: 5px; }
            .rate-card { padding: 15px; }
            .rate-header { flex-direction: column; align-items: flex-start; }
            .rate-pair { width: 100%; justify-content: space-between; }
            .product-badge { padding: 6px 12px; }
            .product-img { width: 24px; height: 24px; }
            .product-name { font-size: 0.85rem; }
            .arrow-icon { font-size: 1rem; }
            .rate-info { padding: 12px; }
            .rate-info .row { flex-direction: column; text-align: center; }
            .rate-info .col-md-6 { width: 100%; }
            .rate-info .text-md-end { text-align: center !important; margin-top: 10px; }
            .rate-value { font-size: 1.2rem; }
            .rate-label { font-size: 0.65rem; }
            .fee-badge { font-size: 0.7rem; padding: 4px 10px; }
            .empty-state { padding: 40px 20px; }
            .empty-state i { font-size: 3rem; }
            .empty-state h4 { font-size: 1.1rem; }
            
            /* PERBAIKAN KHUSUS TOMBOL DI MOBILE */
            .rate-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            
            .rate-footer > div:first-child {
                width: 100%;
                text-align: center;
            }
            
            .rate-footer .min-amount {
                width: 100%;
                justify-content: center;
                display: flex;
            }
            
            /* Container tombol View Details & Exchange Now */
            .rate-footer > div:last-child {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }
            
            .rate-footer > div:last-child .btn-exchange-rate {
                width: 100%;
                justify-content: center;
                padding: 12px 20px;
                font-size: 0.9rem;
                margin: 0;
            }
            
            /* Tombol View Details */
            .rate-footer > div:last-child .btn-exchange-rate:first-child {
                background: #6c757d;
            }
            
            /* Tombol Exchange Now */
            .rate-footer > div:last-child .btn-exchange-rate:last-child {
                background: #4f79a7;
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .rate-header { flex-direction: row; }
            .rate-pair { width: auto; }
            .rate-info .row { flex-direction: row; text-align: left; }
            .rate-info .text-md-end { text-align: right !important; margin-top: 0; }
            .rate-footer { flex-direction: row; }
            .btn-exchange-rate { width: auto; }
        }

        @media (max-width: 375px) {
            .rate-value { font-size: 1rem; }
            .product-name { font-size: 0.75rem; }
            .product-img { width: 20px; height: 20px; }
            .product-badge { padding: 4px 10px; }
            .fee-badge { font-size: 0.65rem; }
        }
    </style>
@endpush

@section('content')
    <section class="page-header">
        <div class="container">
            <h1>Exchange Rates</h1>
            <p>Real-time exchange rates for all supported digital currencies platforms</p>
        </div>
    </section>

    <div class="exchange-rate-container">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Filter by From</label>
                    <select id="filterFrom" class="form-select" style="width: 100%;">
                        <option value="all">All Platforms</option>
                        @foreach($uniqueProducts as $product)
                            <option value="{{ $product['product_name'] }}" 
                                    data-img="{{ isset($productImages[$product['product_name']]) ? asset('img/product/' . $productImages[$product['product_name']]) : '' }}"
                                    data-name="{{ $product['product_name'] }}">
                                {{ $product['product_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Filter by To</label>
                    <select id="filterTo" class="form-select" style="width: 100%;">
                        <option value="all">All Platforms</option>
                        @foreach($uniqueProducts as $product)
                            <option value="{{ $product['product_name'] }}" 
                                    data-img="{{ isset($productImages[$product['product_name']]) ? asset('img/product/' . $productImages[$product['product_name']]) : '' }}"
                                    data-name="{{ $product['product_name'] }}">
                                {{ $product['product_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="resetFilter" class="btn-exchange-rate w-100">
                        <i class="fas fa-undo-alt me-1"></i> Reset
                    </button>
                </div>
            </div>
            <div id="filterWarning" class="filter-warning">
                <i class="fas fa-exclamation-triangle me-2"></i> Cannot filter with the same platform. Please select different platforms for "From" and "To".
            </div>
        </div>

        <!-- Exchange Rates List -->
        <div id="ratesList">
            @if(count($exchanges) > 0)
                @foreach($exchanges as $exchange)
                    @php
                        // ==========================================
                        // HITUNG FEE YANG BENAR (SESUAI LOGIKA)
                        // ==========================================
                        $dbFee = $exchange->fee;
                        $feeType = $exchange->fee_type;
                        $toProductName = $exchange->product2;
                        $displayFee = '';
                        
                        // Logika flat fee untuk display (simulasi dengan nilai minimum)
                        // Karena kita tidak punya amount di halaman rate, kita asumsikan minimal fee yang berlaku
                        if ($toProductName === 'Neteller') {
                            $displayFee = '$0.60 (minimal fee)';
                        } elseif ($toProductName === 'Skrill') {
                            $displayFee = '$0.60 (minimal fee)';
                        } elseif ($toProductName === 'Payoneer') {
                            $displayFee = '$4.00 (minimal fee)';
                        } else {
                            if ($feeType == 'Percentage') {
                                $displayFee = $dbFee . '%';
                            } else {
                                $displayFee = '$' . number_format($dbFee, 2);
                            }
                        }
                    @endphp
                    <div class="rate-card" data-from="{{ $exchange->product1 }}" data-to="{{ $exchange->product2 }}">
                        <div class="rate-header">
                            <div class="rate-pair">
                                <div class="product-badge">
                                    @if(isset($productImages[$exchange->product1]))
                                        <img src="{{ asset('img/product/' . $productImages[$exchange->product1]) }}" class="product-img" alt="{{ $exchange->product1 }}">
                                    @endif
                                    <span class="product-name">{{ $exchange->product1 }}</span>
                                </div>
                                <i class="fas fa-exchange-alt arrow-icon"></i>
                                <div class="product-badge">
                                    @if(isset($productImages[$exchange->product2]))
                                        <img src="{{ asset('img/product/' . $productImages[$exchange->product2]) }}" class="product-img" alt="{{ $exchange->product2 }}">
                                    @endif
                                    <span class="product-name">{{ $exchange->product2 }}</span>
                                </div>
                            </div>
                            <div>
                                <span class="fee-badge"><i class="fas {{ strpos($displayFee, '%') !== false ? 'fa-percent' : 'fa-dollar-sign' }}"></i> Fee: {{ $displayFee }}</span>
                            </div>
                        </div>
                        
                        <div class="rate-info">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="rate-label">EXCHANGE RATE</div>
                                    <div class="rate-value">1 {{ $exchange->product1 }} = {{ number_format($exchange->rate, 2) }} {{ $exchange->product2 }}</div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <div class="rate-label">MINIMUM TRANSACTION</div>
                                    <div class="fw-bold" style="font-size: 1.1rem;">${{ number_format($exchange->min, 2) }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="rate-footer">
                            <div>
                                <span class="min-amount"><i class="fas fa-chart-line"></i> Best rate for {{ $exchange->product1 }} to {{ $exchange->product2 }}</span>
                            </div>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('exchange.rate.detail', ['from' => urlencode($exchange->product1), 'to' => urlencode($exchange->product2)]) }}" 
                                   class="btn-exchange-rate" style="background: #6c757d;">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </a>
                                <button class="btn-exchange-rate exchange-now-btn" 
                                        data-from="{{ $exchange->product1 }}" 
                                        data-to="{{ $exchange->product2 }}">
                                    <i class="fas fa-exchange-alt me-1"></i> Exchange Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-chart-line"></i>
                    <h4>No Exchange Rates Available</h4>
                    <p class="text-muted">Please check back later for updated exchange rates.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Buat mapping gambar produk
        const productImageMap = {};
        @foreach($productImages as $productName => $img)
            productImageMap['{{ $productName }}'] = '{{ asset('img/product/' . $img) }}';
        @endforeach

        // Format product option for Select2
        function formatProduct(option) {
            if (!option.id) return option.text;
            
            if (option.id === 'all') {
                return option.text;
            }
            
            const imgUrl = productImageMap[option.id] || '';
            const productName = option.id;
            
            return $(
                '<div class="product-option">' +
                    '<img src="' + (imgUrl || 'https://via.placeholder.com/30') + '" class="product-option-img" onerror="this.src=\'https://via.placeholder.com/30\'">' +
                    '<span class="product-option-name">' + productName + '</span>' +
                '</div>'
            );
        }

        function formatProductSelection(option) {
            if (!option.id) return option.text;
            
            if (option.id === 'all') {
                return option.text;
            }
            
            const imgUrl = productImageMap[option.id] || '';
            const productName = option.id;
            
            return $(
                '<div style="display: flex; align-items: center;">' +
                    '<img src="' + (imgUrl || 'https://via.placeholder.com/24') + '" style="width: 24px; height: 24px; border-radius: 6px; margin-right: 10px;" onerror="this.src=\'https://via.placeholder.com/24\'">' +
                    '<span>' + productName + '</span>' +
                '</div>'
            );
        }

        // Inisialisasi Select2
        $('#filterFrom').select2({
            templateResult: formatProduct,
            templateSelection: formatProductSelection,
            placeholder: "All Platforms",
            width: '100%'
        });

        $('#filterTo').select2({
            templateResult: formatProduct,
            templateSelection: formatProductSelection,
            placeholder: "All Platforms",
            width: '100%'
        });

        const filterWarning = document.getElementById('filterWarning');
        const resetBtn = document.getElementById('resetFilter');
        const rateCards = document.querySelectorAll('.rate-card');

        function filterRates() {
            const fromValue = $('#filterFrom').val();
            const toValue = $('#filterTo').val();
            
            if (fromValue !== 'all' && toValue !== 'all' && fromValue === toValue) {
                filterWarning.style.display = 'block';
                rateCards.forEach(card => { card.style.display = 'none'; });
                
                const ratesList = document.getElementById('ratesList');
                let emptyDiv = document.getElementById('emptyFilterResult');
                if (!emptyDiv) {
                    emptyDiv = document.createElement('div');
                    emptyDiv.id = 'emptyFilterResult';
                    emptyDiv.className = 'empty-state';
                    emptyDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle"></i>
                        <h4>Invalid Filter</h4>
                        <p class="text-muted">Please select different platforms for "From" and "To".</p>
                    `;
                    ratesList.appendChild(emptyDiv);
                }
                return;
            }
            
            filterWarning.style.display = 'none';
            const emptyDiv = document.getElementById('emptyFilterResult');
            if (emptyDiv) emptyDiv.remove();
            
            let visibleCount = 0;
            rateCards.forEach(card => {
                const fromProduct = card.getAttribute('data-from');
                const toProduct = card.getAttribute('data-to');
                
                let show = true;
                if (fromValue !== 'all' && fromProduct !== fromValue) show = false;
                if (toValue !== 'all' && toProduct !== toValue) show = false;
                
                if (show) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            if (visibleCount === 0 && rateCards.length > 0) {
                const ratesList = document.getElementById('ratesList');
                let noResultDiv = document.getElementById('noResultMessage');
                if (!noResultDiv) {
                    noResultDiv = document.createElement('div');
                    noResultDiv.id = 'noResultMessage';
                    noResultDiv.className = 'empty-state';
                    noResultDiv.innerHTML = `
                        <i class="fas fa-search"></i>
                        <h4>No Exchange Rates Found</h4>
                        <p class="text-muted">No exchange rates match your filter criteria. Please try different filters.</p>
                    `;
                    ratesList.appendChild(noResultDiv);
                }
            } else {
                const noResultDiv = document.getElementById('noResultMessage');
                if (noResultDiv) noResultDiv.remove();
            }
        }

        $('#filterFrom, #filterTo').on('change', filterRates);
        
        resetBtn.addEventListener('click', function() {
            $('#filterFrom').val('all').trigger('change');
            $('#filterTo').val('all').trigger('change');
            filterRates();
        });

        // Exchange Now buttons
        document.querySelectorAll('.exchange-now-btn').forEach(button => {
            button.addEventListener('click', function() {
                const fromProduct = this.getAttribute('data-from');
                const toProduct = this.getAttribute('data-to');
                
                localStorage.setItem('exchange_from', fromProduct);
                localStorage.setItem('exchange_to', toProduct);
                
                window.location.href = "{{ route('home') }}?from=" + encodeURIComponent(fromProduct) + "&to=" + encodeURIComponent(toProduct);
            });
        });
    </script>
@endpush