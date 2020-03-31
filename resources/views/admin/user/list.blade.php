@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection
@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{ isset($pageTitle) ? $pageTitle : 'Users' }}</h2>
                        <div class="d-flex align-items-center">
                            <a href="{{route('addUser')}}" class="btn btn-primary  list-add-button px-3">{{__('Add New')}}</a>
                            <span class="sidebarToggler ml-4">
                                <i class="fa fa-bars d-lg-none d-block"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->
    @include('layout.message')
    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <table id="table" class="table category-table table-bordered  text-center mb-0">
                                <thead>
                                <tr>
                                    <th class="teblet">{{__('Name')}}</th>
                                    <th class="desktop">{{__('Email')}}</th>
                                    <th class="desktop">{{__('Role')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
                                    <th class="teblet">{{__('Status')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
    <script>
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            responsive: true,
            ajax: '{{route('userList')}}',
            order: [3, 'desc'],
            autoWidth:false,
            columns: [
                {"data": "name"},
                {"data": "email"},
                {"data": "role"},
                {"data": "created_at"},
                {"data": "active_status"},
                {"data": "actions",orderable: false, searchable: false}
            ]
        });
    </script>
@endsection