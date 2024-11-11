<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empower') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: #f4f7fa;">
        @csrf
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-success">{{ __("Welcome to Your Lifestyle & Career Planning!") }}</h3>
                    

                    <!-- Affichage si l'utilisateur est authentifié -->
                    @auth
                    <p class="text-gray-600 mb-4">{{ __("Here are some insights about your application:") }}</p>
                        <div class="row text-center">
                            <!-- Card for Total Profiles -->
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('profiles.index') }}" class="text-decoration-none text-primary">
                                    <div class="card shadow-sm border border-primary">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-primary">
                                                <i class="bi bi-person-fill" style="font-size: 2rem; color: #007bff;"></i>
                                                <span class="d-block">Total Profiles</span>
                                            </h5>
                                            <p class="card-text">{{ $totalProfiles }} profiles created.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Card for Total Expenses -->
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('expenses.index') }}" class="text-decoration-none text-success">
                                    <div class="card shadow-sm border border-success">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-success">
                                                <i class="bi bi-wallet-fill" style="font-size: 2rem; color: #28a745;"></i>
                                                <span class="d-block">Total Expenses</span>
                                            </h5>
                                            <p class="card-text">${{ $totalExpenses }} total expenses recorded.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Card for Yearly Budget -->
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('expenses.index') }}" class="text-decoration-none text-warning">
                                    <div class="card shadow-sm border border-warning">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-warning">
                                                <i class="bi bi-credit-card" style="font-size: 2rem; color: #ffc107;"></i>
                                                <span class="d-block">Yearly Budget</span>
                                            </h5>
                                            <p class="card-text">Your current yearly budget is ${{ number_format($yearlyTotal) }}.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-semibold mb-3 text-primary">{{ __("Features Overview") }}</h4>
                            <div class="row text-center">
                                <!-- Feature 1 -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm border border-info">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-info">
                                                <i class="bi bi-person-fill"></i> Manage Profiles
                                            </h5>
                                            <p class="card-text">Create and manage different lifestyle profiles.</p>
                                            <a href="{{ route('profiles.index') }}" class="btn btn-info">Go to Profiles</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feature 2 -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm border border-secondary">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-secondary">
                                                <i class="bi bi-wallet-fill"></i> View Expenses
                                            </h5>
                                            <p class="card-text">Track your expenses by category and profile.</p>
                                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary">View Expenses</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Feature 3 -->
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm border border-danger">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-danger">
                                                <i class="bi bi-plus-circle-fill"></i> Add Expense
                                            </h5>
                                            <p class="card-text">Input new expenses into your profiles.</p>
                                            <a href="{{ route('expenses.create') }}" class="btn btn-danger">Add Expense</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endauth

                    <!-- Affichage si l'utilisateur n'est pas authentifié -->
                    @guest
                        
                        <p class="text-gray-600 mb-4">{{ __("Get started by creating a profile and adding your expenses.") }}</p>
                        <div class="row text-center">
                            <div class="col-md-6 mb-4">
                                <a href="{{ route('quick.start') }}" class="text-decoration-none">
                                    <div class="card shadow-sm border border-info">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-info">
                                                <i class="bi bi-person-plus" style="font-size: 1.5rem;"></i> Create Profile
                                            </h5>
                                            <p class="card-text text-info">Start by creating a lifestyle profile to organize your plans.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 mb-4">
                                <a href="{{ route('quick.start') }}" class="text-decoration-none">
                                    <div class="card shadow-sm border border-secondary">
                                        <div class="card-body bg-light">
                                            <h5 class="card-title text-secondary">
                                                <i class="bi bi-wallet2" style="font-size: 1.5rem;"></i> Add Expenses
                                            </h5>
                                            <p class="card-text text-secondary">Track expenses and manage your budget efficiently.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</x-app-layout>
