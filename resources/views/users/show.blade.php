@extends('layouts.global')

@section('title')
Detail User
@endsection

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="jumbotron text-center">
            <h1 class="display-4 fw-bold mb-3">Hello, {{ $user->name }}</h1>
            <div class="mb-3 fs-2">
                @foreach (json_decode($user->roles) as $role)
                <span>Your roles : {{ $role }}</span>
                @endforeach
            </div>
            @if($user->avatar)
            <img src="{{asset('storage/'. $user->avatar)}}" class="img-fluid img-thumbnail w-50" /
                style="border-radius: 2rem">
            @else
            No avatar
            @endif
            <hr class="my-4">
            <div class="fs-2">
                <b>Username : </b>
                <span>{{ $user->username }}</span>
            </div>
            <div class="fs-2">
                <b>Phone : </b>
                <span>{{ $user->phone }}</span>
            </div>

            <div class="fs-2">
                <b>Address : </b>
                <span>{{ $user->address }}</span>
            </div>


        </div>
    </div>
</div>
@endsection