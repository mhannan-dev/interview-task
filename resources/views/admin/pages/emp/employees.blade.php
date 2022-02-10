@extends('admin.layouts.master')
@section('title')
    All Employee
@endsection
@section('styles')
    <style>
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Application <a href="{{ url('admin/add-edit-employee/') }}" class="btn btn-success">Add New
                            Employee</a> </h1>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('sadmin/dashboard') }}">Home</a></li>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Employees</h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Crated At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($employees))
                                            @foreach ($employees as $key => $emp)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $emp->name }}</td>
                                                    <td>{{ $emp->phone }}</td>
                                                    <td>{{ $emp->email }}</td>
                                                    <td>{{ date('Y-m-d', strtotime($emp->created_at)) }}</td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">No data found</td>
                                            </tr>
                                        @endif
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
    </div>
@stop
<!-- External javascript -->
@section('scripts')

@endsection
