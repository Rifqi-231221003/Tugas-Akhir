<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Upload Payment Proof - Exachanger</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .upload-container {
            max-width: 1000px;
            margin: 30px auto;
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
            font-size: 1.3rem;
            position: relative;
        }
        
        /* Tombol Back di pojok kanan atas header */
        .btn-back-top {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back-top:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }
        .btn-back-top i {
            font-size: 0.8rem;
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
            padding: 10px 0;
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
        
        /* PAYMENT INSTRUCTION STYLES */
        .payment-instruction {
            background: #e8f4fd;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid #4f79a7;
        }
        .payment-instruction h5 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .instruction-text {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            word-break: break-word;
        }
        .instruction-text strong {
            font-size: 1.3rem;
            color: #4f79a7;
        }
        .destination-box {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #cce5ff;
        }
        .destination-label {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        .destination-text {
            font-family: monospace;
            font-size: 1.1rem;
            word-break: break-all;
            background: #f1f9ff;
            padding: 10px;
            border-radius: 8px;
            flex: 1;
        }
        .copy-btn {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-left: 10px;
            cursor: pointer;
            white-space: nowrap;
        }
        .copy-btn:hover {
            background: #3b5f87;
        }
        .account-name-text {
            font-size: 1rem;
            background: #f1f9ff;
            padding: 10px;
            border-radius: 8px;
            color: #333;
        }
        .alert-warning, .alert-danger {
            font-size: 1rem;
            padding: 15px;
        }
        
        /* UPLOAD SECTION STYLES */
        .upload-section {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .upload-section h5 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .form-label {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 10px;
            color: #333;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }
        .btn-submit {
            background: #28a745;
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .preview-image {
            max-width: 200px;
            margin-top: 10px;
            border-radius: 10px;
        }
        .required-field::after {
            content: " *";
            color: red;
        }

        /* ========================================== */
        /* PERBAIKAN TAMPILAN MOBILE */
        /* ========================================== */
        @media (max-width: 768px) {
            .upload-container {
                margin: 20px auto;
                padding: 0 12px;
            }
            
            .card-header {
                padding: 15px 20px;
                font-size: 1rem;
                text-align: center;
                padding-right: 100px;
            }
            
            .card-body {
                padding: 20px !important;
            }
            
            /* Tombol Back Top Mobile */
            .btn-back-top {
                padding: 4px 12px;
                font-size: 0.75rem;
                right: 15px;
            }
            .btn-back-top i {
                font-size: 0.7rem;
            }
            
            /* PAYMENT INSTRUCTION MOBILE */
            .payment-instruction {
                padding: 15px;
            }
            .payment-instruction h5 {
                font-size: 1rem;
            }
            .instruction-text {
                font-size: 0.9rem;
            }
            .instruction-text strong {
                font-size: 1rem;
            }
            
            .destination-box {
                padding: 12px;
            }
            .destination-text {
                font-size: 0.85rem;
            }
            .copy-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
                margin-left: 0;
                margin-top: 10px;
                width: 100%;
            }
            .d-flex.align-items-center.flex-wrap {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .destination-text.me-2 {
                margin-right: 0 !important;
                margin-bottom: 10px;
            }
            
            /* ORDER SUMMARY & CUSTOMER INFO MOBILE */
            .info-section {
                padding: 15px;
            }
            .info-row {
                flex-direction: column;
                align-items: flex-start;
                padding: 8px 0;
            }
            .info-label {
                width: 100%;
                margin-bottom: 5px;
                font-size: 0.7rem;
                color: #888;
            }
            .info-value {
                width: 100%;
                font-size: 0.85rem;
            }
            .amount-large {
                font-size: 1.2rem;
            }
            .product-img, .blockchain-img {
                width: 22px;
                height: 22px;
                margin-right: 6px;
            }
            
            /* UPLOAD SECTION MOBILE */
            .upload-section {
                padding: 15px;
            }
            .upload-section h5 {
                font-size: 1rem;
            }
            .form-label {
                font-size: 0.85rem;
            }
            .form-control {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            
            /* Tombol di mobile - hanya tombol Submit, Back sudah di header */
            .btn-submit {
                font-size: 1rem;
                padding: 12px 20px;
            }
            
            /* Alert mobile */
            .alert-warning, .alert-danger {
                font-size: 0.85rem;
                padding: 12px;
            }
        }

        /* Tablet (576px - 768px) - tetap pakai layout horizontal untuk info row */
        @media (min-width: 576px) and (max-width: 768px) {
            .info-row {
                flex-direction: row;
                align-items: center;
            }
            .info-label {
                width: 140px;
                margin-bottom: 0;
            }
            .copy-btn {
                width: auto;
                margin-left: 10px;
                margin-top: 0;
            }
            .d-flex.align-items-center.flex-wrap {
                flex-direction: row !important;
            }
        }

        /* Layar sangat kecil (max 375px) */
        @media (max-width: 375px) {
            .instruction-text {
                font-size: 0.85rem;
            }
            .info-label {
                font-size: 0.65rem;
            }
            .info-value {
                font-size: 0.8rem;
            }
            .amount-large {
                font-size: 1rem;
            }
            .card-header {
                padding-right: 95px;
            }
            .btn-back-top {
                padding: 3px 10px;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="container upload-container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-upload me-2"></i> Upload Payment Proof
                <!-- Tombol Back di pojok kanan atas -->
                <a href="{{ route('transaction.back') }}" class="btn-back-top" title="Back">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
            <div class="card-body p-4">
                
                <!-- ========================================== -->
                <!-- SECTION PAYMENT INSTRUCTION                 -->
                <!-- ========================================== -->
                <div class="payment-instruction">
                    <h5><i class="fas fa-info-circle me-2"></i> PAYMENT INSTRUCTION</h5>
                    
                    <div class="instruction-text">
                        Please transfer 
                        <strong>$ {{ number_format($tempData['amount'], 2) }}</strong>

                        @if($product1)
                            <img src="{{ asset('img/product/' . $product1->img) }}" alt="{{ $tempData['from_product_name'] }}" style="width: 22px; height: 22px; display: inline-block; margin: 0 4px; vertical-align: middle;">
                        @endif
                        {{ $tempData['from_product_name'] }}

                        @if(isset($blockchain1) && $blockchain1 && !empty($blockchain1->blockchain))
                            @if($blockchain1->blockchain_img)
                                using <img src="{{ asset('img/blockchain/' . $blockchain1->blockchain_img) }}" alt="{{ $blockchain1->blockchain }}" style="width: 18px; height: 18px; display: inline-block; margin: 0 4px; vertical-align: middle;">
                            @endif
                            {{ $blockchain1->blockchain }} Network
                        @endif

                        to:
                    </div>
                    
                    <div class="destination-box">
                        <div class="destination-label">
                            <i class="fas fa-wallet me-1"></i> 
                            @if($blockchain1 && $blockchain1->blockchain === 'Binance Pay ID')
                                Binance Pay ID
                            @elseif($blockchain1 && $blockchain1->blockchain)
                                Wallet Address
                            @else
                                Email
                            @endif
                        </div>
                        <div class="d-flex align-items-center flex-wrap">
                            <code class="destination-text me-2 flex-grow-1">{{ $paymentMethod->destination ?? 'Destination not found' }}</code>
                            <button type="button" class="copy-btn" onclick="copyToClipboard('{{ addslashes($paymentMethod->destination ?? '') }}')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        
                        @if($showAccountName && $paymentMethod && $paymentMethod->name)
                        <div class="destination-label mt-3">
                            <i class="fas fa-user me-1"></i> Account Name
                        </div>
                        <div class="account-name-text">
                            {{ $paymentMethod->name }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> Please ensure that we must receive the exact amount of <strong>{{ number_format($tempData['amount'], 2) }} USD</strong>. If there are any fees, you must cover them.
                    </div>
                </div>
                
                <!-- ========================================== -->
                <!-- SECTION UPLOAD PAYMENT PROOF                -->
                <!-- ========================================== -->
                <div class="upload-section">
                    <h5><i class="fas fa-cloud-upload-alt me-2"></i> UPLOAD PAYMENT PROOF</h5>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important:</strong> Upload proof of payment after you have made the payment.
                    </div>
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Error!</strong> 
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('payment.upload.submit') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label required-field">Payment Proof Document / Screenshot</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="form-control @error('payment_proof') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" required>
                            <small class="text-muted mt-2 d-block">Supported formats: JPG, PNG & JPEG (Max 10MB)</small>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="imagePreview" class="mb-3" style="display: none;">
                            <img id="previewImg" class="preview-image" alt="Preview">
                        </div>
                        
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <i class="fas fa-check-circle me-2"></i> SUBMIT PAYMENT PROOF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- ========================================== -->
                <!-- ORDER SUMMARY                               -->
                <!-- ========================================== -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-receipt me-2"></i> Order Summary</h6>
                    
                    <div class="info-row">
                        <div class="info-label">Amount to Pay</div>
                        <div class="info-value amount-large">{{ number_format($tempData['amount'], 2) }} USD</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">From</div>
                        <div class="info-value">
                            @if($product1)
                                <img src="{{ asset('img/product/' . $product1->img) }}" class="product-img" alt="{{ $tempData['from_product_name'] }}">
                            @endif
                            {{ $tempData['from_product_name'] }}
                        </div>
                    </div>
                    
                    @if($blockchain1)
                    <div class="info-row">
                        <div class="info-label">Blockchain (From)</div>
                        <div class="info-value">
                            @if($blockchain1->blockchain_img)
                                <img src="{{ asset('img/blockchain/' . $blockchain1->blockchain_img) }}" class="blockchain-img" alt="{{ $blockchain1->blockchain }}">
                            @endif
                            {{ $blockchain1->blockchain }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="info-row">
                        <div class="info-label">To</div>
                        <div class="info-value">
                            @if($product2)
                                <img src="{{ asset('img/product/' . $product2->img) }}" class="product-img" alt="{{ $tempData['to_product_name'] }}">
                            @endif
                            {{ $tempData['to_product_name'] }}
                        </div>
                    </div>
                    
                    @if($blockchain2)
                    <div class="info-row">
                        <div class="info-label">Blockchain (To)</div>
                        <div class="info-value">
                            @if($blockchain2->blockchain_img)
                                <img src="{{ asset('img/blockchain/' . $blockchain2->blockchain_img) }}" class="blockchain-img" alt="{{ $blockchain2->blockchain }}">
                            @endif
                            {{ $blockchain2->blockchain }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="info-row">
                        <div class="info-label">Exchange Rate</div>
                        <div class="info-value">1 {{ $tempData['from_product_name'] }} = {{ number_format($tempData['rate'], 2) }} {{ $tempData['to_product_name'] }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Fee</div>
                        <div class="info-value">{{ $tempData['fee_text'] }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">You Will Get</div>
                        <div class="info-value amount-large">{{ number_format($tempData['final_amount'], 2) }} {{ $tempData['to_product_name'] }}</div>
                    </div>
                </div>
                
                <!-- Customer Information -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-user me-2"></i> Customer Information</h6>
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $tempData['full_name'] }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $tempData['email'] }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $tempData['full_phone'] ?? $tempData['phone'] ?? '-' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">{{ $tempData['to_product_name'] }} Destination</div>
                        <div class="info-value">{{ $tempData['product2_dest'] }}</div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <script>
        function copyToClipboard(text) {
            const cleanText = text.replace(/\\/g, '');
            navigator.clipboard.writeText(cleanText).then(function() {
                alert('✓ Destination copied to clipboard!');
            }).catch(function() {
                alert('Failed to copy text. Please copy manually.');
            });
        }
        
        // Preview image before upload
        const fileInput = document.getElementById('payment_proof');
        const previewDiv = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const fileType = this.files[0].type;
                    const fileSize = this.files[0].size;
                    
                    if (!fileType.startsWith('image/')) {
                        alert('Please select an image file (JPG, PNG, or JPEG).');
                        this.value = '';
                        previewDiv.style.display = 'none';
                        return;
                    }
                    
                    if (fileSize > 10 * 1024 * 1024) {
                        alert('File size must not exceed 10MB.');
                        this.value = '';
                        previewDiv.style.display = 'none';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImg.src = event.target.result;
                        previewDiv.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewDiv.style.display = 'none';
                }
            });
        }
        
        // Handle form submission dengan validasi file
        const uploadForm = document.getElementById('uploadForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                const fileInput = document.getElementById('payment_proof');
                
                if (!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Please select a payment proof file to upload.');
                    return false;
                }
                
                // Show loading state
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Uploading...';
                }
                
                return true;
            });
        }
        
        // Prevent double submission
        let submitted = false;
        if (uploadForm) {
            uploadForm.addEventListener('submit', function() {
                if (submitted) return false;
                submitted = true;
                return true;
            });
        }
    </script>
</body>
</html>