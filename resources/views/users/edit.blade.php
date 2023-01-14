@extends('layouts.global')

@section('title')
Edit User
@endsection

@section('content')

@if(session('status'))
<div class="alert alert-success">
    {{session('status')}}
</div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8 ">
        <form action="{{ route('users.update',[$user->id]) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="mt-3">
                <label for="name">Name : </label>
                <input type="text" name="name" class="form-control rounded  @error('name') is-invalid @enderror"
                    id="name" placeholder="Full Name" value="{{ old('name',$user->name) }}" required>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="username">Username : </label>
                <input type="text" name="username"
                    class="form-control disabled  @error('username') is-invalid @enderror" id="username"
                    placeholder="Username" value="{{ old('username',$user->username) }}" required readonly>
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <label for="status">Status : </label>
            <div>
                <input {{$user->status == "ACTIVE" ? "checked" : ""}}
                value="ACTIVE" type="radio"
                class="form-control"
                id="active"
                name="status">
                <label for="active">Active</label>
                <input {{$user->status == "INACTIVE" ? "checked" : ""}}
                value="INACTIVE"
                type="radio"
                class="form-control"
                id="inactive"
                name="status">
                <label for="inactive">Inactive</label>
            </div>

            <label>Roles : </label>
            <div>
                <input {{ in_array("ADMIN", json_decode($user->roles)) ? "checked" : "" }} type="checkbox"
                name="roles[]"
                class="form-control"
                id="admin" value="ADMIN">
                <label for="admin">Admin</label>
                <input {{ in_array("STAFF", json_decode($user->roles)) ? "checked" : "" }} type="checkbox"
                name="roles[]"
                class="form-control" id="staff" value="STAFF">
                <label for="staff">Staff</label>
                <input {{ in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : "" }} type="checkbox"
                name="roles[]"
                class="form-control" id="customer" value="CUSTOMER">
                <label for="customer">Customer</label>
            </div>
            <div class="my-3">

                <label for="address">Address : </label>
                <textarea name="address" id="address"
                    class="form-control  @error('address') is-invalid @enderror">{{ old('address',$user->address) }}</textarea>
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" class="form-control  @error('phone') is-invalid @enderror"
                    value="{{ old('phone',$user->phone) }}" required>
                @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="avatar">Current Avatar : </label>
                <br>
                @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" width="120px" class="my-3">
                @else
                No Avatar
                @endif
                <br>
                <input type="file" class="form-control" name="avatar" id="avatar" value="{{ old('avatar') }}">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
            </div>

            <div class="my-3">
                <label for="email">Email : </label>
                <input type="email" class="form-control disabled  @error('email') is-invalid @enderror"
                    placeholder="user@mail.com" name="email" id="email" value="{{ old('email',$user->email) }}" required
                    readonly>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection