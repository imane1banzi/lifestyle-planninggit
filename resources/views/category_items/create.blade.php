<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Category Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-semibold mb-4 text-primary display-4">
                        <i class="bi bi-list-task"></i> Add Item to Category
                    </h1>

                    <!-- Form to Create Category Item -->
                    <form action="{{ route('category-items.store') }}" method="POST" class="mt-5">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="category_id" class="form-label">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Item Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter item name" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="monthly_cost" class="form-label">Amount ($)</label>
                            <input type="number" name="monthly_cost" id="monthly_cost" class="form-control" placeholder="Enter monthly cost" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter a brief description"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Item
                            </button>
                            <a href="{{ route('category-items.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
