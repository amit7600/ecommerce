@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.edit') @lang('language.user')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    {!! Form::model($users , ['route' => ['users.update', $users->id], 'method' => 'put']) !!}
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('first_name' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.firstName'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('first_name_arabic') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('first_name_arabic' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.firstName') . '  ' .  __('language.InArabic'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('last_name' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.lastName'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('last_name_arabic') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('last_name_arabic' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.lastName') . '  ' .  __('language.InArabic'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('email') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::email('email' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.email'), 'readonly' => 'true']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('password') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::input('password','password' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.password')]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::input('password', 'password_confirmation' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.RePassword')]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <div class="form-group{{ $errors->has('country_code') ? 'has-error' : '' }}">
                                <div class="form-line">
                                {!! Form::select('country_code', $country_code,null, ['class' => 'form-control']); !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('mobile_number') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::number('mobile_number' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.userMobile'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group{{ $errors->has('role_id') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::select('role_id',$roles); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="1">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn_save pull-right">@lang('language.save')</button>
                            <button type="reset"
                                class="btn blue_btn btn_edit spacebetween pull-right">@lang('language.reset')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection