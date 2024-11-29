<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('category-items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">Item Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="monthly_cost">Amount ($)</label>
                            <input type="number" name="monthly_cost" id="monthly_cost" class="form-control" value="{{ $item->monthly_cost }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
