@extends('layouts.global')

@section('title')
Trashed Categories
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-md-10">
    <div class="row mb-5">
      <div class="col-md-6">
        <form action="{{ route('categories.index') }}">
          <div class="input-group">
            <input type="text" name="name" id="name" class="form-control" placeholder="Filter by Category Name"
              value="{{ Request::get('name') }}">

            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-6">
        <ul class="nav nav-pills card-header-pills">
          <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">Published</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link active">Trash</a>
          </li>
        </ul>
      </div>
    </div>

    <table class="table shadow-sm">
      <thead class="thead-light">
        <tr>
          <th>Nama</th>
          <th>Slug</th>
          <th>Image</th>
          <th>Action</th>
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
            @endif
          </td>
          <td>
            <a href="{{ route('categories.restore',[$category->id]) }}" class="btn btn-primary">Restore</a>
            <form action="{{ route('categories.delete-permanent',[$category->id]) }}" method="post" class="d-inline"
              onsubmit="return confirm('Delete this category permanently?')">

              @method('DELETE')
              @csrf

              <button type="submit" class="btn btn-primary">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="10">
            {{ $categories->appends(Request::all())->links() }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
</div>

@endsection