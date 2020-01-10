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
                    <h2>@lang('language.add') @lang('language.offer')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    {!! Form::open(['route' => 'offers.store']) !!}
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('coupon_code') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('coupon_code', null ,['class'=>'form-control', 'placeholder' => __('language.couponCode')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('coupon_code') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('discount', [ 'flat' => __('language.flat'), 'percentage' => __('language.percentage')], null ,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.discount')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('discount') }}</small>
                                </div>
                            </div>

                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('discount_amount') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('discount_amount', null ,['class'=>'form-control', 'placeholder' => __('language.discountAmount')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('discount_amount') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('minimum_order_amount') ? ' has-error' : '' }}">
                                        <div class="form-line">
                                        {!! Form::text('minimum_order_amount', null ,['class'=>'form-control', 'placeholder' => __('language.minimumOrderAmount')]) !!}
                                        </div>
                                        <small class="text-danger">{{ $errors->first('minimum_order_amount') }}</small>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('	minimum_offer_amount') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('minimum_offer_amount', null ,['class'=>'form-control', 'placeholder' => __('language.minimumOfferAmount')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('	minimum_offer_amount') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('status', [ 1 => __('language.active'), 0 => __('language.inactive')], null ,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.status')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('status') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('start_date', null ,['class'=>'form-control datepicker1', 'placeholder' => __('language.startDate'), 'data-provide'=> 'datepicker']) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('start_date') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                                        <div class="form-line">
                                        {!! Form::text('end_date', null ,['class'=>'form-control datepicker', 'placeholder' => __('language.endDate'), 'data-provide'=> 'datepicker']) !!}
                                        </div>
                                        <small class="text-danger">{{ $errors->first('end_date') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right btn_save ">@lang('language.save')</button>
                                    <button type="reset" class="btn blue_btn pull-right spacebetween btn_edit">@lang('language.reset')</button>
                                </div>
                            </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('.datepicker1').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
@endsection
