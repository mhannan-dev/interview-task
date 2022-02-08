@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ url('admin/add-edit-employee', $employee->id) }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="brand">Employee name</label><span class="text-danger">*</span>
                                            <input type="text" @if (!empty($employee['name']))
                                            value="{{ $employee['name'] }}"
                                        @else
                                            value="{{ old('name') }}"
                                            @endif name="name"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" placeholder="Employee name">
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="Phone">Phone</label><span class="text-danger">*</span>
                                            <input type="text" @if (!empty($employee['phone']))
                                            value="{{ $employee['phone'] }}"
                                        @else
                                            value="{{ old('phone') }}"
                                            @endif name="phone"
                                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                            id="name" placeholder="Employee name">
                                            @if ($errors->has('phone'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="email">Email</label><span class="text-danger">*</span>
                                            <input type="text" @if (!empty($employee['email']))
                                            value="{{ $employee['email'] }}"
                                        @else
                                            value="{{ old('email') }}"
                                            @endif name="email"
                                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                            id="email" placeholder="Employee email">
                                            @if ($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="password">Password</label><span class="text-danger">*</span>
                                            <input type="text" @if (!empty($employee['password']))
                                            value="{{ $employee['password'] }}"
                                        @else
                                            value="{{ old('password') }}"
                                            @endif name="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            id="password" placeholder="Employee password">
                                            @if ($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
