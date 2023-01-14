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
        <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data"
            class="shadow-sm bg-white p-3">
            @csrf

            <div>
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                    placeholder="Book Title">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div>
                <label for="cover">Cover</label>
                <input type="file" class="form-control  @error('title') is-invalid @enderror" name="cover">
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
                    placeholder="Give a description about this book"></textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="stock">Stock</label>
                <input type="text" name="stock" class="form-control @error('stock') is-invalid @enderror" min="0"
                    value="0" id="stock">
                @error('stock')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="author">Author</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" id=" author"
                    placeholder="Book Author">
                @error('author')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="publisher">Publisher</label>
                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" id="
                    publisher" placeholder="Book publisher">
                @error('publisher')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price"
                    placeholder="Book price">
                @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button class="btn btn-primary" name="save_action" value="PUBLISH">Publish</button>
            <button class="btn btn-secondary" name="save_action" value="DRAFT">Save As Draft</button>
        </form>
    </div>
</div>
@endsection