@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.tax')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.edit') @lang('language.tax')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    {!! Form::model($taxDetails, ['route' => ['tax.update', $taxDetails->id], 'method' => 'put']) !!}
                    <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax_name') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('tax_name', null ,['class'=>'form-control', 'placeholder' => __('language.taxName')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('tax_name') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax_name_arabic') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('tax_name_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.taxNameArabic')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('tax_name_arabic') }}</small>
                                </div>
                            </div>

                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax_description') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::textarea('tax_description', null ,['class'=>'form-control', 'placeholder' => __('language.taxDescription'), 'rows'=>3]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('tax_description') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax_description_arabic') ? ' has-error' : '' }}">
                                        <div class="form-line">
                                        {!! Form::textarea('tax_description_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.taxDescriptionArabic'), 'rows'=>3]) !!}
                                        </div>
                                        <small class="text-danger">{{ $errors->first('tax_description_arabic') }}</small>
                                    </div>
                            </div>

                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax_rate') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::number('tax_rate', null ,['class'=>'form-control', 'placeholder' => __('language.taxRate'), 'min' => 0]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('tax_rate') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('status', [ 1 => __('language.active'), 0 => __('language.inactive')], null ,['class'=>'form-control', 'placeholder' => __('language.status')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('status') }}</small>
                                </div>
                            </div>

                        </div>


                        <div class="clearfix">
                                <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary pull-right btn_save ">@lang('language.update')</button>
                                    <!-- <button type="reset" class="btn blue_btn">@lang('language.reset')</button> -->
                                </div>
                            </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
