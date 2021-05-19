@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> {{'Configuration file content'}} </h1>

        @can('edit-configfile')
        <a href="/configfiles/{{$configfile->id}}/edit" class="btn btn-info btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-edit"></i>
            </span>
            <span class="text">{{'Edit this file'}}</span>
        </a>
        @endcan
    </div>

    <div class="row">
        <!-- Config File Card -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body mt-5">

                    <div class="row justify-content-center">
                        <div class="col-lg-10 mb-4">

                            <div class="row mb-4">
                                <div class="col-sm-2 text-lg text-gray-999">
                                    {{'File name:'}}
                                </div>
                                <div class="col-sm-10 text-lg text-gray-800 font-monospace">
                                    {{$configfile->name}}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-2 text-lg text-gray-999">
                                    {{'Description:'}}
                                </div>
                                <div class="col-sm-10 text-lg text-gray-600">
                                    {{$configfile->description}}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-2 text-lg text-gray-999">
                                    {{'File contents:'}}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <pre class="prettyprint">{{$configfileContent}}</pre>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

