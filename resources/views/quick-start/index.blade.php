<!-- resources/views/quick-start/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quick Start - Create Profile and Expense') }}
        </h2>
    </x-slot>

    <div class="py-6" style="background-color: #f4f7fa;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">

                <!-- Profile Creation Form -->
                <h3 class="text-lg font-semibold mb-4 text-primary">Create Profile</h3>
                <form method="POST" action="{{ route('quick.createProfile') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="name">Profile Name</label>
                        <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm w-full" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Profile</button>
                </form>

                <hr class="my-6">

                <!-- Expense Creation Form -->
                <h3 class="text-lg font-semibold mb-4 text-success">Add Expense</h3>
                <form method="POST" action="{{ route('quick.createExpense') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="profile_id">Select Profile</label>
                        <select name="profile_id" id="profile_id" class="form-select rounded-md shadow-sm w-full" required>
                            @foreach (session('profiles', []) as $profile)
                                <option value="{{ $profile['id'] }}">{{ $profile['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="category">Category</label>
                        <select name="category" id="category" class="form-select rounded-md shadow-sm w-full" required>
                            <option value="subscriptions">Subscriptions</option>
                            <option value="housing">Housing</option>
                            <option value="food">Food</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2" for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-input rounded-md shadow-sm w-full" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Expense</button>
                </form>

                <div class="mt-6">
                    <a href="{{ route('quick.summary') }}" class="btn btn-info">View Summary</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
