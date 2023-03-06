@extends('layouts.global')

@section('title')
Create Category
@endsection

@section('content')
@if(session('status'))
<div class="alert alert-success">
    {{session('status')}}
</div>
@endif
<div class="row justify-content-center">
    <div class="col-md-8">
        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data"
            class="bg-white shadow-sm p-3">
            @csrf

            <div class="my-3">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" placeholder="Category Name"
                    class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <label for="image">Category Image</label>
            <div class="mb-3">
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection