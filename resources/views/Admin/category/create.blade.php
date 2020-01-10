@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.category')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.add') @lang('language.category')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    {!! Form::open(['route' => 'category.store', 'files' => true]) !!}
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category_name') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('category_name', null ,['class'=>'form-control', 'placeholder' => __('language.categoryName')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('category_name') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category_name_arabic') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('category_name_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.categoryNameArabic')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('category_name_arabic') }}</small>
                                </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('parent_category') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('parent_category', $parentCategory, null,['class'=>'form-control', 'placeholder' => __('language.parentCategory')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('parent_category') }}</small>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('tax', $tax, null,['class'=>'form-control', 'placeholder' => __('language.tax')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('tax') }}</small>
                                </div>
                            </div>

                        </div>


                        <div class="row clearfix">
                            
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('status', [ 1 => __('language.active'), 0 => __('language.inactive')], null ,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.status')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('status') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category_image') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    <input type="file" id="category_image" name="category_image">
                                    </div>
                                    <small class="text-danger">{{ $errors->first('category_image') }}</small>
                                </div>
                                <img src="" id="preview" width="300px" height="200px">
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary pull-right btn_save ">@lang('language.save')</button>
                                <button type="reset" class="btn blue_btn pull-right btn_edit spacebetween">@lang('language.reset')</button>
                            </div>
                        </div>
                    {!! Form::Close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#preview').hide();
        $('#category_image').change(function () {
            readURL(this);
        })
    });
    function readURL(input) {
        $('#preview').show();
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
    }   
</script>
@endsection
