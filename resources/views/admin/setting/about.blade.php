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
    <div class="qz-content-area">
        <div class="card add-category">
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12" id="London">
                            {{ Form::open(['route' => 'adminAboutSettingsSave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Banner Title')}}</label>
                                        <input type="text" name="about_banner_title" value ="@if(isset($adm_setting['about_banner_title'])) {{ $adm_setting['about_banner_title'] }} @endif" class="form-control" placeholder="{{__('Banner Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Title')}}</label>
                                        <input type="text" name="about_title" value ="@if(isset($adm_setting['about_title'])) {{ $adm_setting['about_title'] }}@endif" class="form-control" placeholder="{{__('About Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Video Id')}}</label>
                                        <input type="text" name="about_video_id" value ="@if(isset($adm_setting['about_video_id'])) {{ $adm_setting['about_video_id'] }}@endif" class="form-control" placeholder="{{__('About Page Video Id')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature One Title')}}</label>
                                        <input type="text" name="about_section_title1" value ="@if(isset($adm_setting['about_section_title1'])) {{ $adm_setting['about_section_title1'] }} @endif" class="form-control" placeholder="{{__('Feature One Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature One Description')}}</label>
                                        <textarea name="about_section_des1" id="" rows="3" class="form-control">@if(isset($adm_setting['about_section_des1'])) {{ $adm_setting['about_section_des1'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature Two Title')}}</label>
                                        <input type="text" name="about_section_title2" value ="@if(isset($adm_setting['about_section_title2'])) {{ $adm_setting['about_section_title2'] }} @endif" class="form-control" placeholder="{{__('Feature Two Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature Two Description')}}</label>
                                        <textarea name="about_section_des2" id="" rows="3" class="form-control">@if(isset($adm_setting['about_section_des2'])) {{ $adm_setting['about_section_des2'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature Three Title')}}</label>
                                        <input type="text" name="about_section_title3" value ="@if(isset($adm_setting['about_section_title3'])) {{ $adm_setting['about_section_title3'] }} @endif" class="form-control" placeholder="{{__('Feature Three Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature Three Description')}}</label>
                                        <textarea name="about_section_des3" id="" rows="3" class="form-control">@if(isset($adm_setting['about_section_des3'])) {{ $adm_setting['about_section_des3'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature Four Title')}}</label>
                                        <input type="text" name="about_section_title4" value ="@if(isset($adm_setting['about_section_title4'])) {{ $adm_setting['about_section_title4'] }} @endif" class="form-control" placeholder="{{__('Feature Four Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Feature Four Description')}}</label>
                                        <textarea name="about_section_des4" id="" rows="3" class="form-control">@if(isset($adm_setting['about_section_des4'])) {{ $adm_setting['about_section_des4'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Sub Title')}}</label>
                                        <input type="text" name="about_sub_title" value ="@if(isset($adm_setting['about_sub_title'])) {{ $adm_setting['about_sub_title'] }}@endif" class="form-control" placeholder="{{__('About Sub Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Description')}}</label>
                                        <textarea name="about_description" id="" rows="3" class="form-control">@if(isset($adm_setting['about_description'])) {{ $adm_setting['about_description'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About 2nd Section Header Title')}}</label>
                                        <input type="text" name="about_last_section_header_title" value ="@if(isset($adm_setting['about_last_section_header_title'])) {{ $adm_setting['about_last_section_header_title'] }}@endif" class="form-control" placeholder="{{__('About 2nd Section Header Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About 2nd Section Title')}}</label>
                                        <input type="text" name="about_last_section_title" value ="@if(isset($adm_setting['about_last_section_title'])) {{ $adm_setting['about_last_section_title'] }}@endif" class="form-control" placeholder="{{__('About 2nd Section Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About 2nd Section Sub Title')}}</label>
                                        <input type="text" name="about_last_section_sub_title" value ="@if(isset($adm_setting['about_last_section_sub_title'])) {{ $adm_setting['about_last_section_sub_title'] }}@endif" class="form-control" placeholder="{{__('About 2nd Section Sub Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About 2nd Section Description')}}</label>
                                        <textarea name="about_last_description" id="" rows="3" class="form-control">@if(isset($adm_setting['about_last_description'])) {{ $adm_setting['about_last_description'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Feature Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="about_banner_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['about_banner_image']) && !empty($adm_setting['about_banner_image']) ? asset(path_image().$adm_setting['about_banner_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('about_banner_image') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Left Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="about_left_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['about_left_image']) && !empty($adm_setting['about_left_image']) ? asset(path_image().$adm_setting['about_left_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('about_left_image') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('About Section Two Right Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="about_right_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['about_right_image']) && !empty($adm_setting['about_right_image']) ? asset(path_image().$adm_setting['about_right_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('about_right_image') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn mt-4">{{__('Save Change')}}</button>
                                </div>
                            </div>
                            {{ Form::close() }}
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
    </script>
@endsection