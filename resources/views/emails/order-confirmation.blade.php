<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - Exachanger</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #4f79a7, #3b5f87);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 16px 16px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .order-info {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }
        .order-info h2 {
            margin: 0 0 5px;
            color: #4f79a7;
            font-size: 18px;
        }
        .order-info p {
            margin: 0;
            color: #666;
        }
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
            border-left: 4px solid #4f79a7;
            padding-left: 12px;
            margin: 25px 0 15px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
        }
        .detail-value {
            color: #333;
            font-weight: 500;
        }
        .amount-large {
            font-size: 20px;
            font-weight: 800;
            color: #4f79a7;
        }
        .status-badge {
            background: #ffc107;
            color: #333;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #888;
        }
        .contact-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 12px;
            margin-top: 20px;
            text-align: center;
        }
        .contact-info a {
            color: #4f79a7;
            text-decoration: none;
        }
        .cc-note {
            background: #fff3cd;
            padding: 10px;
            border-radius: 8px;
            font-size: 12px;
            margin-top: 15px;
            text-align: center;
        }
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            .content {
                padding: 20px;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-value {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Exachanger</h1>
            <p>Digital Currency Exchange</p>
        </div>
        <div class="content">
            <div class="order-info">
                <h2>Thank you for your order!</h2>
                <p>Your payment proof has been received and is being processed.</p>
                <!-- <p style="margin-top: 10px;"><span class="status-badge">{{ $status }}</span></p> -->
            </div>
            
            <div class="section-title">Order Details</div>
            <div class="detail-row">
                <span class="detail-label">Order ID</span>
                <span class="detail-value"><strong>#{{ $transaction_id }}</strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Order Date</span>
                <span class="detail-value">{{ $order_date }}</span>
            </div>
            
            <div class="section-title">Exchange Summary</div>
            <div class="detail-row">
                <span class="detail-label">You Send</span>
                <span class="detail-value">{{ number_format($tempData['amount'], 2) }} USD → <strong>{{ $from_currency }}</strong></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Exchange Rate</span>
                <span class="detail-value">1 {{ $from_currency }} = {{ $rate }} {{ $to_currency }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Fee</span>
                <span class="detail-value">{{ $fee }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">You Will Receive</span>
                <span class="detail-value amount-large">{{ $final_amount }} {{ $to_currency }}</span>
            </div>
            
            <div class="section-title">Destination Information</div>
            <div class="detail-row">
                <span class="detail-label">{{ $to_currency }} Wallet Address</span>
                <span class="detail-value">{{ $destination_wallet }}</span>
            </div>
            
            <div class="section-title">Customer Information</div>
            <div class="detail-row">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">{{ $customer_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $customer_email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value">{{ $customer_phone }}</span>
            </div>
            
            <div class="contact-info">
                <p><strong>Need help?</strong> Contact our support team:</p>
                <p>
                    📞 <a href="https://wa.me/6288296973558">+62 882 9697 3558</a><br>
                    ✉️ <a href="mailto:admin@exachanger.com">admin@exachanger.com</a>
                </p>
            </div>
            
            <div class="cc-note">
                <i class="fas fa-envelope"></i> A copy of this email has been sent to our admin team.
            </div>
            
            <div class="footer">
                <p>© {{ date('Y') }} Exachanger by Vepay Multipayment International Inc.<br>All rights reserved.</p>
                <p>This is an automated message, please do not reply directly to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>