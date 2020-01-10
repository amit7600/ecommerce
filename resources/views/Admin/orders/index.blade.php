@extends('layouts.app')

@section('content')
<div class="container-fluid">
            <!-- <div class="block-header">
                <h2>@lang('language.orders')</h2>
            </div> -->
 <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            @include('Admin.errors.errorMessage')
            <div class="card">
                <div class="header">
                    <h2>@lang('language.orders')
                    <!-- <a href="{{URL::to('products/create')}}" class="pull-right btn btn-primary">@lang('language.create')</a> -->
                    </h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>@lang('language.id')</th>
                                    <th>@lang('language.customerName')</th>
                                    <th>@lang('language.orderDate')</th>
                                    <th>@lang('language.paymentMethod')</th>
                                    <th>@lang('language.subTotal')</th>
                                    <th>@lang('language.tax')</th>
                                    <th>@lang('language.discount')</th>
                                    <th>@lang('language.grandTotal')</th>
                                    <th>@lang('language.status')</th>
                                    <th>@lang('language.action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }} </td>
                                        <td>{{ $order->users->first_name. ' ' . $order->users->last_name }}</td>
                                        <td>{{ $order->ordered_at }}</td>
                                        <td>{{ $order->payment_method = 1 ? 'Cash On Delivery' : 'Card' }}</td>
                                        <td>{{ $order->sub_total }}</td>
                                        <td>{{ $order->tax_collected }}</td>
                                        <td>{{ $order->discount }}</td>
                                        <td>{{ $order->grand_total }}</td>
                                        <td id="statusChange">{{ ucfirst($order->status) }}</td>
                                        <td width="15%" style="text-align: center;">
                                            <select class="form-control" id="status" onchange="onChageSelect('<?php echo $order->id ?>')">
                                                <option value="ordered" <?php if ($order->status == 'ordered') {
	echo "selected";
}
?>> @lang('language.orderd') </option>
                                                <option value="in_progress" <?php if ($order->status == 'in_progress') {
	echo "selected";
}
?>> @lang('language.inProgress') </option>
                                                <option value="shipped" <?php if ($order->status == 'shipped') {
	echo "selected";
}
?>> @lang('language.shipped') </option>
                                                <option value="completed" <?php if ($order->status == 'completed') {
	echo "selected";
}
?>> @lang('language.complited') </option>
                                                <option value="cancelled" <?php if ($order->status == 'cancelled') {
	echo "selected";
}
?>> @lang('language.cancelled') </option>
                                            </select>
                                            <a href="{{ route('orders.edit', ['id' => $order->id]) }}"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="tool_tip"><i class="material-icons">edit</i></a>
                                            <!-- <?php $route = URL::to('orders/' . $order->id);
$token = csrf_token();
?>
                                            <a href="#" class="tool_tip"><i class="material-icons "
                                                onclick="deleteValue('<?php echo $route; ?>', this)"><i
                                                    class="material-icons iconDelete" data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-original-title="{{ __('language.delete')}}">delete_forever</i></i></a> -->


                                                    <button type="button" id="modal_id" data-toggle="modal" class="waves-effect modal_id btn_showdetail" data-target="#defaultModal-{{ $order->id }}" >Show detail</button>

                                        </td>
<div class="modal fade" id="defaultModal-{{ $order->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Order Details</h4>
                        </div>
                        <div class="modal-body">
                            <strong>Customer Name</strong> : {{ $order->users->first_name. ' ' . $order->users->last_name }}<br>
                            <strong>Order Date</strong> : {{ $order->ordered_at }} <br>
                            <strong>Product detail</strong>
                            <br>
                            <br>
                            @foreach($order->orderDetails as $key => $product)

                            <strong>Item </strong> : {{ $key+1 }} <br>
                            <strong>Product Name</strong> : {{ $product->childProducts->getProduct->product_name }} <br>
                            <strong>Product Code</strong> : {{ $product->childProducts->getProduct->product_code }} <br>
                            <strong>Product Description</strong> : {!! $product->childProducts->getProduct->product_description !!} <br>
                            <strong>Product Quantity</strong> : {{ $product->quantity }} <br>
                            <strong>Product Price</strong> : {{ $product->childProducts->price }} <br>
                            <strong>Product Sale Price</strong> : {{ $product->childProducts->sale_price }} <br>
                            <br><br><br>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal" id="modal_close">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
@endforeach
                                    </tr>

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
$('#modal_close').on('click',function(){
    $('#defaultModal').modal('hide');
})
    function confirmDelete() {
        return confirm("<?php echo __('language.deleteMessage'); ?>");
    }

    function onChageSelect (orderId) {
        $('#errorAlertMessage').empty('')
        $conf = confirm("<?php echo __('language.alertMessage.changeStatus'); ?>")
        if($conf) {
            $.ajax({
                type: "POST",
                url: '/orders',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": $('#status').val(),
                    "orderId": orderId,
                },
                success: function(msg){
                    str = $('#status').val()
                    var res = str.replace("_", " ");
                    $('#statusChange').text(res)

                    $('#errorAlertMessage').append('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+msg.success+'</div>');
                },
                error: function(request,msg,error) {
                    $('#errorAlertMessage').append('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+error+'</div>');
                }
            })
        }
    }
</script>
@endsection