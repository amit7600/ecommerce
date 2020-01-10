@extends('layouts.app')

@section('content')
<?php 
$remove = [];
?>
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.product')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- card Start -->
            {!! Form::model($product, ['route' => ['products.update', $product->id], 'files'=> true, 'method' => 'put']) !!}
            <div class="card">
                <div class="header">
                    <h2>@lang('language.edit') @lang('language.productAlert')</h2>
                </div>
                <div class="body">
                @include('Admin.errors.errorMessage')
                    
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('product_name', null ,['class'=>'form-control', 'placeholder' => __('language.productName'), 'required' => true]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_name') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('product_name_arabic') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('product_name_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.productNameArabic')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_name_arabic') }}</small>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('product_description') ? ' has-error' : '' }}">
                                    <div  >
                                    {!! Form::textarea('product_description', null ,['class'=>'form-control', 'placeholder' => __('language.productDescription'), 'required' => true, 'id'=>'article-ckeditor']) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_description') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('product_description_arabic') ? ' has-error' : '' }}">
                                    <div>
                                    {!! Form::textarea('product_description_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.productDescriptionArabic'), 'id'=>'article-ckeditor1']) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_description_arabic') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('product_code') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::text('product_code', null ,['class'=>'form-control', 'placeholder' => __('language.productCode'), 'required' => true]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_code') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('category', $category, $product->category_id,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.category'), 'required' => true]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('tax', $tax, $product->tax_id,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.tax')]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('tax') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('status', [ 1 => __('language.active'), 0 => __('language.inactive')], null ,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.status'), 'required' => true]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('status') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Checkbox for product latest and futured -->
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('is_latest') ? ' has-error' : '' }}">
                                    <div class="col-sm-3">
                                        <div class="">
                                            <label> @lang('language.isLatest') </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="switch">
                                        
                                            <label>
                                                @lang('language.no')
                                                    {!! Form::checkbox('is_latest',null) !!}
                                                    <span class="lever" ></span>
                                                @lang('language.yes')
                                            </label>
                                            <!-- <label>OFF<input type="checkbox" checked=""><span class="lever"></span>ON</label> -->
                                        </div>
                                    </div>
                                    <small class="text-danger">{{ $errors->first('is_latest') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('is_futured') ? ' has-error' : '' }}">
                                    <div class="col-sm-3">
                                        <div class="">
                                            <label> @lang('language.isFutured') </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="switch">
                                            <label>
                                                @lang('language.no')
                                                    {!! Form::checkbox('is_futured',null) !!}
                                                    <span class="lever" ></span>
                                                @lang('language.yes')
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-danger">{{ $errors->first('is_futured') }}</small>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('attribute') ? ' has-error' : '' }}">
                                <label for="">@lang('language.productImage')</label>
                                    <?php $required = 'required'; ?>
                                    @if(count($product->product_other_image) > 0)
                                        @foreach ($product->product_other_image as $key => $value)
                                        <?php $required = ''; ?>
                                        <div class="imageBox">
                                            <div id="ab_{{$key}}">
                                                <img id="previewimg" src="{{$value}}"/>
                                                <img id="img" src="/stop.png" alt="delete" onclick="removeImage({{$key}}, '{{$value}}')">
                                            </div>
                                        </div>                                        
                                        @endforeach
                                    @endif
                                    <div id="filediv">
                                        <!-- <input name="file[]" type="file" id="file"/> -->
                                        <input type="file" id="file" name="product_image[]" accept=".gif, .jpg, .png" {{$required}}>
                                        
                                    </div>                                    
                                    <button type="button" class="btn btn-warning" id="add_more">@lang('language.addMoreImage')</button>
                                </div>
                            </div>
                        </div>

            <div class="card">
                <div class="header">
                <h2>@lang('language.productAlert') @lang('language.attributes')</h2>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary add_more_button pull-right" >@lang('language.addValue')</button>
                    </div>
                </div>
                <div class="body">
                    <!-- start -->                    
                    <div class="row clearfix">
                            @foreach ($attributes as $key => $value)
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="form-control" name="attribute_0[]">
                                            <option value="">@lang('language.select') {{ app()->getLocale() == 'ar' ? $value->attribute_arabic : $value->attribute }}</option>
                                            @foreach ($value->childAttribute as $keys => $values)
                                            <?php 
                                                $selected = '';
                                                if ($product->getChildProduct[0]->child_attribute_ids) {
                                                    $a = explode(',', $product->getChildProduct[0]->child_attribute_ids);
                                                    foreach ($a as $keya => $valuea) { if ($valuea == $values->id){$selected = 'selected="selected"';} }
                                                }
                                            ?>
                                                <option value="{{$values->id}}" {{$selected}}>{{$values->value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">                                
                                    <div class="form-line">
                                        {!! Form::number('price_0', $product->getChildProduct[0]->price ,['class'=>'form-control', 'placeholder' => __('language.price'), 'min' => 0, 'required' => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                        {!! Form::number('sale_price_0', $product->getChildProduct[0]->sale_price ,['class'=>'form-control', 'placeholder' => __('language.salePrice'), 'min' => 0]) !!}
                                    </div>
                                </div>
                            </div>

                         
                            
                        </div>
                        <!-- end -->
                </div>
            </div>


            <!-- for muliple attributes -->
            <div class="input_fields_container">
            </div>
            
            <div class="card">
                <div class="header">
                    <h2>@lang('language.productAlert') @lang('language.specification')</h2>
                </div>
                <div class="body">
                    <!-- start -->                    
                    <div class="row clearfix">
                        <div class="col-sm-5">
                            <div class="form-group{{ $errors->has('key_0') ? ' has-error' : '' }}">
                                <div class="form-line">
                                {!! Form::text('key_0', isset($product->getProductSpecification[0]) ? $product->getProductSpecification[0]->key : null,['class'=>'form-control', 'placeholder' => __('language.key')]) !!}
                                </div>
                                <small class="text-danger">{{ $errors->first('key_0') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group{{ $errors->has('value_0') ? ' has-error' : '' }}">
                                <div class="form-line">
                                {!! Form::text('value_0', isset($product->getProductSpecification[0]) ? $product->getProductSpecification[0]->value : null,['class'=>'form-control', 'placeholder' => __('language.value')]) !!}
                                </div>
                                <small class="text-danger">{{ $errors->first('value_0') }}</small>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary add_more_button_specification pull-right" >@lang('language.addValue')</button>
                        </div>
                </div>
                         
                            
                        </div>
                        <!-- end -->
                        <!-- for multiple specification -->
                        <div class="input_fields_container_specification">
                        </div>
                </div>
            </div>


            <div class="row clearfix">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary pull-right btn_save">@lang('language.update')</button>
                    <!-- <button type="reset" class="btn blue_btn">@lang('language.reset')</button> -->
                </div>
            </div>
            <!-- removed id store to this input hidden field -->
            <input type="hidden" name="removeIds" value="" id="removeIds">
            </div>
            <input type="hidden" name="removeImages" value="" id="removeImages">

            <input type="hidden" name="removeSpecification" value="" id="removeSpecification">
            {!! Form::close() !!}
            <!-- card End -->
        </div>
    </div>
</div>
<script>
function onChangeAttribute(e) {
    // console.log(e.target)
  if ($("#"+e.id).val() != 'null') {
    // get attribute values from database
    var arrayFromPHP = <?php echo json_encode($childAttributes) ?>;
    // create select element
    var selectObj = $('<select class="form-control" name="value_0"></select>');
    // loop for filter by attribute id and appent to the select element
    $.each(arrayFromPHP, function (i, elem) {
        // do your stuff
        if(elem.attribute_id == $("#"+e.id).val()) {
            selectObj.append('<option value="'+elem.id+'">'+elem.value+'</option>')
        }
    });
    $('#selectValue_0').hide();
    $("#result-box_0").html(selectObj);
    // console.log($('#value'))
  }
}

function onChangeAttribute2(e, id) {
    if ($("#"+e.id).val() != 'null') {
        // get attribute values from database
        var arrayFromPHP = <?php echo json_encode($childAttributes) ?>;
        // create select element
        var selectObj = $('<select class="form-control" name="value_'+id+'"></select>');
        // loop for filter by attribute id and appent to the select element
        $.each(arrayFromPHP, function (i, elem) {
            // do your stuff
            if(elem.attribute_id == $("#attribute_"+id).val()) {
                selectObj.append('<option value="'+elem.id+'">'+elem.value+'</option>')
            }
        });
        // $('#selectValue_0').hide();
        $("#result-box_"+id).html(selectObj);
    }
}
$(document).ready(function() {
    var max_fields_limit = 100; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    var y = 1; //initialize counter for text box
    var removeArray = []
    var removeSpecArray = []
    
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if (x < max_fields_limit) { //check conditions
            $('.input_fields_container').append('<div class="card"> <div class="header"> <h2>@lang('language.productAlert') @lang('language.attributes')</h2><div class="form-group"> <button type="button" class="btn btn-danger remove_field add_more_button pull-right" >@lang('language.removeValue')</button> </div> </div> <div class="body"> <div class="row clearfix"> <?php foreach ($attributes as $key => $value){?> <div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <select class="form-control" name="newattribute_'+x+'[]"> <option value=""> @lang('language.select') <?php echo app()->getLocale() == 'ar' ? $value->attribute_arabic : $value->attribute; ?></option> <?php foreach ($value->childAttribute as $keys => $values) { ?> <option value="{{$values->id}}">{{$values->value}}</option> <?php } ?> </select> </div> </div> </div> <?php } ?><div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <input class="form-control" placeholder="@lang('language.price')" name="price_'+x+'" type="number" min="0" required> </div> </div> </div><div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <input class="form-control" placeholder="@lang('language.salePrice')" name="sale_price_'+x+'" min="0" type="number"> </div> </div> </div> </div> </div></div> </div>'); //add input field
            x++;
        }

    });
    $('.input_fields_container').on("click",".remove_field", function(e) { //user click on   remove text links
        var conf = confirm("<?php echo __('language.deleteMessage'); ?>")
        if(conf) {
            removeArray.push(e.target.id)
            $('#removeIds').val(removeArray)
                e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        }
    })

    $('.add_more_button_specification').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(y < max_fields_limit){ //check conditions
            $('.input_fields_container_specification').append('<div class="row clearfix"><div class="col-sm-5"><div class="form-group"><div class="form-line"><input class="form-control" placeholder="@lang('language.key')" name="key_'+y+'" type="text"></div><small class="text-danger"></small></div></div><div class="col-sm-5"><div class="form-group"><div class="form-line"><input class="form-control" placeholder="@lang('language.value')" name="value_'+y+'" type="text"></div><small class="text-danger"></small></div></div><div class="col-sm-2"><div class="form-group"><button type="button" class="btn btn-danger remove_field_spec add_more_button_specification pull-right" >@lang('language.removeValue')</button></div></div></div>');
            y++;
        }

    });
        $('.input_fields_container_specification').on("click",".remove_field_spec", function(e){ //user click on remove text links
            var conf = confirm("<?php echo __('language.deleteMessage'); ?>")
            if(conf) {
                removeSpecArray.push(e.target.id)
                $('#removeSpecification').val(removeSpecArray)
                    e.preventDefault(); $(this).parent().parent().parent().remove(); y--;
            }
        })

    var contChild = <?php echo count($product->getChildProduct) ?>;
    if (contChild > 1) {
        @foreach($product->getChildProduct as $keyM => $valueM)

        var key = <?php echo $keyM ?>;
        if (key == x) {
            $('.input_fields_container').append('<div class="card"> <div class="header"> <h2>@lang('language.productAlert') @lang('language.attributes')</h2> <div class="form-group"> <button type="button" class="btn btn-danger remove_field add_more_button pull-right" id="{{$valueM->id}}" >@lang('language.removeValue')</button> </div> </div> <div class="body"> <div class="row clearfix"> <?php foreach ($attributes as $key => $value){?> <div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <select class="form-control" name="attribute_'+x+'[]" <?php echo $selected; ?>> <option value=""> @lang('language.select') <?php echo app()->getLocale() == 'ar' ? $value->attribute_arabic : $value->attribute; ?></option> <?php foreach ($value->childAttribute as $keys => $values) { ?><?php $selected = ''; if ($product->getChildProduct[$keyM]->child_attribute_ids) {$a = explode(',', $product->getChildProduct[$keyM]->child_attribute_ids);if (count($a) > 0) foreach ($a as $keya => $valuea) { if ($valuea == $values->id){$selected = 'selected="selected"';} }} ?> <option value="{{$values->id}}" <?php echo $selected;?>>{{$values->value}}</option> <?php } ?> </select> </div> </div> </div> <?php } ?><div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <input class="form-control" placeholder="@lang('language.price')" name="price_'+x+'" type="number" min="0" value="{{$valueM->price}}" required> </div> </div> </div><div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <input class="form-control" placeholder="@lang('language.salePrice')" value="{{$valueM->sale_price}}" name="sale_price_'+x+'" type="number" min="0"> </div> </div> </div> </div></div> </div>'); //add input field
            x++;
        }
        @endforeach
    }

        var contSpec = <?php echo count($product->getProductSpecification) ?>;
        if (contSpec > 1) {
            @foreach($product->getProductSpecification as $keyKV => $valueKV)
                var key = <?php echo $keyKV ?>;
                if (key == y) {
                    $('.input_fields_container_specification').append('<div class="row clearfix"><div class="col-sm-5"><div class="form-group"><div class="form-line"><input class="form-control" placeholder="@lang('language.key')" name="key_'+y+'" value="{{$valueKV->key}}" type="text" ></div><small class="text-danger"></small></div></div><div class="col-sm-5"><div class="form-group"><div class="form-line"><input class="form-control" placeholder="@lang('language.value')" name="value_'+y+'" type="text"  value="{{$valueKV->value}}"></div><small class="text-danger"></small></div></div><div class="col-sm-2"><div class="form-group"><button type="button" class="btn btn-danger remove_field_spec add_more_button pull-right" id="{{$valueKV->id}}">@lang('language.removeValue')</button></div></div></div>');
                    y++;
                }
                @endforeach
        }
});
</script>
<script>
    var abc = 0; // Declaring and defining global increment variable.
    var removeImagesArray = []
    $(document).ready(function() {
        $('#add_more').hide(); // hide add more product image button on click
        //  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
        $('#add_more').click(function() {
            $(this).before($("<div/>", {
                id: 'filediv'
            }).fadeIn('slow').append($("<input/>", {
                name: 'product_image[]',
                type: 'file',
                id: 'file',
                required: true
            }), $("<br/><br/>")));
            $('#add_more').hide(); // hide add more product image button on click
        });
        // Following function will executes on change event of file input to select different file.
        $('body').on('change', '#file', function() {
            if (this.files && this.files[0]) {
                abc += 1; // Incrementing global variable by 1.
                var z = abc - 1;
                var x = $(this).parent().find('#previewimg' + z).remove();
                $(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src=''/></div>");
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $(this).hide();
                $("#abcd" + abc).append($("<img/>", {
                    id: 'img',
                    src: "{{URL::asset('stop.png')}}",
                    alt: 'delete'
                }).click(function() {
                    $(this).parent().parent().remove();
                }));
            }
            $('#add_more').show(); // show add more product image button on click
        });
        // To Preview Image
        function imageIsLoaded(e) {
            $('#previewimg' + abc).attr('src', e.target.result);
        };
        $('#upload').click(function(e) {
            var name = $(":file").val();
            if (!name) {
                alert("First Image Must Be Selected");
                e.preventDefault();
            }
        });
    });
function removeImage (key, value) {
        removeImagesArray.push(value)
        $('#removeImages').val(removeImagesArray)
        $('#ab_'+ key).remove();
}
</script>
<script>
        CKEDITOR.replace( 'article-ckeditor' );
        CKEDITOR.replace( 'article-ckeditor1' );
        
    </script>
@endsection
