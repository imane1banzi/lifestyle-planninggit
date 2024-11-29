<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recommendations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-right mb-4">
                        <a href="{{ route('recommendations.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Add Recommendation
                        </a>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Profession</th>
                                <th>Hourly Rate</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recommendations as $recommendation)
                                <tr>
                                    <td>{{ $recommendation->profession_name }}</td>
                                    <td>${{ number_format($recommendation->hourly_rate, 2) }}</td>
                                    <td>{{ $recommendation->description ?? 'No description provided' }}</td>
                                    <td>
                                        <a href="{{ route('recommendations.edit', $recommendation) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('recommendations.destroy', $recommendation) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this recommendation?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $recommendations->links() }} <!-- Pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
