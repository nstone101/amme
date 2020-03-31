@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection
@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>{{ isset($pageTitle) ? $pageTitle : '' }}</h2>
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->
    @include('layout.message')
    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card add-category">
            <div class="card-body">
                <div class="container-fluid">
                    @if(isset($item))
                        <div class="row">
                            <div class="col-md-2">
                                <b>{{__("Post Title")}}</b>
                            </div>
                            <div class="col-md-1">
                                <b> :</b>
                            </div>
                            <div class="col-md-9">
                                {!! clean($item->blog->title) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <b>{{__("Comments")}}</b>
                            </div>
                            <div class="col-md-1">
                                <b> :</b>
                            </div>
                            <div class="col-md-9">
                                {!! clean($item->comment) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <b>{{__("Author Name")}}</b>
                            </div>
                            <div class="col-md-1">
                                <b> :</b>
                            </div>
                            <div class="col-md-9">
                                {!! clean($item->name) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <b>{{__("Author Email")}}</b>
                            </div>
                            <div class="col-md-1">
                                <b> :</b>
                            </div>
                            <div class="col-md-9">
                                {!! clean($item->email) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <b>{{__("Status")}}</b>
                            </div>
                            <div class="col-md-1">
                                <b> :</b>
                            </div>
                            <div class="col-md-9">
                                {!! clean(comment_status($item->status)) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <b>{{__("Date")}}</b>
                            </div>
                            <div class="col-md-1">
                                <b> :</b>
                            </div>
                            <div class="col-md-9">
                                {!! clean(date('d M y', strtotime($item->created_at))) !!}
                            </div>
                        </div>
                        @if($item->status == COMMENT_PENDING)
                            <div class="row mt-5">
                                <div class="col-md-1">
                                    <a href="{{route('commentApprove')}}?active_id={{$item->id}}">
                                        <button class="btn btn-success">{{__('Approve')}}</button>
                                    </a>
                                </div>
                            </div>
                         @else
                            <div class="row mt-5">
                                <div class="col-md-1">
                                    <a href="{{route('commentApprove')}}?active_id={{$item->id}}">
                                        <button class="btn btn-danger">{{__('Reject')}}</button>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @else
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-danger text-center">{{__('No data found')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
@endsection