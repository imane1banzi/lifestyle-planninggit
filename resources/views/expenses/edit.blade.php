<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('LifestyleExpenses') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1 class="text-center mb-4 display-4">Edit Expense</h1>
        <form action="{{ route('expenses.update', $expense) }}" method="POST" class="text-center">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="subscriptions">Subscriptions</option>
                    <option value="housing">Housing</option>
                    <option value="food">Food</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control" value="{{ $expense->amount }}" required step="0.01">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</x-app-layout>
