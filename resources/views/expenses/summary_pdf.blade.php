<!DOCTYPE html>
<html>
<head>
    <title>Profile Summary for {{ $profile->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6; /* Augmente l'espacement entre les lignes */
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .text-success {
            color: #28a745;
            margin-bottom: 10px; /* Espace sous le titre */
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
            margin-bottom: 10px; /* Espace entre les éléments de la liste */
        }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="text-success">Profile: {{ $profile->name }}</h2>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Subscriptions:</span>
                <span class="badge badge-info">{{ $totals['subscriptions'] ?? '0' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Housing:</span>
                <span class="badge badge-info">{{ $totals['housing'] ?? '0' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Food:</span>
                <span class="badge badge-info">{{ $totals['food'] ?? '0' }}</span>
            </li>
            <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                <span>Monthly Total:</span>
                <span class="text-danger">${{ $totals['monthly'] ?? '0' }}</span>
            </li>
            <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                <span>Yearly Total:</span>
                <span class="text-danger">${{ $totals['yearly'] ?? '0' }}</span>
            </li>
            <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                <span>Biweekly Total:</span>
                <span class="text-danger">${{ $totals['biweekly'] ?? '0' }}</span>
            </li>
            <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                <span>Hourly Total:</span>
                <span class="text-danger">${{ $totals['hourly'] ?? '0' }}</span>
            </li>
        </ul>

        <h3 class="text-secondary" style="margin-top: 20px;">Income Needed</h3> <!-- Espace au-dessus du titre -->
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Monthly Income Needed:</span>
                <span class="text-warning">${{ $incomeNeeded['monthly'] ?? '0' }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Hourly Income Needed:</span>
                <span class="text-warning">${{ $incomeNeeded['hourly'] ?? '0' }}</span>
            </li>
        </ul>
    </div>
</body>
</html>
