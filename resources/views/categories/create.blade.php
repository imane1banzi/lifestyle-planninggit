<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-semibold mb-4 text-primary display-4">
                        <i class="bi bi-list-task"></i> Add Category
                    </h1>

                    <!-- Form to Create Category -->
                    <form action="{{ route('categories.store') }}" method="POST" class="mt-5">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="is_required" class="form-label">Is Required?</label>
                            <select name="is_required" id="is_required" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</x-app-layout>
