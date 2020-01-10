<template>
    <div>
        <!-- COD<input type="radio" name="paymentMethod" value="cod" @click="changePayment('cod')" :checked="paymentMethod == 'cod'" >
        CARD<input type="radio" name="paymentMethod" value="card" @click="changePayment('card')" :checked="paymentMethod == 'card'">
        <input type="button" @click="callParent" :value="$t('payment')"> -->
             <div id="container">
                <div class="item_payment panel panel-default">
                    <div class="header_payment">
                        <div class="form-check ">
                            <label class="form-check-label" for='cod'>
                                <input type="radio" name="paymentMethod" id="cod" value="cod" @click="changePayment('cod')" :checked="paymentMethod == 'cod'" >
                                {{ $t('pay') }} {{ $t('aed') }} {{ grandTotal ? grandTotal : CART_TOTAL_PRICE }} {{ $t('with') }} {{ $t('cod') }}
                            </label>
                        </div>
                        <div class="pad_adjust" v-if="paymentMethod == 'cod'" style="margin-top:20px;">
                            <input type="submit"  class="btn btn-warning btn-block"   @click="callParent" :value="$t('placeOrder')"/>
                        </div> 
                    </div> 
                    <div class="form-check check">
                        
                        <label class="form-check-label" for='paypal'>
                           <input type="radio" name="paymentMethod" id="paypal" value="card" @click="changePayment('card')" :checked="paymentMethod == 'card'">
                           {{ $t('pay') }} {{ $t('aed') }} {{ grandTotal ? grandTotal : CART_TOTAL_PRICE }} {{ $t('with') }} PayPal
                        </label>
                    </div>
                    <!-- <div class="cards_payment">
                        <img src="ecommerce/img/mastercard.png">
                        <img src="ecommerce/img/paypal.png">
                        <img src="ecommerce/img/visa_card.png">
                    </div> -->
                        
                    <div class="panel-body" v-if="paymentMethod == 'card'">
                        
                        <div class="form-group">
                            <label for="full_name_id" class="control-label">{{ $t('nameOnCard') }}</label>
                            <input type="text" class="form-control" id="full_name_id" name="full_name" :placeholder="$t('nameOnCard')" data-vv-name="nameOnCard" v-validate="'required'"  :class="{'alert-danger': errors.has('nameOnCard')}" />
                        </div>	

                        <div class="form-group ">
                            <label for="full_name_id" class="control-label">{{ $t('cardNumber') }}</label>
                            <input type="text" class="form-control" id="cardNumber_id" name="cardNumber" :placeholder="$t('cardNumber')" data-vv-name="cardNumber" v-validate="'required'"  :class="{'alert-danger': errors.has('cardNumber')}" />
                        </div>
                   
                       <div class="fast_last">
                        <div class="form-group">
                            <label for="street1_id" class="control-label">{{ $t('expiryDate') }}</label>
                            <input type="text" class="form-control" id="street1_id" name="expiryDate" :placeholder="$t('expiryDate')" data-vv-name="expiryDate" v-validate="'required'"  :class="{'alert-danger': errors.has('expiryDate')}" />
                            
                        </div>					
                                                
                        <div class="form-group">
                            <label for="area_id" class="control-label">{{ $t('cvv') }}</label>
                            <input type="text" class="form-control" id="area_id" name="cvv"   :placeholder="$t('cvv')" data-vv-name="cvv" v-validate="'required'"  :class="{'alert-danger': errors.has('cvv')}"  />
                        </div>	 
                       </div>  
                        <div class="pad_adjust">
                            <input type="submit"  class="btn btn-warning btn-block"  @click="callParent" :value="$t('placeOrder')"/>
                        </div> 
                 </div>
                </div>            
             </div>
          <!-- END PAYMENT CARD VIEW -->
    </div>
</template>

<script>
import {mapState, mapMutations, mapGetters, mapActions} from 'vuex';
export default {
    computed: {
        ...mapState([
            'cartList',
            'getLocale',
            'shippingAddress',
            'couponCode',
            'subTotal',
            'discount',
            'tax',
            'shippingCharge',
            'grandTotal',
        ]),
        ...mapGetters([
            'PRODUCT_FILTER',
            'CART_TOTAL_PRICE',
        ])
    },
    data () {
        return {
            paymentMethod: '',
        }
    },
    mounted() {
        // if the coupon code is find
        this.applyExistCoupon()
    },
    methods: {
        ...mapMutations([
            'SET_ORDER_ID',
            'SET_EMPTY_CART_LIST',
        ]),
        ...mapActions ([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'APPLY_COUPON',
            'ACTION_CALCULATE_TOTAL',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
        ]),
        applyExistCoupon () {
            if(this.$session.has('couponCode') && this.$session.get('couponCode')) {
                this.APPLY_COUPON({couponCode:this.$session.get('couponCode'), couponData: this.$session.get('couponData')})
                this.isCouponCode = true
            } else {
                this.ACTION_CALCULATE_TOTAL({cartTotalPrice: 0})
            }
        },
        placeOrder () {
            // order Place
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            axios.post('/api/orders', {
                cartList: this.cartList,
                getLocale: this.getLocale,
                shippingAddress: this.shippingAddress,
                couponCode: this.couponCode,
                subTotal: this.subTotal,
                discount: this.discount,
                tax: this.tax,
                shippingCharge: this.shippingCharge,
                grandTotal: this.grandTotal,
                shipingId: this.$session.get('shippingId'),
                paymentMethod: this.paymentMethod,
            })
            .then(response => {
                // set Order id
                this.SET_ORDER_ID(response.data.data.id)
                localStorage.removeItem("cart")
                this.$session.remove('shippingId')
                this.$session.remove('shippingAddress')
                this.$session.remove('couponCode')
                this.$session.remove('paymentMethod')
                this.SET_EMPTY_CART_LIST()
                // this.ACTION_PUSH_SUCCESS(this.$t('orderPlaceSuccessfully'))
                // this.$router.push('/orderSuccess')
                // this.ACTION_PUSH_SUCCESS(this.$t('orderPlaceSuccessfully'))
                // location.reload();
            })
            .catch(errorResponse => {
                console.log(errorResponse, 'error on patyment component')
            })
        },
        changePayment (method) {
            this.paymentMethod = method
        },
        callParent() {
            this.$parent.addPayment(this.paymentMethod)
            this.placeOrder()
        }
    },
}
</script>

<style>

</style>
