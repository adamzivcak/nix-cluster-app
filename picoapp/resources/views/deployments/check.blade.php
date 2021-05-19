@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-start mb-4">
        <h1 class="h3 mb-0 text-gray-800">Check deployment</h1>
    </div>

    <div>
        <p>
            Checks and prints the status of each machine in the deployment. <br>
            For instance, for an EC2 machine, it will ask EC2 whether the machine is running or stopped. <br>
            If a machine is supposed to be up, NixOps will try to connect to the machine via SSH and get the current load average statistics.
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
                    <h6 class="m-0 font-weight-bold text-secondary">Machine List</h6>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="d-flex">
                                <th class="col-1" scope="col">Name</th>
                                <th class="col-1" scope="col">Exists</th>
                                <th class="col-1" scope="col">Reachable</th>
                                <th class="col-1" scope="col">Up</th>
                                <th class="col-1" scope="col">Disks OK</th>
                                <th class="col-2" scope="col">Avg. Load</th>
                                <th class="col-3" scope="col">Units</th>
                                <th class="col-1" scope="col">Notes</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($table_rows as $machine)
                                <tr class="d-flex">
                                    <td class="col-1"> {{ $machine['name'] }} </td>
                                    <td class="col-1"> {{ $machine['exists'] }} </td>
                                    <td class="col-1"> {{ $machine['reachable'] }} </td>
                                    <td class="col-1"> {{ $machine['up'] }} </td>
                                    <td class="col-1"> {{ $machine['disks'] }} </td>
                                    <td class="col-2"> {{ $machine['load'] }} </td>
                                    <td class="col-3"> {{ $machine['units'] }} </td>
                                    <td class="col-1"> {{ $machine['notes'] }} </td>
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
