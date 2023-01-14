@extends('layouts.global')

@section('title')
List User
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
        @endif
        <form action="{{ route('users.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="keyword" class="form-control" value="{{ Request::get('keyword') }}"
                        placeholder="Filter berdasarkan Nama">
                </div>

                <div class="col-md-6">
                    <input {{ Request::get('status')=='ACTIVE' ? 'checked' : '' }} type="radio" value="ACTIVE"
                        name="status" class="form-control" id="active">
                    <label for="active">Active</label>
                    <input {{ Request::get('status')=='INACTIVE' ? 'checked' : '' }} type="radio" value="INACTIVE"
                        name="status" class="form-control" id="inactive">
                    <label for="inactive">Inactive</label>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>



        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('users.create') }}" class="btn btn-primary my-3">Create User</a>
            </div>
        </div>


        <table class="table shadow-sm">
            <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->avatar)
                        <img src="{{ asset('storage/'. $user->avatar) }}" width="70px">
                        @else
                        N/A
                        @endif
                    </td>
                    <td>
                        @if ($user->status == "ACTIVE")
                        <span class="badge badge-success p-2">{{ $user->status }}</span>
                        @else
                        <span class="badge badge-danger p-2">{{ $user->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.show', [$user->id]) }}" class="btn btn-primary">Detail</a>
                        <a href="{{ route('users.edit',[$user->id]) }}" class="btn btn-primary">Edit</a>

                        @if(Auth::user()->id != $user->id)
                        <form action="{{ route('users.destroy', [$user->id]) }}" method="post" class="d-inline"
                            onsubmit="return confirm('Delete this user Permanently?')">
                            @method('DELETE')
                            @csrf

                            <button type="submit" value="Delete" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{ $users->appends(Request::all())->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</ @endsection