@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection
@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{ isset($pageTitle) ? $pageTitle : 'Frontend Menu' }}</h2>
                        <div class="d-flex align-items-center">
                            <a href="{{route('menuCreate')}}" class="btn list-add-button px-3">{{__('Add New')}}</a>
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
                                    <th class="all">{{__('Menu Title')}}</th>
                                    <th class="desktop">{{__('Slug')}}</th>
                                    <th class="desktop">{{__('Component')}}</th>
                                    <th class="desktop">{{__('Status')}}</th>
                                    <th class="desktop">{{__('Order')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
                                    <th class="all">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody id="sortable"></tbody>
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
            ajax: '{{route('menuList')}}',
            order: [4, 'asc'],
            autoWidth:false,
            columns: [
                {"data": "title"},
                {"data": "slug"},
                {"data": "component"},
                {"data": "status"},
                {"data": "data_order", visible: false},
                {"data": "created_at"},
                {"data": "actions",orderable: false, searchable: false}
            ]
        });
    </script>
    <!-- <script src="{{asset('assets/customMenu/jquery-1.12.4.js')}}"></script> -->
    <script src="{{asset('assets/customMenu/jquery-ui.js')}}"></script>
    <script>
        $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        } );

        $( "#sortable" ).sortable({

            update: function( ) {
                var l_ar = [];
                $( ".shortable_data" ).each(function( index,data ) {
                    l_ar.push($(this).val());
                });

                $.get( "{{route('customMenuOrder')}}?vals="+l_ar, function( data ) {
                    $( ".result" ).html( data );
                    VanillaToasts.create({
                        //  title: 'Message Title',
                        text:data.message,
                        backgroundColor: "linear-gradient(135deg, #73a5ff, #5477f5)",
                        type: 'success',
                        timeout: 3000
                    });
                });
            }
        });

    </script>
@endsection