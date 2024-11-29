<x-app-layout> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quick Start - Manage Categories, Items, and Expenses') }}
        </h2>
    </x-slot>

    <div class="py-6" style="background-color: #f4f7fa;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">

                <!-- Profile Creation Form -->
                <h3 class="text-lg font-semibold mb-4 text-blue-600">Create Profile</h3>
                <form method="POST" action="{{ route('quick.createProfile') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="profile_name">Profile Name</label>
                        <input type="text" name="name" id="profile_name" 
                               class="form-input rounded-md shadow-sm w-full" 
                               placeholder="Enter profile name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Profile</button>
                </form>

                <hr class="my-6">

                <!-- Category Creation Form -->
                <h3 class="text-lg font-semibold mb-4 text-primary">Add Category</h3>
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="category_name">Category Name</label>
                        <input type="text" name="name" id="category_name" 
                               class="form-input rounded-md shadow-sm w-full" 
                               placeholder="Enter category name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>

                <hr class="my-6">

                <!-- Category Item Creation Form -->
                <h3 class="text-lg font-semibold mb-4 text-secondary">Add Category Item</h3>
                <form method="POST" action="{{ route('quick.category-items.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="category_id">Select Category</label>
                        <select name="category_id" id="category_id" class="form-select rounded-md shadow-sm w-full" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="item_name">Item Name</label>
                        <input type="text" name="name" id="item_name" 
                               class="form-input rounded-md shadow-sm w-full" 
                               placeholder="Enter item name" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="monthly_cost">Amount ($)</label>
                        <input type="number" name="monthly_cost" id="monthly_cost" 
                               class="form-input rounded-md shadow-sm w-full" 
                               placeholder="Enter monthly cost" required step="0.01">
                    </div>
                    <button type="submit" class="btn btn-success">Add Item</button>
                </form>

                <hr class="my-6">

                <!-- Expense Calculation (Based on Category Totals) -->
                <h3 class="text-lg font-semibold mb-4 text-success">Calculate Expense</h3>
                <form method="POST" action="{{ route('quick.createExpense') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="profile_id">Select Profile</label>
                        <select name="profile_id" id="profile_id" class="form-select rounded-md shadow-sm w-full" required>
                            @foreach ($profiles as $profile)
                                <option value="{{ $profile['id'] }}">{{ $profile['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="category_id">Select Category</label>
                        <select name="category_id" id="category_id" class="form-select rounded-md shadow-sm w-full" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }} (Total: ${{ number_format($category['total_cost'], 2) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Calculate Expense</button>
                </form>

                <div class="mt-6">
                    <a href="{{ route('quick.summary') }}" class="btn btn-info">View Summary</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
