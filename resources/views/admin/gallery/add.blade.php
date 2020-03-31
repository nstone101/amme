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
                            {{ Form::open(['route' => 'gallerySave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>{{__('Image Name')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name" @if(isset($item)) value="{{$item->name}}" @else value="{{old('name')}}"
                                               @endif class="form-control" placeholder="{{__('Image name')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
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
                                    <div class="form-group">
                                        <label>{{__('Short Description')}}</label>
                                        <textarea name="bio" id="" rows="3" class="form-control">@if(isset($item)){{$item->bio}}@else{{old('bio')}}@endif</textarea>
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
                                    <div class="form-group">
                                        <label>{{__('Upload Image')}}<span class="text-danger">*</span></label>
                                        <div id="file-upload" class="section">
                                            <!--Default version-->
                                            <div class="row section">
                                                <div class="col s12 m12 l12">
                                                    <input name="image" type="file" id="input-file-now" class="dropify" data-default-file="{{isset($item) && !empty($item->image) ? $item->image : ''}}" />
                                                    @if ($errors->has('image'))
                                                        <div class="text-danger"><strong>{{ $errors->first('image') }}</strong></div>
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