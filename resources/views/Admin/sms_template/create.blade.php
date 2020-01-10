@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.add') @lang('language.smstemplate')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
                    {!! Form::open(['route' => 'sms_template.store']) !!}
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('name') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('name' , null ,['class' => 'form-control', 'placeholder' =>
                                    __('language.templateName'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="4" style="text-align:center;">List of variable</th>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Variable</th>
                                    <th>Name</th>
                                    <th>Variable</th>
                                </tr>
                                <tr>
                                    <td>First Name</td>
                                    <td>{var_first_name}</td>
                                    <td>Last Name</td>
                                    <td>{var_last_name}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{var_email}</td>
                                    <td>Mobile Number</td>
                                    <td>{var_mobile_number}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{var_address}</td>
                                    <td>Reward Code</td>
                                    <td>{var_reward_code}</td>
                                </tr>
                                <tr>
                                    <td>Reward Points Balance</td>
                                    <td>{var_point_balance}</td>
                                    <td>Link</td>
                                    <td>{var_link}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('sms_body') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::textarea('sms_body' , null ,['class' => 'form-control', 'placeholder'
                                    => __('language.message'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="1">
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