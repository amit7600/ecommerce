@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <div class="block-header">
                <h2>@lang('language.productImportExport')</h2>
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
                                <div class="form-group{{ $errors->has('product_import') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                        <label>@lang('language.uploadExcel')</label>
                                        <input type="file" name="product_import" class="form-control" accept=".xls, .csv">
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_import') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <a href="{{URL::to('products/export')}}" class="btn btn-primary">@lang('language.export')</a>
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
