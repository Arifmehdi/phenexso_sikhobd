<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Temporarily Unavailable</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            color: #e2e8f0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .card {
            max-width: 520px;
            width: 90%;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 14px;
            padding: 40px 36px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,.35);
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 999px;
            background: #f59e0b;
            color: #1e293b;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: .04em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        h1 { font-size: 24px; margin: 0 0 12px; }
        p { color: #94a3b8; line-height: 1.6; margin: 0 0 8px; }
        .contact { margin-top: 22px; font-size: 14px; color: #cbd5e1; }
        .contact a { color: #38bdf8; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">Maintenance Mode</span>
        <h1>Service Temporarily Unavailable</h1>
        <p>This application is currently under a temporary controlled state.</p>
        <p>All data and files remain intact and will be restored shortly.</p>
        <div class="contact">
            Please contact the service provider for further assistance.<br>
            <a href="#">Support Team</a>
        </div>
    </div>
</body>
</html>
