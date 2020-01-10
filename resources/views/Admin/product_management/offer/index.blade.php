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
                    <h2>@lang('language.offers') <a href="{{URL::to('offers/create')}}" class="pull-right btn btn-primary">@lang('language.addValue') @lang('language.offer')</a>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.no')</th>
                                    <th>@lang('language.couponCode')</th>
                                    <th>@lang('language.discount')</th>
                                    <th>@lang('language.discountAmount')</th>
                                    <th>@lang('language.startDate')</th>
                                    <th>@lang('language.endDate')</th>
                                    <th>@lang('language.status')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($offers) and (count($offers) > 0))
                                @foreach($offers as $key => $offer)
                                    <tr>
                                        <td>{{ $key+1 }} </td>
                                        <td>{{ $offer->coupon_code }}</td>
                                        <td>{{ $offer->discount }}</td>
                                        <td>{{ $offer->discount_amount }}</td>
                                        <td>{{ $offer->start_date }}</td>
                                        <td>{{ $offer->end_date }}</td>
                                        <td>{{ $offer->status ? __('language.active') : __('language.inactive') }}</td>
                                        <td width="15%" style="text-align: center;">
                                            <a href="{{ route('offers.edit', ['id' => $offer->id]) }}"
                                            class="tool_tip"><i data-original-title="{{ __('language.edit')}}" data-toggle="tooltip" data-placement="top" class="material-icons">edit</i></a>
                                            @if($offer->id)
                                                    <?php $route = URL::to('offers/'.$offer->id);
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
