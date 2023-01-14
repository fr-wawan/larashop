@extends('layouts.global')

@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#categories').select2({
        ajax: {
        url : 'http://larashop.test/ajax/categories/search',
        processResults : function(data){
            return {
                results : data.map(function(item){
                    return {id : item.id, text:item.name}
                })
            }
        }
    }
});


var categories = {!! $book->categories !!}

categories.forEach(function(category){
    var option = new Option(category.name, category.id, true,true);
    $('#categories').append(option).trigger('change');
});
</script>
@endsection

@section('title')
Create Book
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        <form action="{{ route('books.update',[$book->id]) }}" method="post" enctype="multipart/form-data"
            class="shadow-sm bg-white p-3">
            @method('PUT')
            @csrf

            <div>
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $book->title }}"
                    name="title" placeholder="Book Title">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="cover">Cover</label>
                <small class="text-muted d-block mb-1">Current Cover</small>
                @if ($book->cover)
                <img src="{{ asset('storage/' . $book->cover) }}" width="96px" alt="">
                @endif
                <input type="file" class="form-control mt-3 @error('cover') is-invalid @enderror" name="cover">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                @error('cover')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div>
                <label for="categories">Categories</label>
                <select name="categories[]" multiple id="categories"
                    class="form-control @error('categories') is-invalid @enderror"></select>
                @error('categories')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="description">Description</label>
                <textarea name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Give a description about this book">{{ old('description',$book->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="stock">Stock</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                    value="{{ old('stock',$book->stock) }}" min="0" value="0" id="stock">
                @error('stock')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="author">Author</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id="author"
                    value="{{ old('author',$book->author) }}" placeholder="Book Author">
                @error('author')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="publisher">Publisher</label>
                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror"
                    id="publisher" value="{{ old('publisher',$book->publisher) }}" placeholder="Book publisher">
                @error('publisher')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price"
                    value="{{ $book->price }}" placeholder="Book price">
                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="my-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                    <option {{ $book->status == 'PUBLISH' ? 'selected' : "" }}value="PUBLISH">Publish</option>
                    <option {{ $book->status == 'DRAFT' ? 'selected' : "" }}value="DRAFT">Draft</option>
                </select>
                @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button class="btn btn-primary" name="save_action" value="PUBLISH">Update</button>
        </form>

    </div>
</div>
@endsection