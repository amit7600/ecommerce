@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.roles')</h2>
            </div> -->
 <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('Admin.errors.errorMessage')
            <div class="card">
                <div class="header">
                    <h2>@lang('language.user') @lang('language.roles') <a href="{{URL::to('roles/create')}}" class="pull-right btn btn-primary">@lang('language.addValue') @lang('language.role')</a>
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.id')</th>
                                    <th>@lang('language.roleName')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($rolesDetails) and (count($rolesDetails) > 0))
                                @foreach($rolesDetails as $role)
                                    <tr>
                                        <td >{{ $role->id }} </td>
                                        <td>{{ app()->getLocale() == 'ar' ? $role->role_name_arabic : $role->role_name }}</td>
                                        <td width="15%" style="text-align: center;">
                                            <a href="{{ route('roles.edit', ['id' => $role->id]) }}"
                                            class="tool_tip"><i class="material-icons" data-toggle="tooltip" data-placement="top" data-original-title="{{ __('language.edit')}}">edit</i></a>
                                            @if($role->id !== 1 and $role->id !== 2 and $role->id !== 3)
                                            <?php $route = URL::to('roles/'.$role->id);
                                                $token = csrf_token();
                                             ?>
                                            <a href="#"  class="tool_tip"><i class="material-icons" onclick="deleteValue('<?php echo $route; ?>', this)"><i class="material-icons iconDelete" data-toggle="tooltip" data-placement="top" data-original-title="{{ __('language.delete')}}">delete_forever</i></i></a>
                                            @endif
                                            <!-- <a href="{{ route('roles.destroy', ['id' => $role->id]) }}"
                                            class="btn btn-default btn-sm">Delete
                                            </a> -->
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
