@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Catégories</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn btn-primary">Ajouter Catégorie</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <!-- Edit and Delete actions can be added here -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
