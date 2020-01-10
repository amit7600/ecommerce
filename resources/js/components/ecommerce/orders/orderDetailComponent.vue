<template>
	<div>
		<h2 class="fs-title">
            <img src="/ecommerce/img/title_icon1.png" alt="" title=""> 
              {{ $t('myOrders') }}
            <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
            <router-link to="/myAccount/myOrders" class="create_btn pull-right" > &lt; {{ $t('back') }}</router-link>
        </h2>
        <div class="my_orders my_profile" v-if="orderDetails != ''">
        	<div class="detail_address_view">
				<div class="item">
	                <div class="card">
	                    <div class="content_ship_address">
	                        <h4><b>	{{ $t('orderId') }}: </b> <i>{{ orderDetails.order_number }}</i> </h4>
	                        <h4><b> {{ $t('orderDate') }}:</b> <i>{{ orderDetails.ordered_at }}</i></h4>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="content_ship_address" style="padding-left:0px; padding-right:0px;">
                <div class="form_title">
                    <h2 class="fs-title"> {{ $t('shippingAddress') }}</h2>
               	</div>
               	<div class="table-responsive">
	                <table class="table table-striped confirm">
	                    <tbody>
	                        <tr>
	                            <td style="width:30%">{{ $t('name') }}</td>
	                            <td>{{ orderDetails.users.first_name }} {{ orderDetails.users.last_name }}</td>
	                        </tr>
	                        <tr>
	                            <td>{{ $t('address') }}</td>
	                            <td>{{ orderDetails.shippingAddress.address }}</td>
	                        </tr>
	                        <tr>
	                            <td>{{ $t('city') }}</td>
	                            <td>{{ orderDetails.shippingAddress.city }}</td>
	                        </tr>
	                        <tr>
	                            <td>{{ $t('mobile') }}</td>
	                            <td>{{ orderDetails.shippingAddress.mobile_number }}</td>
	                        </tr>
	                        <tr>
	                            <td>{{ $t('addressType') }}</td>
	                            <td>{{ orderDetails.shippingAddress.address_type }}</td>
	                        </tr>
	                        <tr>
	                            <td>{{ $t('landmark') }}</td>
	                            <td>{{ orderDetails.shippingAddress.landmark }}</td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>
            </div>
            <div class="text-left">
            	<div class="form_title">
                    <h2 class="fs-title"> {{ $t('productInfo') }} </h2>
               	</div>
	            <div class="table-responsive">
	                <table border="1" class="table table-striped table-hover order_place">
	                    <thead>
	                        <tr>
	                            <th class="text-center">{{$t('product')}}</th>
	                            <th>{{$t('name')}}</th>
	                            <th class="text-center">{{$t('quantity')}}</th>
	                            <th class="text-center">{{$t('price')}}</th>
	                            <th class="text-center">{{$t('total')}}</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr v-for="(order, index) in orderDetails.orderDetails" :key="index">
	                            <td style="width:20%">
	                                <div class="media">
	                                    <a class="thumbnail pull-left" href="#"> 
	                                    	<img class="media-object" :src="order.child_products.get_product.product_other_image[0]" > 
	                                   	</a>
	                                </div>
	                            </td>
	                            <td class="table_order" style="width:40%">
	                                <h4><a href="#">{{ $i18n.locale == 'ar' ? order.child_products.get_product.product_name_arabic : order.child_products.get_product.product_name }}</a></h4>
	                                <!-- <h5> by <a href="#">Brand name</a></h5> -->
	                            </td>
	                            <td class="Quanity" style="text-align: center ;width:10%">
	                                <strong>{{ order.quantity }}</strong>
	                            </td>
								
	                            <td class="text-center" style="width:10%"><strong>{{ $t('aed') }} {{ order.sub_total }}</strong></td>
	                            <td class="text-center" style="width:10%"><strong>{{ $t('aed') }} {{ order.grand_total }}</strong></td>
	                        </tr>
	                    </tbody>
	                </table>
	            </div>

                <div class="order_summary_container">
                    <div class="coupon_code">
                        <p>{{ $t('subTotal') }}
                            <span class="amount">{{ $t('aed') }} {{ orderDetails.sub_total }}</span></p>
                        <p>{{ $t('shippingCharge') }}
                            <span>{{ $t('freeShipping') }}</span></p>
                        <p>{{ $t('discount') }}
                            <span class="amount"> {{ $t('aed') }} {{ orderDetails.discount }}</span></p>
						<p>{{ $t('paymentMethod') }}
                        	<span> {{ orderDetails.payment_method == '1' ? 'COD' : 'CARD' }}</span></p>
                        <p>{{ $t('total') }}
                            <span class="amount">{{ $t('aed') }} {{ orderDetails.grand_total }}</span></p>
                    </div>
                </div>
            </div>
	    </div>
	</div>
</template>

|<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
export default {
	computed: {
		...mapState([
			'myOrders'
		])
	},
	data () {
		return {
			orderDetails: '',

		}
	},
	created () {
		this.ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS('myOrders')
		self = this
		setTimeout( function () {
			self.orderDetailsData()
		}, 1000)
	},
	methods: {
		...mapActions([
			'ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS',
		]),
		orderDetailsData () {
			axios.get('/api/orders/' + this.$route.params.id, {
				headers: {
					Authorization: this.$session.get('accessToken')
				}
			})
			.then (response => {
				this.orderDetails = response.data.data[0]
			})
		}
	}
}	
</script>