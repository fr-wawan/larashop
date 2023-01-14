@extends('layouts.global')

@section('title')
Edit Order
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif

        <form action="{{ route('orders.update',[$order->id]) }}" class="shadow-sm bg-white p-3" method="post">
            @method("PUT")
            @csrf

            <div>
                <label for="invoice_number">Invoice Number</label>
                <input type="text" name="invoice_number" id="invoice_number" class="form-control"
                    value="{{ $order->invoice_number }}" disabled>
            </div>
            <div>
                <label>Buyer</label>
                <input type="text" class="form-control" disabled value="{{ $order->user->name }}">
            </div>
            <div>
                <label for="created_at">Order Date</label>
                <input type="text" name="created_at" id="created_at" class="form-control"
                    value="{{ $order->created_at }}">
            </div>
            <div>
                <label for="">Books {{ $order->totalQuantity }}</label>
                <br>
                <ul>
                    @foreach ($order->books as $book)
                    <li>{{ $book->title }} <b>{{ $book->pivot->quantity }}</b></li>
                    @endforeach
                </ul>
            </div>x
            <div>
                <label for="">Total Price</label>
                <input type="text" class="form-control" value="{{ $order->total_price }}">
            </div>

            <div>
                <label for="status"></label>
                <select name="status" id="status" class="form-control">
                    <option value="SUBMIT" {{ $order->status == "SUBMIT" ? "selected" : '' }}>SUBMIT</option>
                    <option value="PROCESS" {{ $order->status == "PROCESS" ? "selected" : '' }}>PROCESS</option>
                    <option value="FINISH" {{ $order->status == "FINISH" ? "selected" : '' }}>FINISH</option>
                    <option value="CANCEL" {{ $order->status == "CANCEL" ? "selected" : '' }}>CANCEL</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection