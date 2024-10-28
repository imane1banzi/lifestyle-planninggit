<!DOCTYPE html>
<html>
<head>
    <title>All Profiles Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #ffc107; }
    </style>
</head>
<body>
    @foreach ($pdfData as $data)
        <div class="card">
            <h2 class="text-success">Profile: {{ $data['profile']->name }}</h2>
            <ul>
                <li>Subscriptions: {{ $data['totals']['subscriptions'] ?? '0' }}</li>
                <li>Housing: {{ $data['totals']['housing'] ?? '0' }}</li>
                <li>Food: {{ $data['totals']['food'] ?? '0' }}</li>
                <li>Monthly Total: ${{ $data['totals']['monthly'] ?? '0' }}</li>
                <li>Yearly Total: ${{ $data['totals']['yearly'] ?? '0' }}</li>
                <li>Biweekly Total: ${{ $data['totals']['biweekly'] ?? '0' }}</li>
                <li>Hourly Total: ${{ $data['totals']['hourly'] ?? '0' }}</li>
            </ul>
            <h3 class="text-secondary">Income Needed</h3>
            <ul>
                <li>Monthly Income Needed: ${{ $data['incomeNeeded']['monthly'] ?? '0' }}</li>
                <li>Hourly Income Needed: ${{ $data['incomeNeeded']['hourly'] ?? '0' }}</li>
            </ul>
        </div>
    @endforeach
</body>
</html>
