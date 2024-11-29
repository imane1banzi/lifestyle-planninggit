<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Category Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mt-5">
                        <div class="text-right mb-3">
                            <a href="{{ route('category-items.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Add New Item
                            </a>
                        </div>
                     
                        <h1 class="text-center font-semibold mb-4 text-primary display-4">
                            <i class="bi bi-list-task"></i> Category Items
                        </h1>

                        <!-- Items Table -->
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description ?? 'No description provided' }}</td>
                                        <td>${{ number_format($item->monthly_cost, 2) }}</td>
                                        <td>{{ $item->category->name }}</td> <!-- Affiche la catégorie liée -->
                                        <td>
                                            <a href="{{ route('category-items.edit', $item) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('category-items.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $items->links() }} <!-- Pour afficher la pagination -->
                    </div>

                    <!-- Bootstrap Icons CDN -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
