@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-start mb-4">
        <h1 class="h3 mb-0 text-gray-800">Info about deployment</h1>
    </div>

    <div>
        <p>
            Shows information about the current state of the deployment. For each machine, it prints: <br>
            <ul>
                <li>The logical name of the machine.</li>
                <li>Its state, which is one of New (not deployed yet), Up (created and up to date), Outdated (created but not up to date with the current configuration) and Obsolete (created but no longer present in the configuration).</li>
                <li>The type of the machine.</li>
                <li>The machine identifier.</li>
                <li>The IP address of the machine.</li>
            </ul>
        </p>
    </div>

    @if(session()->has('message'))
        <div class="row justify-content-center text-bold">
            <div class="col-sm-8">
                <div class="alert {{session('alert') ?? 'alert-info'}}">
                    <strong> {{ session('message') }} </strong> <br>
                    <span class="font-monospace"> {{ session('output') }} </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif


    @can('seeinfo-deployment')
    <div class="row">
        <div class="col-lg-12 my-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">General info</h6>
                </div>

                <div class="card-body">
                    <strong>
                        <pre>{{$text_info}}</pre>
                    </strong>
                </div>

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Machine List</h6>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="d-flex">
                                <th class="col-2" scope="col">Name</th>
                                <th class="col-2" scope="col">Status</th>
                                <th class="col-2" scope="col">Type</th>
                                <th class="col-4" scope="col">ID</th>
                                <th class="col-2" scope="col">IP</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($table_rows as $machine)
                                <tr class="d-flex">
                                    <td class="col-2"> {{ $machine['name'] }} </td>
                                    <td class="col-2"> {{ $machine['status'] }} </td>
                                    <td class="col-2"> {{ $machine['type'] }} </td>
                                    <td class="col-4"> {{ $machine['resource_id'] }} </td>
                                    <td class="col-2"> {{ $machine['ip'] }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan

</div>
@endsection
