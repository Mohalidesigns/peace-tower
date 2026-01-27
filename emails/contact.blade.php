<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        h2 { color: #c5a47e; }
        .info { background: #f9f9f9; padding: 15px; margin: 10px 0; }
        .label { font-weight: bold; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Contact Form Submission</h2>
        <div class="info">
            <p><span class="label">Name:</span> {{ $name }}</p>
            <p><span class="label">Email:</span> {{ $email }}</p>
            <p><span class="label">Phone:</span> {{ $phone }}</p>
            <p><span class="label">Subject:</span> {{ $subject }}</p>
        </div>
        <div class="info">
            <p><span class="label">Message:</span></p>
            <p>{{ $message }}</p>
        </div>
    </div>
</body>
</html>
