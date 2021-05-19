@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users management</h1>

        <a href="/users/create" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text">Create new user</span>
        </a>
    </div>


    <div class="row">
        <!-- Users List Card -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Users List</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)

                                <tr>
                                    <td> {{ $user->id }} </td>
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->username }} </td>
                                    <td> {{ $user->role }} </td>

                                    @can('update-users', Model::class)
                                    <td>
                                        {{-- <a href="/users/{{$user->id}}/edit" class="btn btn-info btn-sm btn-icon-split mx-1">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </a>
                                        <a href="/users/{{$user->id}}" class="btn btn-danger btn-sm btn-icon-split mx-1">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Delete</span>
                                        </a> --}}

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <form method="POST" action="/users/{{$user->id}}/edit">
                                                    @csrf
                                                    @method('GET')

                                                    <div class="form-group">
                                                        {{-- <input type="submit" class="btn btn-info" value="Edit user"> --}}
                                                        <button type="submit" class="btn btn-info btn-icon"><i class="fas icon-gray fa-edit px-1" aria-hidden="true"></i><span class="text">Edit</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-sm-4">
                                                <form method="POST" action="/users/{{$user->id}}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="form-group">
                                                        {{-- <input type="submit" class="btn btn-danger" value="Delete user"> --}}
                                                        <button type="submit" class="btn btn-danger btn-icon"><i class="fas icon-gray fa-trash px-1" aria-hidden="true"></i><span class="text">Delete</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </td>
                                    @endcan

                                </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
