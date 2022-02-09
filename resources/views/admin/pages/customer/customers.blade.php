@extends('admin.layouts.master')
@section('title')
    Customers
@endsection
@section('styles')
    <style>
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @if (Auth::guard('admin')->user()->type == 'ADMIN')
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Catalogue
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @include('admin.partials.message')

                    <div class="row">
                        <nav class="navbar navbar-light bg-light">
                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search"
                                    id="search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </nav>
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Customers</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Crated At</th>
                                            </tr>
                                        </thead>
                                        <tbody class="generalData">
                                            @if (count($customers))
                                                @foreach ($customers as $key => $emp)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $emp->name }}</td>
                                                        <td>{{ $emp->phone }}</td>
                                                        <td>{{ date('Y-m-d', strtotime($emp->created_at)) }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4">No data found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tbody id="data_records" class="ajaxData">

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->

                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        @else
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        {{-- @if (Auth::guard('admin')->user()->type == 'EMP') --}}
                        <a href="{{ url('admin/add-edit-customer/') }}" class="btn btn-success">Add
                            Customer</a> &nbsp;
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                            Upload CSV
                        </button>
                    </div>
                </div>
            </section>
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CSV Upload Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('csvUpload') }}" enctype="multipart/form-data" method="POST" accept=".csv">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv">Select CSV</label>
                            <input name="file" type="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
<!-- External javascript -->
@section('scripts')
    <script type="text/javascript">
        $("#search").on('keyup', function() {
            var value = $(this).val();
            //Show hide data table
            if (value) {
                $(".generalData").hide();
                $(".ajaxData").show();
            } else {
                $(".generalData").show();
                $(".ajaxData").hide();
            }
            $.ajax({
                url: "{{ url('admin/search') }}",
                method: 'GET',
                data: {
                    search: value
                },
                success: function(data) {
                    //console.log(data);
                    $('#data_records').html(data);
                }
            })
        });
        $('#quickForm').validate({
            rules: {
                name: {
                    required: true,
                    name: true,
                },
                mobile: {
                    required: true,
                    minlength: 11,
                    maxlength: 11,
                    digits: true,
                },
                email: {
                    required: true,
                    email: true,
                    remote: "check-email" // check-email is laravel  route
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
                    remote: "Email is already exist use email or login"
                },
                mobile: {
                    required: "Please enter a mobile no",
                    mobile: "Please enter a mobile no",
                    minlength: "Your mobile must consist of 10 digits",
                    maxlength: "Your mobile max consist of 10 digits",
                    digits: "Please enter your valid mobile",
                    //remote: "This is mobile no is already exist"

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
    </script>
@endsection
