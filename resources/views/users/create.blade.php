@extends('layouts.global')

@section('title')
Create User
@endsection


@section('content')


<div class="row justify-content-center">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data"
            class="bg-white shadow-sm p-3">
            @csrf

            <div class="mt-3">
                <label for="name">Name : </label>
                <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name"
                    placeholder="Full Name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="username">Username : </label>
                <input type="text" name="username" class="form-control  @error('username') is-invalid @enderror"
                    id="username" placeholder="Username" value="{{ old('username') }}" required>
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <label>Roles : </label>
            <div>
                <input type="checkbox" name="roles[]" class="form-control" id="admin" value="ADMIN">
                <label for="admin">Admin</label>
                <input type="checkbox" name="roles[]" class="form-control" id="staff" value="STAFF">
                <label for="staff">Staff</label>
                <input type="checkbox" name="roles[]" class="form-control" id="customer" value="CUSTOMER">
                <label for="customer">Customer</label>
            </div>
            <div class="my-3">

                <label for="address">Address : </label>
                <textarea name="address" id="address" class="form-control  @error('address') is-invalid @enderror"
                    placeholder="Your Address">{{ old('address') }}</textarea>
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" class="form-control  @error('phone') is-invalid @enderror"
                    value="{{ old('phone') }}" required placeholder="Your Phone Number">
                @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="avatar">Avatar Image (Optional) : </label>
                <br>
                <input type="file" name="avatar" id="avatar" class="form-control" value="{{ old('avatar') }}">
            </div>

            <div class="my-3">
                <label for="email">Email : </label>
                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                    placeholder="user@mail.com" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="password">Password : </label>
                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                    placeholder="Password" name="password" id="password" placeholder="Password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="my-3">
                <label for="password_confirmation">Confirm Password : </label>
                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                    placeholder="Password Confirmation" name="password_confirmation" id="password_confirmation"
                    placeholder="Confirm Password">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection