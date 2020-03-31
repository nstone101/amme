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
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::open(['route' => 'teamSave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>{{__('Member Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name" @if(isset($item)) value="{{$item->name}}" @else value="{{old('name')}}"
                                               @endif class="form-control" placeholder="{{__('Member name')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Category')}}<span class="text-danger">*</span></label>
                                        <div class="qz-question-category">
                                            <select name="category_id" class="form-control">
                                                <option value="">{{__('Select')}}</option>
                                                @if(isset($categories[0]))
                                                    @foreach($categories as $key)
                                                        <option @if(isset($item) && ($item->category_id == $key->id)) selected @elseif((old('category_id') != null) && (old('category_id') == $key->id)) @endif value="{{ $key->id }}">{{$key->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('category_id') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('designation') ? ' has-error' : '' }}">
                                        <label>{{__('Designation')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="designation" @if(isset($item)) value="{{$item->designation}}" @else value="{{old('designation')}}" @endif
                                            class="form-control" placeholder="{{__('Member Designation')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('designation') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Status')}}<span class="text-danger">*</span></label>
                                        <div class="qz-question-category">
                                            <select name="status" class="form-control">
                                                @foreach(status() as $key => $value)
                                                    <option @if(isset($item) && ($item->status == $key)) selected @elseif((old('status') != null) && (old('status') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('status') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>{{__('Email')}}<span class="text-danger"></span></label>
                                        <input type="email" name="email" @if(isset($item)) value="{{$item->email}}" @else value="{{old('email')}}"
                                               @endif class="form-control" placeholder="{{__('Member Email Address')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('facebook') ? ' has-error' : '' }}">
                                        <label>{{__('Facebook Id')}}<span class="text-danger"></span></label>
                                        <input type="text" name="facebook" @if(isset($item)) value="{{$item->facebook}}" @else value="{{old('facebook')}}" @endif
                                          class="form-control" placeholder="{{__('Facebook Id')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('facebook') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('twitter') ? ' has-error' : '' }}">
                                        <label>{{__('Twitter Id')}}<span class="text-danger"></span></label>
                                        <input type="text" name="twitter" @if(isset($item)) value="{{$item->twitter}}" @else value="{{old('twitter')}}" @endif
                                            class="form-control" placeholder="{{__('Twitter Id')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('twitter') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('google') ? ' has-error' : '' }}">
                                        <label>{{__('Google Plus Id')}}<span class="text-danger"></span></label>
                                        <input type="text" name="google" @if(isset($item)) value="{{$item->google}}" @else value="{{old('google')}}" @endif
                                         class="form-control" placeholder="{{__('Google Plus Id')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('google') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('skype') ? ' has-error' : '' }}">
                                        <label>{{__('Skypee Id')}}<span class="text-danger"></span></label>
                                        <input type="text" name="skype" @if(isset($item)) value="{{$item->skype}}" @else value="{{old('skype')}}"
                                               @endif class="form-control" placeholder="{{__('Skypee Id')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('skype') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('linkedin') ? ' has-error' : '' }}">
                                        <label>{{__('Linkedin Id')}}<span class="text-danger"></span></label>
                                        <input type="text" name="linkedin" @if(isset($item)) value="{{$item->linkedin}}" @else value="{{old('linkedin')}}" @endif
                                            class="form-control" placeholder="{{__('Linkedin Id')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('linkedin') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('Bio')}}</label>
                                        <textarea name="bio" id="" rows="6" class="form-control">@if(isset($item)){{$item->bio}}@else{{old('bio')}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{__('Thumbnail Image')}}<span class="text-danger"></span></label>
                                        <div id="file-upload" class="section">
                                            <!--Default version-->
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($item) && !empty($item->image) ? $item->image : ''}}" />
                                                    @if ($errors->has('image'))
                                                        <div class="text-danger">{{ $errors->first('image') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!--Default value-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    @if(isset($item))
                                        <input type="hidden" name="edit_id" value="{{$item->id}}">
                                    @endif
                                    <button type="submit" class="btn btn-primary btn-block add-category-btn">
                                        @if(isset($item)) {{__('Update')}} @else {{__('Add New')}} @endif
                                    </button>
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
@endsection