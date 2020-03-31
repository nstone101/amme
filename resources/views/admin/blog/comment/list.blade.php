@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection
@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h2>{{ isset($pageTitle) ? $pageTitle : '' }}</h2>
                        <div class="d-flex align-items-center">
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
                                    <th class="all">{{__('Post Title')}}</th>
                                    <th class="all">{{__('Comment')}}</th>
                                    <th class="all">{{__('Author')}}</th>
                                    <th class="desktop">{{__('Status')}}</th>
                                    <th class="desktop">{{__('Added On')}}</th>
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
            ajax: '{{route('commentList', encrypt($id))}}',
            order: [4, 'desc'],
            autoWidth:false,
            columns: [
                {"data": "post"},
                {"data": "comment"},
                {"data": "name"},
                {"data": "status"},
                {"data": "created_at"},
                {"data": "actions",orderable: false, searchable: false}
            ]
        });
    </script>
    <script>
        function processForm(active_id) {
            $.ajax({
                type: "GET",
                url: "{{ route('commentApprove') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'active_id': active_id
                },
                success: function (data) {
                }
            });
        }
    </script>
@endsection