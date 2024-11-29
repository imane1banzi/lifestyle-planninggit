<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Expense') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Expense</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('expenses.update', $expense->id) }}" method="POST" class="shadow p-4 bg-light rounded">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $expense->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }} (Total: ${{ number_format($category->total_cost, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="profile_id">Profile</label>
                <select name="profile_id" id="profile_id" class="form-control" required>
                    @foreach ($profiles as $profile)
                        <option value="{{ $profile->id }}" {{ $expense->profile_id == $profile->id ? 'selected' : '' }}>
                            {{ $profile->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update Expense</button>
        </form>
    </div>
</x-app-layout>
