@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.roles')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.create') @lang('language.user') @lang('language.role')</h2>
                </div>
                <div class="body">
                @include('Admin.errors.errorMessage')
                    {!! Form::open(['route' => 'roles.store']) !!}
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('role_name') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('role_name', null ,['class'=>'form-control', 'placeholder' => __('language.roleName')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('role_name') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('role_name_arabic') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('role_name_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.roleNameArabic')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('role_name_arabic') }}</small>
                                </div>
                            </div>
                            @foreach($menus as $key=>$value)
                                <div>
                                    <div class="col-sm-12">
                                        <?php 
                                        $id = 'basic_checkbox_ '.($key+1) ;
                                            // dd($value->id);
                                            ?>
                                            <!-- <input type="checkbox" value="permissions[]" id="{{ $id }}"> -->
                                        {{  Form::checkbox('permissions[]',$value->id,null, array('id' =>$id)) }}  
                                        @if($value->parent_id == null)
                                            <label for="{{ $id }}"><strong>{{ $value->menu }}<strong></label>
                                        @else
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="{{ $id }}">{{ $value->menu }}</label>
                                        @endif
                                    </div>
                                 </div>
                             @endforeach
                            <div class="clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn_save pull-right">@lang('language.save')</button>
                                    <button type="reset" class="btn blue_btn pull-right btn_edit spacebetween">@lang('language.reset')</button>
                                </div>
                            </div>
                        {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
