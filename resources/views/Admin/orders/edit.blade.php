@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {!! Form::model($orders->order_detail, ['route' => ['orders.update', $orders->id], 'files'=> true, 'method' => 'put']) !!}
            <div class="card">
                <div class="header">
                    <h2>@lang('language.edit') @lang('language.order')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('quantity') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('quantity' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.templateName'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right btn_save">@lang('language.save')</button>
                            <button type="reset"
                                class="btn blue_btn pull-right spacebetween btn_edit">@lang('language.reset')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection