@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create new user</h1>
    </div>


    <div class="row">
        <!-- Users List Card -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                {{-- <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Users List</h6>
                </div> --}}
                <div class="card-body mt-5">

                    <div class="row justify-content-center">
                        <div class="col-lg-4 mb-4">

                            <form method="POST" action="/users"
                                oninput='password2.setCustomValidity(password2.value != password.value ? "Passwords do not match." : "")'>

                                @csrf {{-- cross site request forgeries --}}

                                <div class="form-group row">
                                  <label for="name" class="col-sm-4 col-form-label-lg text-gray-999">Name:</label>
                                  <div class="col-sm-8">
                                    <input
                                        type="text"
                                        class="form-control @error('name') border-danger @enderror"
                                        name="name"
                                        id="name"
                                        placeholder="name"
                                        value="{{old('name')}}"
                                        required>
                                    @error('name')
                                        <p class="text-danger text-xs"> {{ $errors->first('name') }} </p>
                                    @enderror
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="username" class="col-sm-4 col-form-label-lg text-gray-999">Username:</label>
                                  <div class="col-sm-8">
                                    <input
                                        type="text"
                                        class="form-control @error('username') border-danger @enderror"
                                        name="username"
                                        id="username"
                                        placeholder="username"
                                        value="{{old('username')}}"
                                        required>
                                    @error('username')
                                        <p class="text-danger text-xs"> {{ $errors->first('username') }} </p>
                                    @enderror
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="password" class="col-sm-4 col-form-label-lg text-gray-999">Password:</label>
                                  <div class="col-sm-8">
                                    <input
                                        type="password"
                                        class="form-control @error('password') border-danger @enderror"
                                        name="password"
                                        id="password"
                                        placeholder="password"
                                        required>
                                    @error('password')
                                        <p class="text-danger text-xs"> {{ $errors->first('password') }} </p>
                                    @enderror
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="password2" class="col-sm-4 col-form-label-lg text-gray-999">Confirm password:</label>
                                  <div class="col-sm-8">
                                    <input
                                        type="password"
                                        class="form-control @error('password2') border-danger @enderror"
                                        name="password2"
                                        id="password2"
                                        placeholder="confirm password"
                                        required>
                                    @error('password2')
                                        <p class="text-danger text-xs"> {{ $errors->first('password2') }} </p>
                                    @enderror
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="role" class="col-form-label-lg col-sm-4 text-gray-999">Role:</label>
                                  <div class="col-sm-8">
                                    <select class="form-control" name="role" id="role" required>
                                      <option disabled>select user role..</option>
                                      <option value="admin">Administrator</option>
                                      <option value="monitor">Monitoring</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                  <div class="col-sm-5">
                                    <button type="submit" class="btn mt-5 btn-block btn-success">Create new user</button>
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
