<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories and Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Form to Add Category -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-lg text-primary">
                            <i class="bi bi-plus-circle text-success"></i> Add Category
                        </h3>
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" name="name" id="category_name" class="form-control" placeholder="Enter category name (subscriptions, housing, food)" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="is_required" class="form-label">Is Required?</label>
                                <select name="is_required" id="is_required" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select name="is_active" id="is_active" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Category
                            </button>
                        </form>
                    </div>

                    <hr class="my-6">

                    <!-- Form to Add Category Item -->
                    <div class="mb-5">
                        <h3 class="font-semibold text-lg text-secondary">
                            <i class="bi bi-plus-circle text-info"></i> Add Category Item
                        </h3>
                        <form action="{{ route('category-items.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Select Category</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="item_name" class="form-label">Item Name</label>
                                <input type="text" name="name" id="item_name" class="form-control" placeholder="Enter item name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="monthly_cost" class="form-label">Amount ($)</label>
                                <input type="number" name="monthly_cost" id="monthly_cost" class="form-control" placeholder="Amount" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter a brief description (optional)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Item
                            </button>
                        </form>
                    </div>

                    <hr class="my-6">

                    <!-- List of Categories and Items -->
                    <h3 class="font-semibold text-lg text-primary">
                        <i class="bi bi-list-task text-info"></i> Categories and Items
                    </h3>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th><i class="bi bi-archive text-info"></i> Category Name</th>
                                <th><i class="bi bi-box text-warning"></i> Items (Name - Cost)</th>
                                <th><i class="bi bi-cash-stack text-success"></i> Total Cost</th>
                                <th><i class="bi bi-gear text-warning"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($category->items as $item)
                                                <li>
                                                    {{ $item->name }} - ${{ number_format($item->monthly_cost, 2) }}
                                                    <!-- Actions for each item -->
                                                    <a href="{{ route('category-items.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil text-primary"></i> Edit
                                                    </a>
                                                    <form action="{{ route('category-items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">
                                                            <i class="bi bi-trash text-danger"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>${{ number_format($category->total_cost, 2) }}</td>
                                    <td>
                                        <!-- Actions for each category -->
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil text-primary"></i> Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="bi bi-trash text-danger"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>                    
                </div>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
            </div>
        </div>
    </div>
</x-app-layout>