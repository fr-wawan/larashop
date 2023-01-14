@extends('layouts.global')

@section('title')
List Categories
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        <div class="row">
            <div class="col-md-6 mb-3">
                <form action="{{ route('categories.index') }}">
                    <div class="input-group">
                        <input type="text" name="keyword" id="name" placeholder="Filter by category Name"
                            class="form-control">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-6">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link active">Published</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.trash') }}" class="nav-link">Trash</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('categories.create') }}" class="btn btn-primary my-3">Create Category</a>
            </div>
        </div>

        <table class="table shadow-sm">
            <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        @if ($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" width="48px">
                        @else
                        No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('categories.show', [$category->id]) }}" class="btn btn-primary">Detail</a>
                        <a href="{{ route('categories.edit',[$category->id]) }}" class="btn btn-primary">Edit</a>

                        <form action="{{ route('categories.destroy', [$category->id]) }}" method="post" class="d-inline"
                            onsubmit="return confirm('Move Category To Trash?')">
                            @method('DELETE')
                            @csrf

                            <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <td colspan="10">
                    {{ $categories->appends(Request::all())->links() }}
                </td>
            </tfoot>
        </table>
    </div>
</div>
@endsection