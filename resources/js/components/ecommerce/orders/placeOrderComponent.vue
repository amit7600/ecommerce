<template>
    <div>
        <div class="item_container" v-if="orderDetails != ''">
            <h4></h4>
            <p> Lorem ipsum dolor sit amet, nostrud nominati vis ex, essent conceptam eam ad. Cu etiam comprehensam nec. Cibo delicata mei an, eum porro legere no. Te usu decore omnium, quem brute vis at, ius esse officiis legendos cu. Dicunt voluptatum at cum. Vel et facete equidem deterruisset, mei graeco cetero labores et. Accusamus inciderint eu mea.</p>

            <div class="content_ship_address">
                <div class="form_title">
                    <h4> <img src="/ecommerce/img/title_icon1.png" alt="" title=""> {{ $t('shippingAddress') }} <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title=""></h4></div>
                
            </div>
            <div class="table-responsive">
                <table class="table table-striped confirm text-left">
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
            <div class="table-responsive">
                <table border="1" class="table table-hover order_place">
                    <thead>
                        <tr>
                            <th style="width:15%;">{{$t('product')}}</th>
                            <th>{{ $t('name') }}</th>
                            <th style="width:10%;">{{$t('quantity')}}</th>
                            <th class="text-center" style="width:10%;">{{$t('price')}}</th>
                            <th class="text-center" style="width:10%;">{{$t('total')}}</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr  v-for="(order, index) in orderDetails.orderDetails" :key="index">
                            <td style="width:15%;">
                                <div class="media">
                                    <a class="thumbnail pull-left"> <img class="media-object" :src="order.child_products.get_product.product_other_image[0]" > </a>
                                </div>
                            </td>
                            <td class="table_order">
                                <h4><a>{{getLocale == 'ar' ? order.child_products.get_product.product_name_arabic : order.child_products.get_product.product_name }}</a></h4>
                                <!-- <h5> by <a href="#">Brand name</a></h5> -->
                            </td>
                            <td class="Quanity" style="text-align: center;width:10%;">
                                {{order.quantity }}
                            </td>
                            <td style="width:10%;" class=" text-center"><strong>{{ $t('aed') }} {{order.sub_total }}</strong></td>
                            <td style="width:10%;" class=" text-center"><strong>{{ $t('aed') }} {{ order.grand_total }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="order_summary_container">
                <div class="coupon_code">
                    <h2><img src="/ecommerce/img/title_icon1.png" alt="" title=""> {{ $t('orderSummary') }} <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title=""></h2></div>
                <div class="coupon_code">
                    <p>{{ $t('subTotal') }}
                        <span class="amount">{{ $t('aed') }} {{ orderDetails.sub_total }} </span></p>
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
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
export default {
    computed: {
        ...mapState([
            'cartList',
            'getLocale',
            'couponCode',
            'subTotal',
            'discount',
            'tax',
            'shippingCharge',
            'grandTotal',
            'orderId',
        ]),
        ...mapGetters([
            'PRODUCT_FILTER',
            'CART_TOTAL_PRICE',
        ])
    },
    data () {
        return {
            orderDetails: '',
        }
    },
    created () {
        this.getOrder()
    },
    mounted() {
        // if the coupon code is find
    },
    methods: {
        ...mapActions ([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'APPLY_COUPON',
            'ACTION_CALCULATE_TOTAL',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
        ]),
        getLastOrder () {
            axios.get('/api/orders', {
                headers: {
                    Authorization:this.$session.get('accessToken')
                }
            })
            .then ( response => {
                this.orderDetails = response.data.data
            })
            .catch (errorReponse => {
                console.log(errorReponse, 'errorReponse')
            })
        },
        getOrder () {
            axios.get('/api/orders/' + this.orderId, {
                headers: {
                    Authorization:this.$session.get('accessToken')
                }
            })
            .then ( response => {
                this.orderDetails = response.data.data[0]
            })
            .catch (errorReponse => {
                console.log(errorReponse, 'errorReponse')
            })
        }
    }
}
</script>

<style>

</style>
