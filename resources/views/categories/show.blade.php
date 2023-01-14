@extends('layouts.global')

@section('title')
Detail Categories
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="jumbotron text-center">
            <h1 class="display-4 fw-bold mb-3">Category Name : {{ $category->name }}</h1>
            @if($category->image)
            <img src="{{asset('storage/'. $category->image)}}" class="img-fluid img-thumbnail w-50" /
                style="border-radius: 2rem">
            @else
            No avatar
            @endif
            <hr class="my-4">
            <div class="fs-2">
                <b>Slug : </b>
                <span>{{ $category->slug }}</span>
            </div>

        </div>
    </div>
</div>
@endsection