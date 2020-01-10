@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <div class="block-header">
                <h2>@lang('language.product')</h2>
            </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.create')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    {!! Form::open(['route' => 'products.image-upload', 'files' => true]) !!}
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('product_image') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    <input type="file" name="product_image[]" class="form-control" accept=".gif, .jpg, .png" multiple>
                                    </div>
                                    
                                    <small class="text-danger">{{ $errors->first('product_image') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category_name_arabic') ? ' has-error' : '' }}">
                                    @if(isset($imagePath))
                                        @if(count($imagePath) > 0)
                                            @foreach($imagePath as $key => $value)
                                                <img src="{{$value}}" class="imageThumb">
                                                <label>{{$value}}</label>
                                            @endforeach
                                        @endif
                                    @endif
                                    <small class="text-danger">{{ $errors->first('category_name_arabic') }}</small>
                                </div>
                            </div>

                        </div>

                        <div class="clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn blue_btn">Reset</button>
                                </div>
                            </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
