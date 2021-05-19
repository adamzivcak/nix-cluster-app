@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit configuration file</h1>
    </div>


    <div class="row">
        <!-- Users List Card -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">

                <div class="card-body mt-5">

                    <div class="row justify-content-center">
                        <div class="col-lg-10 mb-4">

                            <form method="POST" action="/configfiles/{{$configfile->id}}">
                                @csrf {{-- cross site request forgeries --}}
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label-lg text-gray-999">{{'Name:'}}</label>
                                    <div class="col-sm-10 ">
                                      <input
                                          type="text"
                                          class="form-control font-monospace @error('name') border-danger @enderror"
                                          name="name"
                                          id="name"
                                          placeholder="Name of configuration file."
                                          value="{{$configfile->name}}"
                                          readonly
                                          required>
                                      @error('name')
                                          <p class="text-danger text-xs"> {{ $errors->first('name') }} {{'You can edit an existing file, or select another unused name for file.'}}  </p>
                                      @enderror
                                    </div>
                                  </div>

                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label-lg text-gray-999">{{'Description:'}}</label>
                                    <div class="col-sm-10">
                                      <input
                                          type="text"
                                          class="form-control @error('description') border-danger @enderror"
                                          name="description"
                                          id="description"
                                          placeholder="Brief description of file content."
                                          value="{{$configfile->description}}"
                                          required>
                                      @error('description')
                                          <p class="text-danger text-xs"> {{ $errors->first('description') }} </p>
                                      @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="content" class="col-sm-2 col-form-label-lg text-gray-999">{{'File content:'}}</label>
                                    <div class="col-sm-10">
                                      <textarea
                                          type="textarea"
                                          rows="20"
                                          wrap="off"
                                          class="form-control code-editor-text @error('content') border-danger @enderror"
                                          name="content"
                                          mode="javascript"
                                          id="content"
                                          placeholder="Configuration of cluster written using Nix language."
                                          required>{{$configfileContent}}</textarea>
                                          @error('content')
                                              <p class="text-danger text-xs"> {{ $errors->first('content') }} </p>
                                          @enderror
                                    </div>
                                  </div>

                                <div class="form-group row justify-content-center">
                                  <div class="col-sm-5">
                                    <button type="submit" class="btn mt-5 btn-block btn-warning">{{'Update configuration file'}}</button>
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
