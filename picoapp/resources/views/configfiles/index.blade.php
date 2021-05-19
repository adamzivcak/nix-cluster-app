@extends('layouts.app')

@section('content')
<div class="container-fluid">


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Configuration files management</h1>

        <a href="/configfiles/create" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text">Create new configuration file</span>
        </a>
    </div>

    @if(session()->has('message'))
        <div class="row justify-content-center text-bold">
            <div class="col-sm-8">
                <div class="alert {{session('alert') ?? 'alert-info'}}">
                    <strong>
                        {{ session('message') }}
                    </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Config files List Card -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Configuration Files List</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="d-flex">
                                <th class="col-2" scope="col">Name</th>
                                <th class="col-7 scope="col">Description</th>
                                <th class="col-1 scope="col"></th>
                                <th class="col-1 scope="col"></th>
                                <th class="col-1 scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($files as $file)

                                <tr class="d-flex">

                                    @can('view-configfiles')

                                        <td class="col-2"> {{ $file->name }} </td>

                                        <td class="col-7"> {{ $file->description }} </td>

                                        <td class="col-1">
                                            <form method="POST" action="/configfiles/{{$file->id}}/show">
                                                @csrf
                                                @method('GET')

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-warning btn-icon"><i class="fas icon-gray fa-eye px-1" aria-hidden="true"></i><span class="text">View</span></button>
                                                </div>
                                            </form>
                                        </td>
                                    @endcan

                                    @can('update-configfiles')

                                        <td class="col-1">
                                            <form method="POST" action="/configfiles/{{$file->id}}/edit">
                                                @csrf
                                                @method('GET')

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info btn-icon"><i class="fas icon-gray fa-edit px-1" aria-hidden="true"></i><span class="text">Edit</span></button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="col-1">
                                            <form method="POST" action="/configfiles/{{$file->id}}">
                                                @csrf
                                                @method('DELETE')

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-icon"><i class="fas icon-gray fa-trash px-1" aria-hidden="true"></i><span class="text">Delete</span></button>
                                                </div>
                                            </form>
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
