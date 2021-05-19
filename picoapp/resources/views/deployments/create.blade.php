@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create new deployment</h1>
    </div>

    <div>
        <p>
            {{'Minimal configuration of cluster deployment is already prepared. Add only configuration of services desired by you.'}}
        </p>
        <p>{{'It is an alternative to conmmand:'}}</p>
        <p class="text-monospace">
            {{'nixops create configfile.nix -d deploy_name'}}
        </p>
    </div>

    @if(session()->has('message'))
        <div class="row justify-content-center text-bold">
            <div class="col-sm-8">
                <div class="alert {{session('alert') ?? 'alert-info'}}">
                    <strong> {{ session('message') }} </strong> <br>
                    <span class="font-monospace"> {{ session('output') }} </span>
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-body mt-5">

                    <div class="row justify-content-center">
                        <div class="col-lg-6 mb-4">

                            <form method="POST" action="/deployments">

                                @csrf {{-- cross site request forgeries --}}

                                <div class="form-group row">
                                  <label for="name" class="col-sm-4 col-form-label-lg text-gray-999">{{'Deployment name:'}}</label>
                                  <div class="col-sm-8">
                                    <input
                                        type="text"
                                        class="form-control font-monospace @error('name') border-danger @enderror"
                                        name="name"
                                        id="name"
                                        placeholder="name of deployment"
                                        value="{{old('name')}}"
                                        required>
                                    @error('name')
                                        <p class="text-danger text-xs"> {{ $errors->first('name') }} </p>
                                    @enderror
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <label for="configFileName" class="col-sm-4 col-form-label-lg text-gray-999">{{'Deployment config file:'}}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control font-monospace" name="configFileName" id="configFileName" required>
                                            <option disabled="">Select configuration file..</option>
                                            @foreach ($files as $file)
                                                {{-- <option value="admin"> {{$file->name}} - {{implode(' ', array_slice(str_word_count($file->description, 2), 0, 5)) . '...'}} </option> --}}
                                                <option class="font-monospace" value="{{$file->name}}"> {{$file->name}}  </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                  <div class="col-sm-5">
                                    <button type="submit" class="btn mt-5 btn-block btn-success">{{'Create new deployment'}}</button>
                                  </div>
                                </div>

                            </form>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
