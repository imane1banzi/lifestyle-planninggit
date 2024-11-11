<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Summary') }}
        </h2>
    </x-slot>

    <div class="py-6" style="background-color: #f4f7fa;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">

                <h3 class="text-lg font-semibold mb-4 text-primary">Profile and Expense Summary</h3>

                <!-- Vérifier si aucun profil n'est créé -->
                @if (empty($profiles) && empty($expenses))
                    <p class="text-center text-gray-600">No profiles or expenses have been created yet.</p>
                @else
                    <!-- Profiles List with Totals -->
                    @foreach ($profiles as $profile)
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2 text-primary">{{ $profile['name'] }}</h4>

                            <!-- Montants par catégorie -->
                            <div class="card p-3 mb-4 shadow-sm">
                                <h5 class="font-semibold text-secondary">Categories</h5>
                                <ul class="list-group">
                                    @foreach (['subscriptions', 'housing', 'food'] as $category)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ ucfirst($category) }}
                                            <span class="badge badge-primary">${{ number_format($profileTotals[$profile['id']][$category], 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Total Mensuel et Annuel -->
                            <hr class="my-4">
                            <div class="card p-3 shadow-sm">
                                <h5 class="font-semibold mb-2 text-secondary">Totals for {{ $profile['name'] }}</h5>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Monthly Total
                                        <span class="badge badge-success">${{ number_format($profileTotals[$profile['id']]['monthly'], 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Yearly Total
                                        <span class="badge badge-danger">${{ number_format($profileTotals[$profile['id']]['yearly'], 2) }}</span>
                                    </li>

                                    <!-- New Calculations -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Biweekly Total
                                        <span class="badge badge-info">${{ number_format($profileTotals[$profile['id']]['biweekly'], 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Hourly Total
                                        <span class="badge badge-warning">${{ number_format($profileTotals[$profile['id']]['hourly'], 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Income Needed
                                        <span class="badge badge-secondary">${{ number_format($profileTotals[$profile['id']]['income_needed'], 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Monthly Income Needed
                                        <span class="badge badge-success">${{ number_format($profileTotals[$profile['id']]['monthly_income_needed'], 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Hourly Income Needed
                                        <span class="badge badge-warning">${{ number_format($profileTotals[$profile['id']]['hourly_income_needed'], 2) }}</span>
                                    </li>
                                </ul>
                            </div>

                            <hr class="my-6">
                        </div>
                    @endforeach
                @endif

                <a href="{{ route('quick.start') }}" class="btn btn-primary mt-4">Back to Quick Start</a>
            </div>
        </div>
    </div>

    <style>
        .badge {
            font-size: 1rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
        }

        .card {
            border-radius: 0.375rem;
        }

        .list-group-item {
            font-size: 1rem;
            padding: 1rem;
        }

        .shadow-sm {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .my-6 {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .my-4 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-primary {
            color: #1f2d3d;
        }

        .text-secondary {
            color: #495057;
        }

        h4, h5 {
            font-weight: 600;
            color: #1f2d3d;
        }

        h5 {
            margin-bottom: 1rem;
        }
    </style>
</x-app-layout>
