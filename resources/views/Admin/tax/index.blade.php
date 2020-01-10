@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.tax')</h2>
            </div> -->
 <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('Admin.errors.errorMessage')
            <div class="card">
                <div class="header">
                    <h2>@lang('language.tax') <a href="{{URL::to('tax/create')}}" class="pull-right btn btn-primary">@lang('language.addValue') @lang('language.tax')</a>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.no')</th>
                                    <th>@lang('language.taxName')</th>
                                    <th>@lang('language.taxDescription')</th>
                                    <th>@lang('language.taxRate')</th>
                                    <th>@lang('language.status')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($taxDetails) and (count($taxDetails) > 0))
                                @foreach($taxDetails as $key => $tax)
                                    <tr>
                                        <td>{{ $key+1 }} </td>
                                        <td>{{ app()->getLocale() == 'ar' ? $tax->tax_name_arabic : $tax->tax_name }}</td>
                                        <td>{{ app()->getLocale() == 'ar' ? $tax->tax_description_arabic : $tax->tax_description }}</td>
                                        <td>{{ ucfirst($tax->tax_rate) }}</td>
                                        <td>{{ $tax->status ? __('language.active') : __('language.inactive') }}</td>
                                        <td width="15%" style="text-align: center;">
                                            <a href="{{ route('tax.edit', ['id' => $tax->id]) }}"
                                            class="tool_tip"><i class="material-icons"  data-toggle="tooltip" data-placement="top" data-original-title="{{ __('language.edit')}}">edit</i></a>
                                            @if($tax->id)
                                            <?php $route = URL::to('tax/'.$tax->id);
                                                        $token = csrf_token();
                                                    ?>
                                                    <a href="#"  class="tool_tip"><i class="material-icons" onclick="deleteValue('<?php echo $route; ?>', this)"><i class="material-icons iconDelete"  data-toggle="tooltip" data-placement="top" data-original-title="{{ __('language.delete')}}">delete_forever</i></i></a>
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
