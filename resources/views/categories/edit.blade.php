<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="is_required">Is Required?</label>
                            <select name="is_required" id="is_required" class="form-control">
                                <option value="1" {{ $category->is_required ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$category->is_required ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="is_active">Status</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
