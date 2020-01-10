@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.attributes')</h2>
            </div> -->
 <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('Admin.errors.errorMessage')
            <div class="card">
                <div class="header">
                    <h2>@lang('language.productAlert') @lang('language.attributes') <a href="{{URL::to('attributes/create')}}" class="pull-right btn btn-primary">@lang('language.addValue') @lang('language.productAlert') @lang('language.attribute')</a>

                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.id')</th>
                                    <th>@lang('language.attributes')</th>
                                    <th>@lang('language.value')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($attributes) and (count($attributes) > 0))
                                @foreach($attributes as $att)
                                <?php $values = [];?>
                                    <tr>
                                        <td>{{ $att->id }} </td>
                                        <td>{{ app()->getLocale() == 'ar' ? $att->attribute_arabic : $att->attribute }}</td>
                                        <td>
                                            @if(count($att->childAttribute) > 0) 
                                                @foreach ($att->childAttribute as $key => $value)
                                                    <?php $values[] = strtoupper($value->value);?>
                                                @endforeach
                                            @endif
                                            {{ count($values) > 0 ? implode(',', $values) : '' }}
                                        </td>
                                        <td width="15%" style="text-align: center;">
                                            <a href="{{ route('attributes.edit', ['id' => $att->id]) }}"
                                             class="tool_tip"><i class="material-icons" data-toggle="tooltip" data-placement="top" data-original-title="{{ __('language.edit')}}">edit</i></a>
                                            @if($att->id)
                                            <?php $route = URL::to('attributes/'.$att->id);
                                                        $token = csrf_token();
                                                    ?>
                                                    <a href="#"  class="tool_tip"><i class="material-icons" onclick="deleteValue('<?php echo $route; ?>', this)"><i class="material-icons iconDelete" data-toggle="tooltip" data-placement="top" data-original-title="{{ __('language.delete')}}" >delete_forever</i></i></a>
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
