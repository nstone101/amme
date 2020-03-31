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
                        <div class="col-md-12 v-tab">
                            <div class="tab">
                                <button class="tablinks" onclick="openCity(event, 'Home')" id="defaultOpen">{{__('Home Page')}}</button>
                                <button class="tablinks" onclick="openCity(event, 'Service')">{{__('Service')}} </button>
                                <button class="tablinks" onclick="openCity(event, 'Team')">{{__('Team')}}</button>
                                <button class="tablinks" onclick="openCity(event, 'Portfolio')">{{__('Portfolio')}}</button>
                                <button class="tablinks" onclick="openCity(event, 'Gallery')">{{__('Gallery')}}</button>
                                <button class="tablinks" onclick="openCity(event, 'Achievement')">{{__('Achievement')}}</button>
                                <button class="tablinks" onclick="openCity(event, 'Work')">{{__('Work Inquiry')}}</button>
                            </div>
                        </div>
                        <div class="col-lg-12 tabcontent mt-4" id="Home">
                            {{ Form::open(['route' => 'saveWebSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Banner Title')}}</label>
                                        <input type="text" name="home_banner_title" value ="@if(isset($adm_setting['home_banner_title'])) {{ $adm_setting['home_banner_title'] }} @endif" class="form-control" placeholder="{{__('Home Page Banner Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Sub Title')}}</label>
                                        <input type="text" name="home_banner_sub_title" value ="@if(isset($adm_setting['home_banner_sub_title'])) {{ $adm_setting['home_banner_sub_title'] }} @endif" class="form-control" placeholder="{{__('Home Page Banner sub title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Second Section Title')}}</label>
                                        <input type="text" name="home_section_title2" value ="@if(isset($adm_setting['home_section_title2'])) {{ $adm_setting['home_section_title2'] }}@endif" class="form-control" placeholder="{{__('Home Page Second Section Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Testimonial Title')}}</label>
                                        <input type="text" name="home_testimonial_title" value ="@if(isset($adm_setting['home_testimonial_title'])) {{ $adm_setting['home_testimonial_title'] }}@endif" class="form-control" placeholder="{{__('Home Page Testimonial Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Blog Section Title')}}</label>
                                        <input type="text" name="home_blog_title" value ="@if(isset($adm_setting['home_blog_title'])) {{ $adm_setting['home_blog_title'] }}@endif" class="form-control" placeholder="{{__('Home Page Blog Title')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Description')}}</label>
                                        <textarea name="home_banner_des" id="" rows="5" placeholder="{{__('Home page banner description')}}" class="form-control">@if(isset($adm_setting['home_banner_des'])) {{ $adm_setting['home_banner_des'] }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Second Section Description')}}</label>
                                        <textarea name="home_section_des2" id="" rows="5" placeholder="{{__('Home page second section description')}}" class="form-control">@if(isset($adm_setting['home_section_des2'])) {{ $adm_setting['home_section_des2'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="home_banner_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['home_banner_image']) && !empty($adm_setting['home_banner_image']) ? asset(path_image().$adm_setting['home_banner_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('home_banner_image') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Second Section Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="home_second_section_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['home_second_section_image']) && !empty($adm_setting['home_second_section_image']) ? asset(path_image().$adm_setting['home_second_section_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('home_second_section_image') }}</strong></span>
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
                        <div class="col-lg-12 tabcontent mt-4" id="Service">
                            {{ Form::open(['route' => 'saveWebSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Banner Title')}}</label>
                                        <input type="text" name="service_banner_title" value ="@if(isset($adm_setting['service_banner_title'])) {{ $adm_setting['service_banner_title'] }} @endif" class="form-control" placeholder="{{__('Service Page Banner Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Description')}}</label>
                                        <textarea name="service_banner_des" id="" rows="8" placeholder="{{__('Service page banner description')}}" class="form-control">@if(isset($adm_setting['service_banner_des'])) {{ $adm_setting['service_banner_des'] }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="service_banner_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['service_banner_image']) && !empty($adm_setting['service_banner_image']) ? asset(path_image().$adm_setting['service_banner_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('service_banner_image') }}</strong></span>
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
                        <div class="col-lg-12 tabcontent mt-4" id="Team">
                            {{ Form::open(['route' => 'saveWebSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Banner Title')}}</label>
                                        <input type="text" name="team_banner_title" value ="@if(isset($adm_setting['team_banner_title'])) {{ $adm_setting['team_banner_title'] }} @endif" class="form-control" placeholder="{{__('Team Page Banner Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Description')}}</label>
                                        <textarea name="team_banner_des" id="" rows="8" placeholder="{{__('Team page banner description')}}" class="form-control">@if(isset($adm_setting['team_banner_des'])) {{ $adm_setting['team_banner_des'] }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="team_banner_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['team_banner_image']) && !empty($adm_setting['team_banner_image']) ? asset(path_image().$adm_setting['team_banner_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('team_banner_image') }}</strong></span>
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
                        <div class="col-lg-12 tabcontent mt-4" id="Portfolio">
                            {{ Form::open(['route' => 'saveWebSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Banner Title')}}</label>
                                        <input type="text" name="portfolio_banner_title" value ="@if(isset($adm_setting['portfolio_banner_title'])) {{ $adm_setting['portfolio_banner_title'] }} @endif" class="form-control" placeholder="{{__('Portfolio Page Banner Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Description')}}</label>
                                        <textarea name="portfolio_banner_des" id="" rows="8" placeholder="{{__('Portfolio page banner description')}}" class="form-control">@if(isset($adm_setting['portfolio_banner_des'])) {{ $adm_setting['portfolio_banner_des'] }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="portfolio_banner_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['portfolio_banner_image']) && !empty($adm_setting['portfolio_banner_image']) ? asset(path_image().$adm_setting['portfolio_banner_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('portfolio_banner_image') }}</strong></span>
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
                        <div class="col-lg-12 tabcontent mt-4" id="Gallery">
                            {{ Form::open(['route' => 'saveWebSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Banner Title')}}</label>
                                        <input type="text" name="gallery_banner_title" value ="@if(isset($adm_setting['gallery_banner_title'])) {{ $adm_setting['gallery_banner_title'] }} @endif" class="form-control" placeholder="{{__('Gallery Page Banner Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Description')}}</label>
                                        <textarea name="gallery_banner_des" id="" rows="8" placeholder="{{__('Gallery page banner description')}}" class="form-control">@if(isset($adm_setting['gallery_banner_des'])) {{ $adm_setting['gallery_banner_des'] }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Banner Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="gallery_banner_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['gallery_banner_image']) && !empty($adm_setting['gallery_banner_image']) ? asset(path_image().$adm_setting['gallery_banner_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('gallery_banner_image') }}</strong></span>
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
                        <div class="col-lg-12 tabcontent mt-4" id="Achievement">
                            {{ Form::open(['route' => 'saveAchievementSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement Title')}}</label>
                                        <input type="text" name="achievement_title" value ="@if(isset($adm_setting['achievement_title'])) {{ $adm_setting['achievement_title'] }} @endif" class="form-control" placeholder="{{__('Achievement Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement Sub Title')}}</label>
                                        <input type="text" name="achievement_sub_title" value ="@if(isset($adm_setting['achievement_sub_title'])) {{ $adm_setting['achievement_sub_title'] }} @endif" class="form-control" placeholder="{{__('Achievement sub title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Achievement Description')}}</label>
                                        <textarea name="achievement_des" id="" rows="5" placeholder="{{__('Achievement description')}}" class="form-control">@if(isset($adm_setting['achievement_des'])) {{ $adm_setting['achievement_des'] }}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for=""><b>{{__('Achievement List')}}</b></label>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 1 Title')}}</label>
                                        <input type="text" name="achievement_list1_title" value ="@if(isset($adm_setting['achievement_list1_title'])) {{ $adm_setting['achievement_list1_title'] }} @endif" class="form-control" placeholder="{{__('Achievement List 1 title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 1 Count')}}</label>
                                        <input type="text" name="achievement_list1_count" value ="@if(isset($adm_setting['achievement_list1_count'])) {{ $adm_setting['achievement_list1_count'] }} @endif" class="form-control" placeholder="{{__('Achievement List 1 count')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 2 Title')}}</label>
                                        <input type="text" name="achievement_list2_title" value ="@if(isset($adm_setting['achievement_list2_title'])) {{ $adm_setting['achievement_list2_title'] }} @endif" class="form-control" placeholder="{{__('Achievement List 2 title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 2 Count')}}</label>
                                        <input type="text" name="achievement_list2_count" value ="@if(isset($adm_setting['achievement_list2_count'])) {{ $adm_setting['achievement_list2_count'] }} @endif" class="form-control" placeholder="{{__('Achievement List 2 count')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 3 Title')}}</label>
                                        <input type="text" name="achievement_list3_title" value ="@if(isset($adm_setting['achievement_list3_title'])) {{ $adm_setting['achievement_list3_title'] }} @endif" class="form-control" placeholder="{{__('Achievement List 3 title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 3 Count')}}</label>
                                        <input type="text" name="achievement_list3_count" value ="@if(isset($adm_setting['achievement_list3_count'])) {{ $adm_setting['achievement_list3_count'] }} @endif" class="form-control" placeholder="{{__('Achievement List 3 count')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 4 Title')}}</label>
                                        <input type="text" name="achievement_list4_title" value ="@if(isset($adm_setting['achievement_list4_title'])) {{ $adm_setting['achievement_list4_title'] }} @endif" class="form-control" placeholder="{{__('Achievement List 4 title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 4 Count')}}</label>
                                        <input type="text" name="achievement_list4_count" value ="@if(isset($adm_setting['achievement_list4_count'])) {{ $adm_setting['achievement_list4_count'] }} @endif" class="form-control" placeholder="{{__('Achievement List 4 count')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 5 Title')}}</label>
                                        <input type="text" name="achievement_list5_title" value ="@if(isset($adm_setting['achievement_list5_title'])) {{ $adm_setting['achievement_list5_title'] }} @endif" class="form-control" placeholder="{{__('Achievement List 5 title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Achievement List 5 Count')}}</label>
                                        <input type="text" name="achievement_list5_count" value ="@if(isset($adm_setting['achievement_list5_count'])) {{ $adm_setting['achievement_list5_count'] }} @endif" class="form-control" placeholder="{{__('Achievement List 5 count')}}">
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
                        <div class="col-lg-12 tabcontent mt-4" id="Work">
                            {{ Form::open(['route' => 'saveWebSettings', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Work Header Title')}}</label>
                                        <input type="text" name="work_header_title" value ="@if(isset($adm_setting['work_header_title'])) {{ $adm_setting['work_header_title'] }} @endif" class="form-control" placeholder="{{__('Work Header Title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Work Title')}}</label>
                                        <input type="text" name="work_title" value ="@if(isset($adm_setting['work_title'])) {{ $adm_setting['work_title'] }} @endif" class="form-control" placeholder="{{__('Work title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Work Sub Title')}}</label>
                                        <input type="text" name="work_sub_title" value ="@if(isset($adm_setting['work_sub_title'])) {{ $adm_setting['work_sub_title'] }} @endif" class="form-control" placeholder="{{__('Work sub title')}}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>{{__('Work Description')}}</label>
                                        <textarea name="work_des" id="" rows="5" placeholder="{{__('Work description')}}" class="form-control">@if(isset($adm_setting['work_des'])) {{ $adm_setting['work_des'] }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{__('Work Image')}}</label>
                                        <div id="file-upload" class="section">
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="work_image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($adm_setting['work_image']) && !empty($adm_setting['work_image']) ? asset(path_image().$adm_setting['work_image']) : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('work_image') }}</strong></span>
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