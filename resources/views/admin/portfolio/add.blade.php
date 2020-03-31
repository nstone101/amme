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
                            {{ Form::open(['route' => 'portfolioSave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{__('Portfolio Title')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="title" @if(isset($item)) value="{{$item->title}}" @else value="{{old('title')}}"
                                               @endif class="form-control" placeholder="{{__('Portfolio Title')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('title') }}</strong></span>
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
                                    <div class="form-group {{ $errors->has('client') ? ' has-error' : '' }}">
                                        <label>{{__('Client')}}<span class="text-danger"></span></label>
                                        <input type="text" name="client" @if(isset($item)) value="{{$item->client}}" @else value="{{old('client')}}" @endif
                                            class="form-control" placeholder="{{__('Client Name')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('client') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
                                        <label>{{__('Date')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="date" @if(isset($item)) value="{{$item->date}}" @else value="{{old('date')}}"
                                               @endif class="form-control datepicker" placeholder="{{__('YYYY-MM-DD')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('date') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('demo') ? ' has-error' : '' }}">
                                        <label>{{__('Demo Link')}}<span class="text-danger"></span></label>
                                        <input type="text" name="demo" @if(isset($item)) value="{{$item->demo}}" @else value="{{old('demo')}}"
                                               @endif class="form-control" placeholder="{{__('Demo Link')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('demo') }}</strong></span>
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
                                        <label>{{__('Description')}}<span class="text-danger">*</span></label>
                                        <textarea name="description" id="" rows="6" class="form-control">@if(isset($item)){{$item->description}}@else{{old('description')}}@endif</textarea>
                                        <span class="text-danger"><strong>{{ $errors->first('description') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{__('Experience')}}</label>
                                        <textarea name="experience" id="" rows="6" class="form-control">@if(isset($item)){{$item->experience}}@else{{old('experience')}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-4">
                                    <label>{{__('Image')}}</label><br>
                                    <div class="drag_img_wrapper">
                                        <label for="uploadimage">
                                            <i class="fa fa-cloud-upload"></i>
                                        </label>
                                        <div class="d-none">
                                            <input type="file" id="uploadimage" name="image[]" multiple onchange="readURL(this,'image')">
                                        </div>
                                    </div>
                                    <pre class="text-danger">{{$errors->first('image.*')}}</pre>
                                </div>
                                <div class="col-sm-8 col-8" id="imgs">
                                    @if(isset($item))
                                        @php($n= 1)
                                        @foreach($item->image as $img)
                                            <div class="product-imgs" id="row{{$n}}">
                                                <img width="" src="{{$img}}" />
                                                <i class="fa fa-times remove-uploaded-img" data-src="{{$img}}" id="{{$n}}"></i>
                                            </div>
                                            @php($n++)
                                        @endforeach
                                    @endif
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
    <script>
        function readURL(input,name) {
            var n=1;
            if (input.files && input.files[0]) {
                var fileList=input.files;
                for(var i = 0; i < fileList.length; i++)
                {
                    //get a blob
                    var t = window.URL || window.webkitURL;
                    var objectUrl = t.createObjectURL(fileList[i]);
                    $('#imgs').append('<div class="product-imgs"><img width="100" src="' + objectUrl + '" /></div>');
                }
            }
        }
        $(document).on('click', '.remove-imgs', function(){
            var remove_id = $(this).attr("id");
            $('#rows'+remove_id+'').remove();
        });

        $(document).on('click', '.remove-uploaded-img', function(){

            id = <?php echo (!empty($item) ? $item->id : '""'); ?>;
            var src = $(this).data("src");
            var t =src.split("/");
            imgSrc = t[t.length-1];

            $.ajax({
                type: "GET",
                url: '{{ route('deleteUploadedImage') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                    'src': imgSrc,
                },
                success: function (data) {
                    console.log(data['data']['updateData']);
                }
            });
            var remove_id = $(this).attr("id");
            $('#row'+remove_id+'').remove();
        });
    </script>
@endsection