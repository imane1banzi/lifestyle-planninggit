<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EmpowerExpenses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-5">
                        <div class="text-right mb-3">
                            <a href="{{ route('expenses.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Create New Expense
                            </a>
                        </div>
                     
                        <h1 class="text-center font-semibold mb-4 text-primary display-4">
                            <i class="bi bi-wallet2"></i> Expense List
                        </h1>

                        <!-- Profiles and Expenses Summary -->
                        @foreach ($profiles as $profile)
                            <div class="card mb-4 shadow">
                                <div class="card-body">
                                    <h2 class="card-title text-success">Profile: {{ $profile->name }}</h2>
                                    <div class="text-right mb-3">
                                        <a href="{{ route('expenses.pdf', $profile->id) }}" class="btn btn-primary">
                                            <i class="bi bi-file-earmark-pdf"></i> Print Expenses as PDF
                                        </a>
                                    </div>
                                    <ul class="list-group list-group-flush mb-3">
                                        @foreach ($totals[$profile->id]['categories'] as $category => $total)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span>{{ ucfirst($category) }}:</span>
                                                <span class="badge badge-info">${{ number_format($total, 2) }}</span>
                                            </li>
                                        @endforeach
                                        <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                                            <span>Monthly Total:</span>
                                            <span class="text-danger">${{ number_format($totals[$profile->id]['monthly'], 2) }}</span>
                                        </li>
                                        <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                                            <span>Yearly Total:</span>
                                            <span class="text-danger">${{ number_format($totals[$profile->id]['yearly'], 2) }}</span>
                                        </li>
                                        <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                                            <span>Biweekly Total:</span>
                                            <span class="text-danger">${{ number_format($totals[$profile->id]['biweekly'], 2) }}</span>
                                        </li>
                                        <li class="list-group-item font-weight-bold d-flex justify-content-between align-items-center">
                                            <span>Hourly Total:</span>
                                            <span class="text-danger">${{ number_format($totals[$profile->id]['hourly'], 2) }}</span>
                                        </li>
                                    </ul>

                                    <h3 class="text-secondary">Income Needed</h3>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Monthly Income Needed:</span>
                                            <span class="text-warning">${{ number_format($incomeNeeded[$profile->id]['monthly'], 2) }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>Hourly Income Needed:</span>
                                            <span class="text-warning">${{ number_format($incomeNeeded[$profile->id]['hourly'], 2) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                        <!-- All Expenses Table -->
                        <h2 class="text-center mb-4 text-primary">All Expenses</h2>
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Profile</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $profiles->firstWhere('id', $expense->profile_id)->name }}</td>
                                        <td>{{ $expense->category->name }}</td> <!-- Affiche la catégorie associée -->
                                        <td>${{ number_format($expense->amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this expense?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Bootstrap Icons CDN -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
