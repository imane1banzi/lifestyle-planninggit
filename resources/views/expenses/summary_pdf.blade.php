<!DOCTYPE html>
<html>
<head>
    <title>Profile Summary for {{ $profile->name }}</title>
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
        .text-success {
            color: #28a745;
        }
        .text-danger {
            color: #dc3545;
        }
        .text-warning {
            color: #ffc107;
        }
        .badge-info {
            background-color: #17a2b8;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
        }
        .list-group-item {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="text-success">Profile: {{ $profile->name }}</h2>

        <!-- Categories and Items -->
        <h3>Categories and Items</h3>
        @foreach ($categories as $category)
            <h4>{{ $category->name }}</h4>
            <ul>
                @foreach ($category->items as $item)
                    <li>{{ $item->name }} - ${{ number_format($item->monthly_cost, 2) }}</li>
                @endforeach
            </ul>
        @endforeach

        <!-- Expense Totals -->
        <h3>Expense Totals</h3>
        <ul>
            <li>Monthly Total: ${{ number_format($totals['monthly'], 2) }}</li>
            <li>Yearly Total: ${{ number_format($totals['yearly'], 2) }}</li>
            <li>Biweekly Total: ${{ number_format($totals['biweekly'], 2) }}</li>
            <li>Hourly Total: ${{ number_format($totals['hourly'], 2) }}</li>
        </ul>

        <!-- Income Needed -->
        <h3>Income Needed</h3>
        <ul>
            <li>Monthly Income Needed: ${{ number_format($incomeNeeded['monthly'], 2) }}</li>
            <li>Hourly Income Needed: ${{ number_format($incomeNeeded['hourly'], 2) }}</li>
        </ul>
    </div>
</body>
</html>
