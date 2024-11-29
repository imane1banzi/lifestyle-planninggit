<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Expense') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Create an Expense</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expenses.store') }}" method="POST" class="shadow p-4 bg-light rounded">
            @csrf

            <!-- Category Field -->
            <div class="form-group">
                <label for="category_id">
                    <i class="bi bi-tags text-success"></i> Category
                </label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }} (Total: ${{ number_format($category->total_cost, 2) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Profile Field -->
            <div class="form-group mt-3">
                <label for="profile_id">
                    <i class="bi bi-person-circle text-primary"></i> Profile
                </label>
                <select name="profile_id" id="profile_id" class="form-control" required>
                    @foreach ($profiles as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4">
                <i class="bi bi-save"></i> Create Expense
            </button>
        </form>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</x-app-layout>
