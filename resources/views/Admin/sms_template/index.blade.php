@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- <div class="block-header">
                <h2>@lang('language.product')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('Admin.errors.errorMessage')
            <div class="card">
                <div class="header">
                    <h2>@lang('language.smstemplate') <a href="{{URL::to('sms_template/create')}}"
                            class="pull-right btn btn-primary">@lang('language.addValue') @lang('language.template')</a>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.id')</th>
                                    <th>@lang('language.templateName')</th>
                                    <th>@lang('language.message')</th>
                                    <th>@lang('language.status')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($smsTemplates) and (count($smsTemplates) > 0))
                                @foreach($smsTemplates as $key => $smsTemplate)
                                <tr>
                                    <td>{{ $key + 1 }} </td>
                                    <td>{{ $smsTemplate->name }}</td>
                                    <td>{{ $smsTemplate->sms_body }}</td>

                                    <td class="switch">
                                    <label><input type="checkbox" onclick="changeStatus(this.value, <?php echo $smsTemplate->id; ?> )" value="{{$smsTemplate->status}}" <?php if ($smsTemplate->status == '1') {echo 'checked';}?> ><span class="lever" ></span></label>
                                    </td>
                                    <td width="15%" style="text-align: center;">
                                        <a href="{{ route('sms_template.edit', ['id' => $smsTemplate->id]) }}"
                                            class="tool_tip"><i class="material-icons" data-toggle="tooltip"
                                                data-placement="top"
                                                data-original-title="{{ __('language.edit')}}">edit</i></a>
                                        @if($smsTemplate->id)
                                        <?php $route = URL::to('sms_template/' . $smsTemplate->id);
$token = csrf_token();
?>
                                        @if($smsTemplate->id !== 1 and $smsTemplate->id !== 2)
                                        <a href="#" class="tool_tip"><i class="material-icons"
                                                onclick="deleteValue('<?php echo $route; ?>', this)"><i
                                                    class="material-icons iconDelete" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="{{ __('language.delete')}}">delete_forever</i></i></a>
                                        @endif
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
function changeStatus(value,id){
        $('#errorAlertMessage').empty('')
        $conf = confirm("<?php echo __('language.statusMessage'); ?>")

        if ($conf) {
            if(value == 1){
                value = 0
            }else{

                value = 1
            }
            $.ajax({
                type: 'POST',
                url: 'smsStatus/' + id,
                headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                    },
                data: {
                    'status' : value
                },
                success: function(msg){
                    $('#errorAlertMessage').append('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+msg.success+'</div>');
                },
                error: function(request,msg,error) {
                    // handle failure
                    console.log(request,msg,error)
                    $('#errorAlertMessage').append('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+error+'</div>');
                    // $(this).parent('tr').remove();
                    // setTimeout(function(){ location.reload(); }, 1000);
                }

            });
        }
    }
</script>
@endsection
