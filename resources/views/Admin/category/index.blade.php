@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.category')</h2>
            </div> -->
 <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('Admin.errors.errorMessage')
            <div class="card">
                <div class="header">
                    <h2>@lang('language.category') <a href="{{URL::to('category/create')}}" class="pull-right btn btn-primary">@lang('language.addValue') @lang('language.category')</a>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.no')</th>
                                    <th>@lang('language.categoryName')</th>
                                    <th>@lang('language.parentCategory')</th>
                                    <th>@lang('language.tax')</th>
                                    <th>@lang('language.status')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($categoryDetails) and (count($categoryDetails) > 0))
                                @foreach($categoryDetails as $key => $cat)
                                    <tr>
                                        <td>{{ $key+1 }} </td>
                                        <td>{{ app()->getLocale() == 'ar' ? $cat->category_name_arabic : $cat->category_name }}</td>
                                        <td>
                                            {{ $cat->parent_category ? app()->getLocale() == 'ar' ? $cat->parent->category_name_arabic : $cat->parent->category_name : '-' }}</td>
                                        <td>
                                            {{ $cat->tax_id ? app()->getLocale() == 'ar' ? $cat->taxes->tax_name_arabic : $cat->taxes->tax_name : '' }}
                                        </td>
                                        <td>{{ $cat->status ? __('language.active') : __('language.inactive') }}</td>
                                        <td width="15%" style="text-align: center;">
                                            <a href="{{ route('category.edit', ['id' => $cat->id]) }}"
                                            class="tool_tip"><i data-original-title="{{ __('language.edit')}}" data-toggle="tooltip" data-placement="top" class="material-icons">edit</i></a>
                                            @if($cat->id)
                                                    <?php $route = URL::to('category/'.$cat->id);
                                                        $token = csrf_token();
                                                    ?>
                                                    <a href="#"  class="tool_tip"><i class="material-icons" onclick="deleteValue('<?php echo $route; ?>', this)"><i class="material-icons iconDelete"  data-original-title="{{ __('language.delete')}}"  data-toggle="tooltip" data-placement="top">delete_forever</i></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- <tr><td colspan="3" align="center">record not found</td></tr> -->
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Basic Examples -->
</div>

<script>
    function confirmDelete() {
        return confirm("<?php echo __('language.deleteMessage'); ?>");
    }
</script>
@endsection
