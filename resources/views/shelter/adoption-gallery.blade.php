@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Adoption Gallery</h1>
    <div class="row">
        @foreach($dogs as $dog)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset('storage/' . $dog->main_photo) }}" class="card-img-top" alt="{{ $dog->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $dog->name }}</h5>
                    <p class="card-text">{{ $dog->description }}</p>
                    <a href="#" class="btn btn-primary">Adopt Me</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection