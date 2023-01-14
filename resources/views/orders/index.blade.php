@extends('layouts.global')

@section('title')
List Books
@endsection

@section('content')
<form action="{{ route('orders.index') }}">
    <div class="row">
        <div class="col-md-5 mb-5">
            <input type="text" class="form-control" value="{{Request::get('buyer_email')}}" name="buyer_email"
                placeholder="Search by Buyer Email">
        </div>
        <div class="col-md-2">
            <select name="status" id="status" class="form-control">
                <option value="">ANY</option>
                <option {{Request::get('status')=="SUBMIT" ? "selected" : "" }} value="SUBMIT">SUBMIT</option>
                <option {{Request::get('status')=="PROCESS" ? "selected" : "" }} value="PROCESS">PROCESS</option>
                <option {{Request::get('status')=="FINISH" ? "selected" : "" }} value="FINISH">FINISH</option>
                <option {{Request::get('status')=="CANCEL" ? "selected" : "" }} value="CANCEL">CANCEL</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Status</th>
                    <th>Buyer</th>
                    <th>Total quantity</th>
                    <th>Order date</th>
                    <th>Total price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->invoice_number }}</td>
                    <td>
                        @if ($order->status == "SUBMIT")
                        <span class="badge bg-warning text-light">{{ $order->status }}</span>

                        @elseif($order->status == "PROCESS")
                        <span class="badge bg-info text-light">{{ $order->status }}</span>
                        @elseif($order->status == "FINISH")
                        <span class="badge bg-success text-light">{{ $order->status }}</span>
                        @elseif($order->status == "CANCEL")
                        <span class="badge bg-dark text-light">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $order->user->name }}
                        <br>
                        <small>{{ $order->user->email }}</small>
                    </td>
                    <td>{{ $order->totalQuantity }} pc (s)</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td><a href="{{ route('orders.edit',[$order->id]) }}" class="btn btn-primary">Edit</a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{ $orders->appends(Request::all())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection