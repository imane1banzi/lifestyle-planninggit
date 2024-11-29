<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Recommendation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center mb-4 text-primary">Add Recommendation</h1>

                    <form action="{{ route('recommendations.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="profession_name" class="form-label">Profession Name</label>
                            <input type="text" name="profession_name" id="profession_name" class="form-control" placeholder="Enter profession name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="hourly_rate" class="form-label">Hourly Rate</label>
                            <input type="number" name="hourly_rate" id="hourly_rate" class="form-control" placeholder="Enter hourly rate" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter description (optional)"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save
                            </button>
                            <a href="{{ route('recommendations.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
