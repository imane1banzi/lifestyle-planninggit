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

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }} (Total: ${{ number_format($category->total_cost, 2) }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="profile_id">Profile</label>
                <select name="profile_id" id="profile_id" class="form-control" required>
                    @foreach ($profiles as $profile)
                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Create Expense</button>
        </form>
    </div>
</x-app-layout>
