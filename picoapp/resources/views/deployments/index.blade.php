
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Deployments management</h1>

        <a href="/deployments/create" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus-circle"></i>
            </span>
            <span class="text">Create new deployment</span>
        </a>
    </div>

    @if(session()->has('message'))
        <div class="row justify-content-center text-bold">
            <div class="col-sm-10">
                <div class="alert {{session('alert') ?? 'alert-info'}}  alert-dismissible fade show">
                    <strong>{{ session('message') }}</strong><br>
                    @if(session()->has('output'))
                        <pre><span class="font-monospace"> {{ session('output') }} </span></pre>
                        <span class="font-monospace"> {{ session('result_code') }} </span>
                    @endif
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('pid'))
    <div class="my-4">
        <div class="alert alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">Deployment status:</h5>
            <div class="row">
                <div class="col-12">
                    <textarea readonly id="deployLog" type="textarea" rows="10" class="form-control code-editor-text" wrap="off"></textarea>
                </div>
            </div>
            <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true" class="text-danger" >&times;</span>
            </button>
        </div>
    </div>

    <script>
        setInterval(function() {
            var $log = $('#deployLog');
            $log.load('output.txt');
            $log.scrollTop($log[0].scrollHeight);
        }, 1000);
    </script>
    @endif


    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Deployments List</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="d-flex">
                                <th class="col-2" scope="col">Name</th>
                                <th class="col-4" scope="col">Description</th>
                                <th class="col-1" scope="col"># Machines</th>
                                <th class="col-5" scope="col">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($deployments_new as $deployment)

                                <tr class="d-flex">

                                    @can('view-deployments')
                                        <td class="col-2"> {{ $deployment['name'] }} </td>

                                        <td class="col-4"> {{ $deployment['description'] }} </td>

                                        <td class="col-1"> {{ $deployment['numof'] }} </td>
                                    @endcan

                                    @can('seeinfo-deployment')
                                        <td class="col-1">
                                            <form method="POST" action="/deployments/{{$deployment['uuid']}}/info">
                                                @csrf
                                                @method('GET')

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info btn-icon"><i class="fas icon-gray fa-info-circle px-1" aria-hidden="true"></i><span class="text">{{'Info'}}</span></button>
                                                </div>
                                            </form>
                                        </td>
                                    @endcan

                                    @can('check-deployment')
                                        <td class="col-1">
                                            <form method="POST" action="/deployments/{{$deployment['uuid']}}/check">
                                                @csrf
                                                @method('GET')

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-warning btn-icon"><i class="fas icon-gray fa-eye px-1" aria-hidden="true"></i><span class="text">{{'Check'}}</span></button>
                                                </div>
                                            </form>
                                        </td>
                                    @endcan

                                    @can('deploy-deployment')
                                        <td class="col-1">
                                            <form method="POST" action="/deployments/{{$deployment['uuid']}}/deploy">
                                                @csrf
                                                {{-- @method('GET') --}}

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success btn-icon"><i class="fas icon-gray fa-rocket px-1" aria-hidden="true"></i><span class="text">{{'Deploy'}}</span></button>
                                                </div>
                                            </form>
                                        </td>
                                    @endcan

                                    @can('destroy-deployment')
                                        <td class="col-1">
                                            <form method="POST" action="/deployments/{{$deployment['uuid']}}/destroy">
                                                @csrf
                                                {{-- @method('GET') --}}

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-icon"><i class="fas icon-gray fa-times px-1" aria-hidden="true"></i><span class="text">{{'Destroy'}}</span></button>
                                                </div>
                                            </form>
                                        </td>
                                    @endcan

                                    @can('delete-deployment')
                                        <td class="col-1">
                                            <form method="POST" action="/deployments/{{$deployment['uuid']}}/delete">
                                                @csrf
                                                {{-- @method('DELETE') --}}

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-icon"><i class="fas icon-gray fa-trash px-1" aria-hidden="true"></i><span class="text">{{'Delete'}}</span></button>
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
