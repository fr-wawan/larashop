@extends('layouts.global')

@section('title')
Edit Categories
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        <form action="{{ route('categories.update',[$category->id]) }}" method="post" enctype="multipart/form-data"
            class="shadow-sm bg-white p-3">
            @method("PUT")
            @csrf

            <div class="my-3">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name',$category->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <div class="my-3">
                @if ($category->image)
                <p>Current Image : </p>
                <img src="{{ asset('storage/' . $category->image) }}" alt="" width="120px" class="mb-3">
                @endif
                <input type="file" name="image" id="image" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
            </div>



            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection