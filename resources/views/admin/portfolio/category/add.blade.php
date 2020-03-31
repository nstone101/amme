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
                            {{ Form::open(['route' => 'portfolioCategorySave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label>{{__('Title')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="name" @if(isset($item)) value="{{$item->name}}" @else value="{{old('name')}}" @endif class="form-control" placeholder="Title">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('Description')}}</label>
                                        <textarea name="description" id="" rows="6" class="form-control">@if(isset($item)){{$item->description}}@else{{old('description')}}@endif</textarea>
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