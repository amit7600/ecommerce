@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.attributes')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>@lang('language.edit') @lang('language.productAlert') @lang('language.attribute')</h2>
                </div>
                <div class="body">
                @include('Admin.errors.errorMessage')
                    {!! Form::model($attributes, ['route' => ['attributes.update', $attributes->id], 'method' => 'put']) !!}
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('attribute') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('attribute', null ,['class'=>'form-control', 'placeholder' => __('language.attributes')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('attribute') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('attribute_arabic') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('attribute_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.attributeArabic')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('attribute_arabic') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                                    <div class="form-line" id="test">
                                    
                                    </div>
                                    <small class="text-danger">{{ $errors->first('value') }}</small>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary add_more_button" >@lang('language.addValue')</button>
                                </div>
                            </div>
                        </div>
                        <!-- for multiple fields -->
                        <div class="input_fields_container">
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary pull-right btn_save ">@lang('language.update')</button>
                                <!-- <button type="reset" class="btn blue_btn">@lang('language.reset')</button> -->
                            </div>
                        </div>
                        <input type="hidden" name="removeIds" value="" id="removeIds">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    var max_fields_limit = 100; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    var removeArray = []
    var arrayFromPHP = <?php echo json_encode($attributes->childAttribute) ?>;
    if(arrayFromPHP.length > 0) {
        $.each(arrayFromPHP, function (i, elem) {
            // do your stuff
            if (i == 0) {
                $('#test').append('<input type="text" name="value[]" value="'+elem.value+'" class="form-control" placeholder="Value" />');
            } else { //check conditions
                $('.input_fields_container').append('<div class="row clearfix"><div class="col-sm-4"></div><div class="col-sm-3"></div><div class="col-sm-3"><div class="form-group"><div class="form-line"><input type="text" name="value[]" value="'+elem.value+'" class="form-control" placeholder="Value" /></div></div></div><div class="col-sm-2"><a href="#" id="'+elem.id+'" class="remove_field btn btn-danger" style="margin-left:10px;">-</a></div></div>'); //add input field
            }
        });
    } else {
        $('#test').append('<input type="text" name="value[]" value="" class="form-control" placeholder="Value" />');
    }
    
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div class="row clearfix"><div class="col-sm-4"></div><div class="col-sm-3"></div><div class="col-sm-3"><div class="form-group"><div class="form-line"><input type="text" name="value[]" class="form-control" placeholder="Value" /></div></div></div><div class="col-sm-2"><a href="#" class="remove_field btn btn-danger" style="margin-left:10px;">-</a></div></div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        $conf = confirm("<?php echo __('language.deleteMessage'); ?>")
        if($conf) {
            $(this).parent().parent().remove(); x--;
            removeArray.push(e.target.id)
            $('#removeIds').val(removeArray)
        }
    })
});
</script>
@endsection
