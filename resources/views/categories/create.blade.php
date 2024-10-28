@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter Catégorie</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer Catégorie</button>
    </form>
</div>
@endsection
