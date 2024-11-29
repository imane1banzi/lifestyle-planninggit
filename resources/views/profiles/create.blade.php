<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('EmpowerProfiles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="container mt-5">
                        <h1 class="text-center font-semibold mb-4 text-success display-4">Create a New Profile</h1>

                        <div class="card p-4 shadow-sm">
                            <form action="{{ route('profiles.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">
                                        <i class="bi bi-person-circle text-primary" ></i> Name
                                    </label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter profile name (Luxury or Frugal)" required>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Create Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Bootstrap Icons CDN -->
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
