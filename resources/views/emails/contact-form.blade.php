<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f79a7; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #4f79a7; }
        .message-box { background: white; padding: 15px; border-left: 4px solid #4f79a7; margin-top: 10px; }
        .footer { text-align: center; padding: 15px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        <div class="content">
            <div class="field">
                <div class="field-label">Name:</div>
                <div>{{ $name }}</div>
            </div>
            <div class="field">
                <div class="field-label">Email:</div>
                <div>{{ $email }}</div>
            </div>
            <div class="field">
                <div class="field-label">Subject:</div>
                <div>{{ $subject }}</div>
            </div>
            <div class="field">
                <div class="field-label">Message:</div>
                <div class="message-box">{{ nl2br(e($user_message)) }}</div>
            </div>
        </div>
        <div class="footer">
            <p>This message was sent from the Exachanger contact form.</p>
            <p>IP Address: {{ request()->ip() }} | Sent at: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>