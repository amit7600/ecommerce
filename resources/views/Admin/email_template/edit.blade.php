@extends('layouts.app')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                {!! Form::model($emailtemplates, ['route' => ['email_template.update', $emailtemplates->id], 'files'=> true, 'method' => 'put']) !!}
            <div class="card">
                <div class="header">
                    <h2>@lang('language.add') @lang('language.emailtemplate')</h2>
                </div>
                <div class="body">
                    @include('Admin.errors.errorMessage')
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
                            <div class="form-group{{ $errors->has('email_subject') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::text('email_subject' , null ,['class' => 'form-control', 'placeholder'
                                    => __('language.emailSubject'),'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('email_body') ? 'has-error' : '' }}">
                                <div class="form-line">
                                    {!! Form::textarea('email_body' , null ,['class' => 'form-control', 'placeholder'
                                    => __('language.emailBody'),'id' => 'article-ckeditor']) !!}
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
<script>
CKEDITOR.replace('article-ckeditor');
</script>
@endsection