<template>
    <div>
        <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <h2>{{ $t('orderPlaceSuccessfully') }}</h2>
                    </div>
                    <table cellspacing="0" class="shop_table">
                        <thead>
                            <tr>
                                <th class="" >{{ $t('productImage') }}</th>
                                <th class="product-name">{{$t('product')}}</th>
                                <th class="product-price">{{$t('price')}}</th>
                                <th class="product-quantity">{{$t('quantity')}}</th>
                                <th class="product-quantity">{{$t('discount')}}</th>
                                <th class="product-quantity">{{$t('paymentMethod')}}</th>
                                <th class="product-subtotal">{{$t('total')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="cart_item" v-for="(order, index) in orderDetails" :key="index">
                                <td v-if="index === 0" class="product-thumbnail" style="width: 50%;">
                                    <a ><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" :src="order.childProducts.get_product.product_other_image[0]"></a>
                                </td>
                                <td v-if="index === 0"> {{ order.childProducts.get_product.product_name }} </td>
                                <td v-if="index === 0"> {{ order.sub_total }} </td>
                                <td v-if="index === 0"> {{ order.quantity }} </td>
                                <td v-if="index === 0"> {{ order.discount }} </td>
                                <td v-if="index === 0"> {{ order.payment_method == 1 ? 'COD' : 'Card' }} </td>
                                <td v-if="index === 0"> {{ order.grand_total }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            orderDetails: [],
        }
    },
    mounted () {
        this.getLastOrder()
    },
    methods: {
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
        }
    }
}
</script>

<style>

</style>
