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
                            {{ Form::open(['route' => 'planSave', 'files' => 'true']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label>{{__('Plan Title')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="title" @if(isset($item)) value="{{$item->title}}" @else value="{{old('title')}}"
                                               @endif class="form-control" placeholder="{{__('Plan title')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('title') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                                        <label>{{__('Price')}}<span class="text-danger">*</span></label>
                                        <input type="text" name="price" @if(isset($item)) value="{{$item->price}}" @else value="{{old('price')}}"
                                               @endif class="form-control" placeholder="{{__('Pricing Price')}}">
                                        <span class="text-danger"><strong>{{ $errors->first('price') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('Duration')}}<span class="text-danger">*</span></label>
                                        <div class="qz-question-category">
                                            <select name="duration" class="form-control">
                                                @foreach(plan_duration() as $key => $value)
                                                    <option @if(isset($item) && ($item->duration == $key)) selected @elseif((old('duration') != null) && (old('duration') == $key)) @endif value="{{ $key }}">{{$value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger"><strong>{{ $errors->first('duration') }}</strong></span>
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
                                        <textarea name="description" id="" rows="4" class="form-control">@if(isset($item)){{$item->description}}@else{{old('description')}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>{{__('Feature')}}<span style="color:red;">*</span></label>
                                        <input type="text" name="features" value="" id="price" class="form-control"/>
                                        <span class="text-danger"><strong>{{ $errors->first('features') }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('Add Remove')}}</label><br>
                                        <input type="button" name="reset" class="btn btn-info" onclick="AddOptionRow();" value="+">
                                        <input type="button" name="add" class="btn btn-danger" onclick="removeOptionRow();" value="-">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="option_count" id="option_count" value="1">
                                    <input type="hidden" name="option_counts" id="option_counts">
                                    <table class="table table-bordered" id="first" border="1">
                                        <thead>
                                        <tr>
                                            <th>{{__('Feature List')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($plan_features[0]))
                                            @php ($i=1)
                                            @foreach($plan_features as $plan_feature)
                                                <tr>
                                                    <td>
                                                        <input type="text" value="{{$plan_feature->title}}" name="features[]" id="price{{$i}}" class="form-control">
                                                    </td>
                                                </tr>
                                                @php ($i++)
                                            @endforeach
                                        @endif
                                        </tbody>

                                    </table>
                                    <pre class="text-danger">{{$errors->first('option_id')}}</pre>
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
        // for adding option
        var option_data = [];
        function AddOptionRow()
        {
            var option_id = $('#price').val();

            if($('#price').val()=="")
            {
                alertify.error("Feature is required");
            }
            else if(in_array(option_id,option_data))
            {
                alertify.error("Already existed");
            }
            else
            {
                var cnt=$("#option_count").val();
                var ncnt = cnt;
                var sno = cnt;
                $('#first tr').last().after('<tr><td><input  type="text" value="'+$('#price').val()+'" name="features[]" id="price'+ncnt+'" class="form-control"></td></tr>');
                cnt=++cnt;
                $("#option_count").val(cnt);
                $("#option_counts").val(cnt);
                option_data.push(option_id);
            }
        }

        //
        function in_array(search, array)
        {
            for (i = 0; i < array.length; i++)
            {
                if(array[i] == search )
                {
                    return true;
                }
            }
            return false;
        }
        // remove option
        function removeOptionRow()
        {
            table = document.getElementById("first");
            var rowno = table.rows.length;

            if(table.rows.length > 1)
            {
                var cnt=$("#option_count").val();
                var ncnt = --cnt;
                var option_id = $('#price'+ncnt).val();

                option_data = jQuery.grep(option_data, function(value) {
                    return value != option_id;
                });

                $('#first tr:last-child').remove();
                $("#option_count").val(ncnt);
                $("#option_counts").val(ncnt);
            }
            $("#option_counts").val("");
        }
    </script>
@endsection