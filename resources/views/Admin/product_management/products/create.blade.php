@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.product')</h2>
            </div> -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!-- card Start -->
            {!! Form::open(['route' => 'products.store', 'files'=> true, 'id' => 'form']) !!}
            <div class="card">
                <div class="header">
                    <h2>@lang('language.add') @lang('language.productAlert')</h2>
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
                                    <div class="form-line">
                                    {!! Form::textarea('product_description', null ,['class'=>'form-control', 'placeholder' => __('language.productDescription'), 'rows'=>3, 'required' => true, 'id' => 'article-ckeditor']) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('product_description') }}</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('product_description_arabic') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::textarea('product_description_arabic', null ,['class'=>'form-control', 'placeholder' => __('language.productDescriptionArabic'), 'rows'=>3, 'id' => 'article-ckeditor1']) !!}
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
                                    {!! Form::select('category', $category, null ,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.category'), 'required' => true]) !!}
                                    </div>
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                </div>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('tax') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                    {!! Form::select('tax', $tax, null ,['class'=>'form-control', 'placeholder' => __('language.select').' '.__('language.tax')]) !!}
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
                                    <div id="filediv">
                                        <!-- <input name="file[]" type="file" id="file"/> -->
                                        <input type="file" id="file" name="product_image[]" accept=".gif, .jpg, .png" required>
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
                                                <option value="{{$values->id}}">{{$values->value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">                                
                                    <div class="form-line">
                                        {!! Form::number('price_0', null ,['class'=>'form-control', 'placeholder' => __('language.price'), 'min' => 0, 'required' => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                    <div class="form-line">
                                        {!! Form::number('sale_price_0', null ,['class'=>'form-control', 'placeholder' => __('language.salePrice'), 'min' => 0]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end -->
                    <div>
                
                    </div>
                </div>
            </div>


            <!-- for multiple attributes -->
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
                                {!! Form::text('key_0', null,['class'=>'form-control', 'placeholder' => __('language.key')]) !!}
                                </div>
                                <small class="text-danger">{{ $errors->first('key_0') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group{{ $errors->has('value_0') ? ' has-error' : '' }}">
                                <div class="form-line">
                                {!! Form::text('value_0', null,['class'=>'form-control', 'placeholder' => __('language.value')]) !!}
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
                    <button type="submit" class="btn btn-primary pull-right btn_save">@lang('language.save')</button>
                    <button type="reset" class="btn blue_btn pull-right spacebetween btn_edit">@lang('language.reset')</button>
                </div>
            </div>
            </div>
            {!! Form::close() !!}
            <!-- card End -->
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var max_fields_limit      = 100; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    var y = 1;
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
        $('.input_fields_container').append('<div class="card"> <div class="header"><h2>@lang('language.productAlert') @lang('language.attributes')</h2> <div class="form-group"> <button type="button" class="btn btn-danger remove_field add_more_button pull-right" >@lang('language.removeValue')</button> </div> </div> <div class="body"> <div class="row clearfix"> <?php foreach ($attributes as $key => $value){?> <div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <select class="form-control" name="attribute_'+x+'[]"> <option value="">@lang('language.select') <?php echo app()->getLocale() == 'ar' ? $value->attribute_arabic : $value->attribute; ?></option> <?php foreach ($value->childAttribute as $keys => $values) { ?> <option value="{{$values->id}}">{{$values->value}}</option> <?php } ?> </select> </div> </div> </div> <?php } ?><div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <input class="form-control" placeholder="@lang('language.price')" name="price_'+x+'" type="number" min="0" required> </div> </div> </div><div class="col-sm-3"> <div class="form-group"> <div class="form-line"> <input class="form-control" placeholder="@lang('language.salePrice')" name="sale_price_'+x+'" type="number" min="0"> </div> </div> </div> </div> </div></div> </div>'); //add input field
            x++;
        }

        $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
            e.preventDefault(); $(this).parent().parent().parent().remove(); x--;
        })
    });

    $('.add_more_button_specification').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            $('.input_fields_container_specification').append('<div class="row clearfix"><div class="col-sm-5"><div class="form-group"><div class="form-line"><input class="form-control" placeholder="@lang('language.key')" name="key_'+y+'" type="text"></div><small class="text-danger"></small></div></div><div class="col-sm-5"><div class="form-group"><div class="form-line"><input class="form-control" placeholder="@lang('language.value')" name="value_'+y+'" type="text"></div><small class="text-danger"></small></div></div><div class="col-sm-2"><div class="form-group"><button type="button" class="btn btn-danger remove_field add_more_button pull-right" >@lang('language.removeValue')</button></div></div></div>');
            y++;
        }

        $('.input_fields_container_specification').on("click",".remove_field", function(e){ //user click on remove text links
            e.preventDefault(); $(this).parent().parent().parent().remove(); y--;
        })
    });


});
</script>

<script>
    var abc = 0; // Declaring and defining global increment variable.
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
</script>
<script>
    CKEDITOR.replace( 'article-ckeditor' );
    CKEDITOR.replace( 'article-ckeditor1' );
</script>
@endsection
