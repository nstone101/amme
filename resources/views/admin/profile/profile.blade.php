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
    @include('layout.message')
    <!-- Start content area  -->
    <div class="qz-content-area">
        <div class="card qz-profile-area">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-5">
                            <div class="qz-profile-card text-center">
                                <div class="qz-profile-user-avater">
                                    <img @if(isset($user->photo)) src="{{ asset(path_user_image().$user->photo)}}" @else src="{{asset('assets/images/avater.jpg')}}" @endif alt="" class="img-fluid">
                                </div>
                                <div class="qz-user-info">
                                    <h4>{!! clean($user->name) !!}</h4>
                                    <p>{!! clean($user->email) !!}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <div class="qz-user-profile-from">
                                {{ Form::open(['route' => 'updateProfile', 'files' => 'true']) }}
                                    <div class="form-group">
                                        <label>{{__('Name')}}</label>
                                        <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Phone')}}</label>
                                        <input type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('phone') }}</strong></span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Country')}}</label>
                                        <div class="qz-question-category">
                                            <select name="country" class="form-control">
                                                <option value="">{{__('Select Country')}}</option>
                                                @foreach(country() as $key => $value)
                                                    <option @if(isset($user) && ($user->country == $key)) selected @elseif((old('country') != null)
                                                     && (old('country') == $key)) selected @endif value="{{ $key }}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('country') }}</strong></span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('City')}}</label>
                                        <input type="text" name="city" value="{{$user->city}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('State')}}</label>
                                        <input type="text" name="state" value="{{$user->state}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('zip')}}</label>
                                        <input type="text" name="zip" value="{{$user->zip}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Full Address')}}</label>
                                        <input type="text" name="address" value="{{$user->address}}" class="form-control" placeholder="">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>{{__('Image')}}</label>
                                                <div id="file-upload" class="section">
                                                    <!--Default version-->
                                                    <div class="row section">
                                                        <div class="col s12 m12 l12">
                                                            <input name="photo" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($user) && !empty($user->photo) ? asset(path_user_image().$user->photo) : ''}}" />
                                                            <span class="text-danger"><strong>{{ $errors->first('photo') }}</strong></span>
                                                        </div>
                                                    </div>
                                                    <!--Default value-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block add-category-btn"> {{__('Update')}} </button>
                                            </div>
                                        </div>
                                    </div>

                                {{ Form::close() }}
                            </div>
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