<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Exchange Transaction - Exachanger</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .transaction-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 15px;
        }
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
        }
        .card-header {
            background: #4f79a7;
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 20px 25px;
            font-weight: 700;
            position: relative;
        }
        
        .btn-back-top {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-back-top:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }
        
        .info-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            width: 160px;
            font-weight: 600;
            color: #555;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        .info-value {
            flex: 1;
            font-weight: 500;
            color: #333;
            word-break: break-word;
        }
        .product-img {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            margin-right: 10px;
            object-fit: cover;
            vertical-align: middle;
        }
        .blockchain-img {
            width: 25px;
            height: 25px;
            border-radius: 6px;
            margin-right: 8px;
            object-fit: cover;
            vertical-align: middle;
        }
        .amount-large {
            font-size: 1.5rem;
            font-weight: 800;
            color: #4f79a7;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #555;
        }
        .form-control, .form-select {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4f79a7;
            box-shadow: 0 0 0 3px rgba(79,121,167,0.1);
        }
        .btn-continue {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-continue:hover {
            background: #3b5f87;
            transform: translateY(-2px);
        }
        .required-field::after {
            content: " *";
            color: red;
        }
        .iti {
            width: 100%;
        }
        .iti__flag-container {
            z-index: 10;
        }
        .iti__selected-flag {
            border-radius: 12px 0 0 12px;
        }

        @media (max-width: 768px) {
            .transaction-container {
                margin: 20px auto;
                padding: 0 12px;
            }
            .card-header {
                padding: 15px 20px;
                font-size: 0.95rem;
                text-align: center;
                padding-right: 55px;
            }
            .card-body {
                padding: 20px !important;
            }
            .info-section {
                padding: 15px;
            }
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 0;
            }
            .info-label {
                width: 100%;
                margin-bottom: 5px;
                font-size: 0.7rem;
                color: #888;
            }
            .info-value {
                width: 100%;
                font-size: 0.9rem;
            }
            .amount-large {
                font-size: 1.2rem;
            }
            .product-img {
                width: 24px;
                height: 24px;
                margin-right: 6px;
            }
            .blockchain-img {
                width: 20px;
                height: 20px;
                margin-right: 5px;
            }
            .form-label {
                font-size: 0.75rem;
            }
            .form-control, .form-select {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            .btn-continue {
                margin-top: 10px;
            }
            .btn-back-top {
                width: 28px;
                height: 28px;
                font-size: 0.85rem;
                right: 15px;
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .info-row {
                flex-direction: row;
                align-items: center;
            }
            .info-label {
                width: 140px;
                margin-bottom: 0;
            }
            .info-value {
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container transaction-container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-exchange-alt me-2"></i> Confirm Exchange Transaction
                <a href="{{ route('home') }}" class="btn-back-top" title="Back">
                     <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="card-body p-4">
                <!-- Order Summary Section -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-receipt me-2"></i> Order Summary</h6>
                    
                    <div class="info-row">
                        <div class="info-label">Amount</div>
                        <div class="info-value amount-large">{{ number_format($amount, 2) }} USD</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">From</div>
                        <div class="info-value">
                            <img src="{{ $fromProduct['img'] }}" class="product-img" alt="{{ $fromProduct['name'] }}">
                            {{ $fromProduct['name'] }} ({{ $fromProduct['code'] }})
                        </div>
                    </div>
                    
                    @if($fromBlockchain)
                    <div class="info-row">
                        <div class="info-label">Blockchain (From)</div>
                        <div class="info-value">
                            @if($fromBlockchain['img'])
                            <img src="{{ $fromBlockchain['img'] }}" class="blockchain-img" alt="{{ $fromBlockchain['name'] }}">
                            @endif
                            {{ $fromBlockchain['name'] }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="info-row">
                        <div class="info-label">To</div>
                        <div class="info-value">
                            <img src="{{ $toProduct['img'] }}" class="product-img" alt="{{ $toProduct['name'] }}">
                            {{ $toProduct['name'] }} ({{ $toProduct['code'] }})
                        </div>
                    </div>
                    
                    @if($toBlockchain)
                    <div class="info-row">
                        <div class="info-label">Blockchain (To)</div>
                        <div class="info-value">
                            @if($toBlockchain['img'])
                            <img src="{{ $toBlockchain['img'] }}" class="blockchain-img" alt="{{ $toBlockchain['name'] }}">
                            @endif
                            {{ $toBlockchain['name'] }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="info-row">
                        <div class="info-label">Exchange Rate</div>
                        <div class="info-value">1 {{ $fromProduct['code'] }} = {{ number_format($rate, 2) }} {{ $toProduct['code'] }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Fee</div>
                        <div class="info-value">{{ $feeText }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">You Will Get</div>
                        <div class="info-value amount-large">{{ number_format($finalAmount, 2) }} {{ $toProduct['code'] }}</div>
                    </div>
                </div>
                
                <!-- Customer Information Form -->
                <form action="{{ route('transaction.store') }}" method="POST" id="transactionForm">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="from_product_code" value="{{ $fromProduct['code'] }}">
                    <input type="hidden" name="from_product_name" value="{{ $fromProduct['name'] }}">
                    <input type="hidden" name="to_product_code" value="{{ $toProduct['code'] }}">
                    <input type="hidden" name="to_product_name" value="{{ $toProduct['name'] }}">
                    <input type="hidden" name="to_category" value="{{ $toProduct['category'] }}">
                    <input type="hidden" name="from_blockchain" value="{{ $fromBlockchain['name'] ?? '' }}">
                    <input type="hidden" name="to_blockchain" value="{{ $toBlockchain['name'] ?? '' }}">
                    <input type="hidden" name="rate" value="{{ $rate }}">
                    <input type="hidden" name="fee" value="{{ $feeAmount }}">
                    <input type="hidden" name="fee_text" value="{{ $feeText }}">
                    <input type="hidden" name="final_amount" value="{{ $finalAmount }}">
                    
                    <h6 class="mb-3 mt-3"><i class="fas fa-user me-2"></i> Customer Information</h6>
                    
                    @php
                        $customerData = $customer_data ?? session('temp_transaction', []);
                        // Bersihkan nomor telepon dari double formatting
                        $cleanPhone = preg_replace('/^(\+\d+)\s\+\d+/', '$1', $customerData['full_phone'] ?? '');
                        if (empty($cleanPhone)) {
                            $cleanPhone = $customerData['full_phone'] ?? '';
                        }
                    @endphp
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Full Name</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" required placeholder="Enter your full name" value="{{ old('full_name', $customerData['full_name'] ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required-field">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="you@example.com" value="{{ old('email', $customerData['email'] ?? '') }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required-field">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="form-control" required placeholder="81234567890" value="{{ old('phone', $cleanPhone) }}">
                        <small class="text-muted">Enter your phone number with country code</small>
                    </div>
                    
                    @if($toProduct['category'] === 'Crypto')
                        @if(isset($toBlockchain['name']) && $toBlockchain['name'] === 'Binance Pay ID')
                            <div class="mb-3">
                                <label class="form-label required-field">Your Binance Pay ID</label>
                                <input type="text" name="wallet_address" id="wallet_address" class="form-control" required placeholder="Enter your Binance Pay ID" value="{{ old('wallet_address', $customerData['product2_dest'] ?? '') }}">
                                <small class="text-muted">Make sure to enter the correct Binance Pay ID</small>
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label required-field">Your Wallet Address ({{ $toProduct['name'] }} {{ $toBlockchain['name'] ?? '' }})</label>
                                <input type="text" name="wallet_address" id="wallet_address" class="form-control" required placeholder="Enter your {{ $toProduct['name'] }} wallet address" value="{{ old('wallet_address', $customerData['product2_dest'] ?? '') }}">
                                <small class="text-muted">Make sure to send to the correct {{ $toBlockchain['name'] ?? '' }} network</small>
                            </div>
                        @endif
                    @else
                        <div class="mb-3">
                            <label class="form-label required-field">Your {{ $toProduct['name'] }} Account Email</label>
                            <input type="email" name="account_email" id="account_email" class="form-control" required placeholder="Enter your {{ $toProduct['name'] }} registered email" value="{{ old('account_email', $customerData['product2_dest'] ?? '') }}">
                            <small class="text-muted">Please enter the email address associated with your {{ $toProduct['name'] }} account</small>
                        </div>
                    @endif
                    
                    <div class="row g-3 mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn-continue" id="submitBtn">
                                <i class="fas fa-check-circle me-2"></i> Continue to Exchange
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    
    <script>
        // Initialize international telephone input
        const phoneInput = document.querySelector("#phone");
        let existingPhoneValue = phoneInput.value;
        
        // Bersihkan nomor dari double formatting sebelum diinisialisasi
        if (existingPhoneValue && existingPhoneValue.match(/^\+\d+\s\+\d+/)) {
            existingPhoneValue = existingPhoneValue.replace(/^(\+\d+)\s\+\d+/, '$1');
            phoneInput.value = existingPhoneValue;
        }
        
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "id",
            separateDialCode: true,
            preferredCountries: ['id', 'us', 'gb', 'sg', 'my', 'au'],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            formatOnDisplay: true,
            autoHideDialCode: false,
            nationalMode: false
        });
        
        // Set nilai phone number jika ada
        if (existingPhoneValue && existingPhoneValue !== '') {
            setTimeout(function() {
                try {
                    iti.setNumber(existingPhoneValue);
                } catch(e) {
                    console.log('Error setting number:', e);
                }
            }, 200);
        }
        
        // Update hidden input with full phone number before submit
        const form = document.getElementById('transactionForm');
        form.addEventListener('submit', function(e) {
            let fullPhoneNumber = iti.getNumber();
            
            // Validasi hasil
            if (!fullPhoneNumber || fullPhoneNumber === '+1' || fullPhoneNumber.includes('+1 +')) {
                fullPhoneNumber = phoneInput.value;
            }
            
            // Bersihkan dari double formatting
            if (fullPhoneNumber && fullPhoneNumber.match(/^\+\d+\s\+\d+/)) {
                fullPhoneNumber = fullPhoneNumber.replace(/^(\+\d+)\s\+\d+/, '$1');
            }
            
            const hiddenPhone = document.createElement('input');
            hiddenPhone.type = 'hidden';
            hiddenPhone.name = 'full_phone';
            hiddenPhone.value = fullPhoneNumber;
            form.appendChild(hiddenPhone);
        });
        
        // Validasi input phone - hanya angka dan +
        phoneInput.addEventListener('input', function(e) {
            let value = this.value;
            value = value.replace(/[^0-9+]/g, '');
            if (value.indexOf('+') > 0) {
                value = value.replace(/\+/g, '');
                value = '+' + value;
            }
            const plusCount = (value.match(/\+/g) || []).length;
            if (plusCount > 1) {
                value = value.replace(/\+/g, '');
                value = '+' + value;
            }
            this.value = value;
        });
        
        phoneInput.addEventListener('keypress', function(e) {
            const allowedKeys = [8, 9, 13, 46, 37, 38, 39, 40];
            if (allowedKeys.includes(e.keyCode)) return;
            if (!/[0-9+]/.test(e.key)) {
                e.preventDefault();
            }
        });
        
        // Hapus class is-invalid saat user mulai mengetik
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
            });
        });
    </script>
</body>
</html>