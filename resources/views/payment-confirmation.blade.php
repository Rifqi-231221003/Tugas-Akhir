<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Payment Confirmation - Exachanger</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .confirmation-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 15px;
        }
        .card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #28a745, #1e7e34);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 20px 25px;
            font-weight: 700;
            font-size: 1.3rem;
            text-align: center;
        }
        .status-icon {
            font-size: 70px;
            margin-bottom: 15px;
        }
        .status-icon-success {
            color: #28a745;
        }
        .status-icon-rejected {
            color: #dc3545;
        }
        .info-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            width: 130px;
            font-weight: 600;
            color: #555;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
        .info-value {
            flex: 1;
            font-weight: 500;
            color: #333;
            word-break: break-word;
            font-size: 0.9rem;
        }
        .product-img {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            margin-right: 8px;
            object-fit: cover;
            vertical-align: middle;
        }
        .blockchain-img {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            margin-right: 6px;
            object-fit: cover;
            vertical-align: middle;
        }
        .amount-large {
            font-size: 1.3rem;
            font-weight: 800;
            color: #28a745;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }
        .status-success {
            background: #28a745;
            color: white;
        }
        .status-pending {
            background: #ffc107;
            color: #856404;
        }
        .status-rejected {
            background: #dc3545;
            color: white;
        }
        .text-success-custom {
            color: #28a745;
        }
        .text-rejected {
            color: #dc3545;
        }
        .btn-save {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-save:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .btn-wa {
            background: #25D366;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-wa:hover {
            background: #128C7E;
            transform: translateY(-2px);
            color: white;
        }
        .btn-view-proof {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-view-proof:hover {
            background: #3b5f87;
            transform: translateY(-2px);
        }
        .btn-download {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-download:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        .copy-btn {
            background: #4f79a7;
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.7rem;
            margin-left: 10px;
            cursor: pointer;
            white-space: nowrap;
        }
        .copy-btn:hover {
            background: #3b5f87;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .proof-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            justify-content: center;
            align-items: center;
        }
        .proof-modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            position: relative;
        }
        .proof-modal-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .proof-modal-content iframe {
            width: 100%;
            height: 500px;
            border-radius: 8px;
        }
        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
        }
        .close-modal:hover {
            color: red;
        }
        .payment-card {
            background: white;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #e0e8f0;
        }
        .payment-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #4f79a7;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .payment-value {
            font-family: monospace;
            word-break: break-all;
            background: #f1f9ff;
            padding: 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .payment-product {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #e0e8f0;
        }
        .trx-id-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* ========================================== */
        /* PERBAIKAN TAMPILAN MOBILE */
        /* ========================================== */
        @media (max-width: 768px) {
            .confirmation-container {
                margin: 20px auto;
                padding: 0 12px;
            }
            
            .card-header {
                padding: 15px 20px;
                font-size: 1rem;
            }
            
            .card-body {
                padding: 20px !important;
            }
            
            /* Status Icon Mobile */
            .status-icon {
                font-size: 50px;
            }
            
            .status-icon h3 {
                font-size: 1.2rem;
            }
            
            /* Info Section Mobile - Stack Vertikal */
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
                font-size: 0.85rem;
            }
            
            .amount-large {
                font-size: 1.1rem;
            }
            
            .product-img {
                width: 22px;
                height: 22px;
                margin-right: 6px;
            }
            
            .blockchain-img {
                width: 18px;
                height: 18px;
                margin-right: 5px;
            }
            
            /* Payment Details Mobile */
            .payment-card {
                padding: 10px;
            }
            
            .payment-value {
                flex-direction: column;
                align-items: stretch;
            }
            
            .payment-value .copy-btn {
                margin-left: 0;
                margin-top: 8px;
                width: 100%;
                text-align: center;
            }
            
            .payment-product {
                flex-wrap: wrap;
            }
            
            /* Transaction ID Wrapper Mobile */
            .trx-id-wrapper {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .trx-id-wrapper .copy-btn {
                margin-left: 0;
                margin-top: 5px;
            }
            
            /* Action Buttons Mobile */
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .action-buttons .btn-save,
            .action-buttons .btn-wa {
                width: 100%;
            }
            
            /* Proof Section Mobile */
            .info-section .row {
                flex-direction: column;
            }
            
            .info-section .col-md-6 {
                width: 100%;
                margin-bottom: 15px;
            }
            
            .info-section .col-md-6:last-child {
                margin-bottom: 0;
            }
            
            .btn-view-proof {
                width: 100%;
                text-align: center;
            }
            
            /* Link bottom mobile */
            .text-center.mt-4 a {
                display: inline-block;
                margin: 5px 10px;
                font-size: 0.85rem;
            }
        }

        /* Tablet (576px - 768px) - tetap horizontal untuk info row */
        @media (min-width: 576px) and (max-width: 768px) {
            .info-row {
                flex-direction: row;
                align-items: center;
            }
            
            .info-label {
                width: 120px;
                margin-bottom: 0;
            }
            
            .payment-value {
                flex-direction: row;
            }
            
            .payment-value .copy-btn {
                width: auto;
                margin-top: 0;
            }
            
            .trx-id-wrapper {
                flex-direction: row;
                align-items: center;
            }
            
            .action-buttons {
                flex-direction: row;
            }
            
            .action-buttons .btn-save,
            .action-buttons .btn-wa {
                width: auto;
            }
        }

        /* Layar sangat kecil (max 375px) */
        @media (max-width: 375px) {
            .info-label {
                font-size: 0.65rem;
            }
            
            .info-value {
                font-size: 0.8rem;
            }
            
            .amount-large {
                font-size: 1rem;
            }
            
            .status-badge {
                font-size: 0.7rem;
                padding: 4px 12px;
            }
            
            .payment-label {
                font-size: 0.65rem;
            }
            
            .payment-value code {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="container confirmation-container" id="confirmation-card">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-check-circle me-2"></i> PAYMENT CONFIRMATION
            </div>
            <div class="card-body p-4">
                
                <!-- Status Section -->
                <div class="text-center mb-4">
                    @php
                        $isPending = ($transaction->trx_status == 'Pending' || $transaction->trx_status == 'pending');
                        $isRejected = ($transaction->trx_status == 'Rejected' || $transaction->trx_status == 'rejected');
                        $isSuccess = ($transaction->trx_status == 'Success' || $transaction->trx_status == 'success');
                    @endphp
                    
                    @if($isRejected)
                        <div class="status-icon status-icon-rejected">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h3 class="text-rejected">Order Rejected!</h3>
                        <p class="text-rejected">Your payment has been rejected because payment proof does not match!</p>
                    @else
                        <div class="status-icon status-icon-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="text-success-custom">Order Submitted!</h3>
                        <p class="text-muted">Your payment proof has been uploaded successfully.</p>
                    @endif
                    
                    <span class="status-badge 
                        @if($isSuccess) status-success
                        @elseif($isPending) status-pending
                        @elseif($isRejected) status-rejected
                        @endif">
                        <i class="fas fa-clock me-1"></i> {{ $transaction->trx_status }}
                    </span>
                </div>
                
                <!-- Transaction ID & Date -->
                <div class="info-section">
                    <div class="info-row">
                        <div class="info-label">Transaction ID</div>
                        <div class="info-value">
                            <div class="trx-id-wrapper">
                                <strong>{{ $transaction->trx_id }}</strong>
                                <button class="copy-btn" onclick="copyToClipboard('{{ $transaction->trx_id }}')">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Date & Time</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($transaction->trx_date)->format('d F Y, H:i:s') }}</div>
                    </div>
                </div>
                
                <!-- Transaction Details -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-receipt me-2"></i> Transaction Details</h6>
                    
                    <div class="info-row">
                        <div class="info-label">Amount Sent</div>
                        <div class="info-value amount-large">{{ number_format($transaction->product1_amount, 2) }} {{ $transaction->product1 }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Fee</div>
                        <div class="info-value">$ {{ number_format($transaction->fee, 2) }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">You Will Get</div>
                        <div class="info-value amount-large">{{ number_format($transaction->product2_amount, 2) }} {{ $transaction->product2 }}</div>
                    </div>
                </div>
                
                <!-- Payment Details -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-credit-card me-2"></i> Payment Details</h6>
                    
                    <!-- You Pay to (Product From) -->
                    <div class="payment-card">
                        <div class="payment-label">
                            <i class="fas fa-arrow-right me-1"></i> You Pay to:
                        </div>
                        <div class="payment-value">
                            <code>{{ $transaction->product1_dest }}</code>
                            <button class="copy-btn" onclick="copyToClipboard('{{ $transaction->product1_dest }}')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        <div class="payment-product">
                            @if($product1)
                                <img src="{{ asset('img/product/' . $product1->img) }}" class="product-img" style="width: 20px; height: 20px;" alt="{{ $transaction->product1 }}">
                            @endif
                            <span>{{ $transaction->product1 }}</span>
                            @if($blockchain1)
                                @if($blockchain1->blockchain_img)
                                    <img src="{{ asset('img/blockchain/' . $blockchain1->blockchain_img) }}" style="width: 16px; height: 16px; border-radius: 4px;" alt="{{ $blockchain1->blockchain }}">
                                @endif
                                <span>{{ $transaction->blockchain1 }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- You Get to (Product To) -->
                    <div class="payment-card">
                        <div class="payment-label">
                            <i class="fas fa-arrow-left me-1"></i> You Get to:
                        </div>
                        <div class="payment-value">
                            <code>{{ $transaction->product2_dest }}</code>
                            <button class="copy-btn" onclick="copyToClipboard('{{ $transaction->product2_dest }}')">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                        <div class="payment-product">
                            @if($product2)
                                <img src="{{ asset('img/product/' . $product2->img) }}" class="product-img" style="width: 20px; height: 20px;" alt="{{ $transaction->product2 }}">
                            @endif
                            <span>{{ $transaction->product2 }}</span>
                            @if($blockchain2)
                                @if($blockchain2->blockchain_img)
                                    <img src="{{ asset('img/blockchain/' . $blockchain2->blockchain_img) }}" style="width: 16px; height: 16px; border-radius: 4px;" alt="{{ $blockchain2->blockchain }}">
                                @endif
                                <span>{{ $transaction->blockchain2 }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Payment Proof Section -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-file-image me-2"></i> Payment Proof</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Proof of Sending Money</label>
                            <div class="mt-2">
                                @if($transaction->product1_payment_proof)
                                    <button class="btn-view-proof" onclick="viewPaymentProof('{{ asset($transaction->product1_payment_proof) }}', '{{ $transaction->product1 }}')">
                                        <i class="fas fa-eye me-1"></i> View Payment Proof
                                    </button>
                                @else
                                    <span class="text-muted">No proof uploaded</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Proof of Receiving Money</label>
                            <div class="mt-2">
                                @if($transaction->product2_payment_proof)
                                    <button class="btn-view-proof" onclick="viewPaymentProof('{{ asset($transaction->product2_payment_proof) }}', '{{ $transaction->product2 }}')">
                                        <i class="fas fa-eye me-1"></i> View Payment Proof
                                    </button>
                                @else
                                    <span class="text-muted">Not available yet</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Information -->
                <div class="info-section">
                    <h6 class="mb-3"><i class="fas fa-user me-2"></i> Customer Information</h6>
                    
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $transaction->client_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $transaction->client_email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $transaction->client_phonenumber }}</div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn-save" onclick="downloadAsImage()">
                        <i class="fas fa-download me-2"></i> Save as Image
                    </button>
                    
                    @if($isPending)
                        <a href="#" class="btn-wa text-decoration-none" id="whatsappBtn">
                            <i class="fab fa-whatsapp me-2"></i> Confirm Order to WhatsApp
                        </a>
                    @endif
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-decoration-none me-3">
                        <i class="fas fa-home me-1"></i> Back to Home
                    </a>
                    <a href="{{ route('track.transaction') }}" class="text-decoration-none">
                        <i class="fas fa-search me-1"></i> Track Transaction
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Modal for viewing payment proof -->
    <div id="proofModal" class="proof-modal">
        <div class="proof-modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h5 id="modalTitle">Payment Proof</h5>
            <div id="modalContent"></div>
        </div>
    </div>
    
    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Copied to clipboard: ' + text);
            }).catch(function() {
                alert('Failed to copy text');
            });
        }
        
        // Download payment proof file
        function downloadPaymentProof(fileUrl, productName) {
            fetch(fileUrl)
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    const url = URL.createObjectURL(blob);
                    const fileExtension = fileUrl.split('.').pop().toLowerCase();
                    const timestamp = new Date().toISOString().slice(0,19).replace(/:/g, '-');
                    link.download = `${productName}_payment_proof_${timestamp}.${fileExtension}`;
                    link.href = url;
                    link.click();
                    URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error downloading file:', error);
                    window.open(fileUrl, '_blank');
                });
        }
        
        // View payment proof in modal with download button
        function viewPaymentProof(fileUrl, productName) {
            const modal = document.getElementById('proofModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');
            
            modalTitle.innerHTML = '<i class="fas fa-file-image me-2"></i> ' + productName + ' Payment Proof';
            
            const fileExtension = fileUrl.split('.').pop().toLowerCase();
            
            if (fileExtension === 'pdf') {
                modalContent.innerHTML = `
                    <iframe src="${fileUrl}" frameborder="0" style="width:100%; height:500px;"></iframe>
                    <div class="text-center mt-3">
                        <button class="btn-download" onclick="downloadPaymentProof('${fileUrl}', '${productName}')">
                            <i class="fas fa-download me-2"></i> Download PDF
                        </button>
                    </div>
                `;
            } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                modalContent.innerHTML = `
                    <img src="${fileUrl}" alt="Payment Proof" style="max-width: 100%; height: auto; border-radius: 8px;">
                    <div class="text-center mt-3">
                        <button class="btn-download" onclick="downloadPaymentProof('${fileUrl}', '${productName}')">
                            <i class="fas fa-download me-2"></i> Download Image
                        </button>
                    </div>
                `;
            } else {
                modalContent.innerHTML = `
                    <p>Cannot preview this file type. <a href="${fileUrl}" target="_blank">Open file</a></p>
                    <div class="text-center mt-3">
                        <button class="btn-download" onclick="downloadPaymentProof('${fileUrl}', '${productName}')">
                            <i class="fas fa-download me-2"></i> Download File
                        </button>
                    </div>
                `;
            }
            
            modal.style.display = 'flex';
        }
        
        // Close modal
        function closeModal() {
            const modal = document.getElementById('proofModal');
            modal.style.display = 'none';
            document.getElementById('modalContent').innerHTML = '';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('proofModal');
            if (event.target === modal) {
                closeModal();
            }
        }
        
        // Download as image using html2canvas
        function downloadAsImage() {
            const element = document.getElementById('confirmation-card');
            html2canvas(element, {
                scale: 2,
                backgroundColor: '#f8f9fa',
                logging: false
            }).then(canvas => {
                const link = document.createElement('a');
                const timestamp = new Date().toISOString().slice(0,19).replace(/:/g, '-');
                link.download = 'payment_confirmation_{{ $transaction->trx_id }}_' + timestamp + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).catch(error => {
                console.error('Error generating image:', error);
                alert('Failed to generate image. Please try again.');
            });
        }
        
        // WhatsApp message (hanya jika pending)
        const whatsappBtn = document.getElementById('whatsappBtn');
        if (whatsappBtn) {
            whatsappBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                let blockchain1Text = '';
                let blockchain2Text = '';
                
                @if($transaction->blockchain1)
                blockchain1Text = 'Blockchain From: {{ $transaction->blockchain1 }}\n';
                @endif
                
                @if($transaction->blockchain2)
                blockchain2Text = 'Blockchain To: {{ $transaction->blockchain2 }}\n';
                @endif
                
                const message = `*PAYMENT CONFIRMATION - EXACHANGER*
                
*Transaction ID:* {{ $transaction->trx_id }}
*Date:* {{ \Carbon\Carbon::parse($transaction->trx_date)->format('d F Y, H:i:s') }}
*Status:* {{ $transaction->trx_status }}

*TRANSACTION DETAILS*
Amount Sent: {{ number_format($transaction->product1_amount, 2) }} {{ $transaction->product1 }}
Fee: $ {{ number_format($transaction->fee, 2) }}
You Will Get: {{ number_format($transaction->product2_amount, 2) }} {{ $transaction->product2 }}

*PAYMENT DETAILS*
You Pay to: {{ $transaction->product1_dest }} ({{ $transaction->product1 }})
You Get to: {{ $transaction->product2_dest }} ({{ $transaction->product2 }})

*CUSTOMER INFORMATION*
Name: {{ $transaction->client_name }}
Email: {{ $transaction->client_email }}
Phone: {{ $transaction->client_phonenumber }}

Thank you for your payment confirmation.`;

                const encodedMessage = encodeURIComponent(message);
                const whatsappUrl = `https://wa.me/6288296973558?text=${encodedMessage}`;
                window.open(whatsappUrl, '_blank');
            });
        }
    </script>
</body>
</html>