@extends('layouts.global')

@section('title')
Books List
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        <h1 class="text-center mb-3">List Books</h1>

        <div class="row mb-3 ">
            <div class="col-md-6 ">
                <form action="{{ route('books.index') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" value="{{ Request::get('keyword') }}"
                            placeholder="Filter by title">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a href="{{ route('books.index') }}"
                            class="nav-link {{ Request::get('status') == NULL && Request::path() == 'books' ? 'active' : '' }}">All</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.index',['status' => 'publish']) }}"
                            class="nav-link {{ Request::get('status') == 'publish' ? 'active' : '' }}">Publish</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.index',['status' => 'draft']) }}"
                            class="nav-link {{ Request::get('status') == 'draft' ? 'active' : '' }}">Draft</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('books.trash') }}" class="nav-link">Trash</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mb-3 ">
            <div class="col-md-12 ">
                <a href="{{ route('books.create') }}" class="btn btn-primary">Create Book</a>
            </div>
        </div>
        <table class="table  table-bordered">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>status</th>
                    <th>Categories</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <td>
                        @if ($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" width="96px" alt="">
                        @endif
                    </td>

                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>
                        @if ($book->status == "DRAFT")
                        <span class="badge bg-dark text-white p-1">{{ $book->status }}</span>
                        @else
                        <span class="badge badge-success p-1">{{ $book->status }}</span>
                        @endif
                    </td>
                    <td>
                        <ul>
                            @foreach ($book->categories as $category)
                            <li>{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $book->stock }}</td>
                    <td>{{ $book->price }}</td>
                    <td>
                        <a href="{{ route('books.edit',[$book->id]) }}" class="btn btn-info btn-sm">Edit</a>

                        <form action="{{ route('books.destroy',[$book->id]) }}" class="d-inline"
                            onsubmit="return confirm('Move book to trash?')" method="post">

                            @method('DELETE')
                            @csrf

                            <button type="submit" class="btn btn-danger btn-sm">Trash</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{ $books->appends(Request::all())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection