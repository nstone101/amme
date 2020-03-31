@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection
@section('main-body')
    <!-- Start page title -->
    <div class="qz-page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>@if (isset($pageTitle)) {{ $pageTitle }} @endif</h2>
                        <span class="sidebarToggler">
                            <i class="fa fa-bars d-lg-none d-block"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End page title -->
    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card qz-profile-area">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5">
                            <div class="qz-profile-card text-center">
                                <div class="qz-edit-icon">
                                    <a href="{{ route('editUser', encrypt($user->id)) }}">
                                        <img src="{{ asset('assets/images/edit.png') }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="qz-profile-user-avater">
                                    <img @if(isset($user->photo)) src="{{ asset(path_user_image().$user->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid">
                                </div>
                                <div class="qz-user-info">
                                    <h4> $user->name }}</h4>
                                    <p>{!! clean($user->email) !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7">
                            <ul class="user-details-info mt-md-0 mt-4">
                                <li>
                                    <div class="row ">
                                        <div class="col-4">{{__('Name')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col">{!! clean($user->name) !!}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-4">{{__('Phone')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col">{!! clean($user->phone) !!}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-4">{{__('Country')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col">{{isset($user->country) ? country($user->country) : ''}}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-4">{{__('City')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col">{!! clean($user->city) !!}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-4">{{__('State')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col">{!! clean($user->state) !!}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-4">{{__('Zip')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col">{!! clean($user->zip) !!}</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-4">{{__('Full Address')}}</div>
                                        <div class="col-1">:</div>
                                        <div class="col-md-7 col-6">{!! clean($user->address) !!}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End content area  -->
@endsection

@section('script')
@endsection