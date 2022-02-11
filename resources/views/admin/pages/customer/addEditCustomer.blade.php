@extends('admin.layouts.master')
@section('title')
    Customer Form
@endsection
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
                @include('admin.partials.message')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="quickForm" action="{{ url('admin/add-edit-customer', $customer->id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="brand">Customer name</label><span class="text-danger">*</span>
                                            <input type="text" @if (!empty($customer['name']))
                                            value="{{ $customer['name'] }}"
                                        @else
                                            value="{{ old('name') }}"
                                            @endif name="name"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name" placeholder="Customer name">
                                            @if ($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="Phone">Phone</label><span class="text-danger">*</span>
                                            <input type="text" name="phone"
                                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                                id="phone" placeholder="Enter Valid phone" value="{{ old('phone') }}">
                                            @if ($errors->has('phone'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="email">Email</label><span class="text-danger">*</span>

                                            <input type="email" name="email"
                                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                id="email" placeholder="Enter Valid Email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="password">Password</label><span class="text-danger">*</span>
                                            <input type="password" @if (!empty($customer['password']))
                                            value="{{ $customer['password'] }}"
                                        @else
                                            value="{{ old('password') }}"
                                            @endif name="password"
                                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                            id="password" placeholder="customer password">
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

@section('scripts')
    <script>
        $(function() {
            $('#quickForm').validate({
                rules: {
                    name: {
                        required: true,
                        name: true,
                    },
                    phone: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        digits: true,
                        remote: "check-phone"
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: "check-customer-email"
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                },
                messages: {
                    name: {
                        required: "Please enter full name",
                        name: "Please enter full name"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a email address",
                        remote: "Email is already exist use another"
                    },
                    phone: {
                        required: "Please enter a mobile no",
                        mobile: "Please enter a mobile no",
                        minlength: "Your mobile must consist of 10 digits",
                        maxlength: "Your mobile max consist of 10 digits",
                        digits: "Please enter your valid mobile",
                        remote: "This is phone no is already exist"

                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
