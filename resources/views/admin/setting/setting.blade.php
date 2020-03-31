@extends('layout.master')
@section('title') @if (isset($pageTitle)) {{ $pageTitle }} @endif @endsection

@section('main-body')
    <link type="text/css" rel="stylesheet" href="{{asset('assets/colorPicker/css/wheelcolorpicker.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/colorPicker/css/wheelcolorpicker.dark.css')}}" />
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
                        <div class="col-md-12 v-tab">
                            <div class="tab">
                                <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">{{__('General')}}</button>
                                <button class="tablinks" onclick="openCity(event, 'Paris')">{{__('Logo')}} </button>
                                <button class="tablinks" onclick="openCity(event, 'Privacy')">{{__('Privacy Policy')}}</button>
                            </div>

                        </div>
                        <div class="col-lg-12 tabcontent mt-5" id="London">
                            {{ Form::open(['route' => 'saveSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('App Title')}}</label>
                                        <input type="text" name="app_title" value ="@if(isset($adm_setting['app_title'])) {{ $adm_setting['app_title'] }} @endif" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('app_title') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Contact Number')}}</label>
                                        <input type="text" name="contact_number" value ="@if(isset($adm_setting['contact_number'])) {{ $adm_setting['contact_number'] }}@endif" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('contact_number') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Primary Email')}}</label>
                                        <input type="text" name="primary_email" value ="@if(isset($adm_setting['primary_email'])) {{ $adm_setting['primary_email'] }} @endif" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('primary_email') }}</strong></span>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Login Text')}}</label>
                                        <input type="text" name="login_text" value ="@if(isset($adm_setting['login_text'])) {{ $adm_setting['login_text'] }} @endif" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Sign Up Text')}}</label>
                                        <input type="text" name="signup_text" value ="@if(isset($adm_setting['signup_text'])) {{ $adm_setting['signup_text'] }} @endif" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Copyright Text')}}</label>
                                        <input type="text" name="copyright_text" value ="@if(isset($adm_setting['copyright_text'])) {{ $adm_setting['copyright_text'] }} @endif" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('copyright_text') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Address')}}</label>
                                        <input type="text" name="address" value ="@if(isset($adm_setting['address'])) {{ $adm_setting['address'] }} @endif" class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('address') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group {{ $errors->has('lang') ? ' has-error' : '' }}">
                                        <label>{{__('Language')}}<span class="text-danger"></span></label>
                                        <div class="qz-question-category">
                                            <select name="lang" class="form-control">
                                                @foreach(language() as $val)
                                                    <option @if(isset($adm_setting['lang']) && $adm_setting['lang']==$val) selected @endif value="{{$val}}">{{langName($val)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('lang') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Front End Base Color')}}</label>
                                        <input type="text" name="front_base_color" value ="@if(isset($adm_setting['front_base_color'])) {{ $adm_setting['front_base_color'] }} @endif"
                                               class="form-control" id="colorpicker" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('front_base_color') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Google capcha site key')}}</label>
                                        <input type="text" name="google_capcha_site_key" value ="@if(isset($adm_setting['google_capcha_site_key'])) {{ $adm_setting['google_capcha_site_key'] }} @endif"
                                               class="form-control" placeholder="">
                                        <span class="text-danger"><strong>{{ $errors->first('google_capcha_site_key') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn mt-4">{{__('Save Change')}}</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div class="col-lg-12 tabcontent mt-5" id="Paris">
                            {{ Form::open(['route' => 'adminImageUploadSave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>{{__('Company logo')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="logo" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['logo']) && !empty($adm_setting['logo']) ? asset(path_image().$adm_setting['logo']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 offset-1">
                                    <div class="form-group">
                                        <label>{{__('Login logo')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="login_logo" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['login_logo']) && !empty($adm_setting['login_logo']) ? asset(path_image().$adm_setting['login_logo']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 offset-1">
                                    <div class="form-group">
                                        <label>{{__('Fevicon')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="favicon" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['favicon']) && !empty($adm_setting['favicon']) ? asset(path_image().$adm_setting['favicon']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn mt-4">{{__('Save Change')}}</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div class="col-lg-12 tabcontent mt-5" id="Privacy">
                            {{ Form::open(['route' => 'adminImageUploadSave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Privacy and Policy')}}</label>
                                        <textarea id="btEditor" name="privacy_policy">@if(isset($adm_setting['privacy_policy'])){{$adm_setting['privacy_policy']}}@else{{old('privacy_policy')}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Terms and Conditions')}}</label>
                                        <textarea id="btEditor2" name="terms_conditions">@if(isset($adm_setting['terms_conditions'])) {{$adm_setting['terms_conditions']}} @else {{old('terms_conditions')}} @endif</textarea>
                                    </div>
                                </div>
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
    <script src="{{asset('assets/colorPicker/jquery.wheelcolorpicker.js')}}"></script>
    <script src="{{asset('assets/colorPicker/jquery.wheelcolorpicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            // $('#color-inline1').wheelColorPicker();
            $('#colorpicker').wheelColorPicker({ sliders: "whsvp", preview: true, format: "css" });
        //     $('#color-inline3').wheelColorPicker({ live: false, sliders: "wrgbap", format: "rgba" });
        //     $('#color-block').wheelColorPicker({ layout: 'block', sliders: "whsvrgbap" });
        });
    </script>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
@endsection