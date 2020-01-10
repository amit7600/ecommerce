<template>
    <div>
        <div class="product-big-title-area cart_background">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>{{ $t('shoppingCart') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Page title area -->
    
     <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
              <div  class="cart_body"  v-if="cartList.length > 0" >
                  <div class="cart_item"  v-for="(cart, index) in cartList" :key="index">
                        <div class="image_container">
                            <a @click="$parent.setImage(cart.productData.product_other_image[0], cart.productId)"><img  alt="poster_1_up" class="shop_thumbnail" :src="cart.productData.product_other_image[0]"></a> 
                        </div>
                        <div class="detail_container">
                            <h2><a @click="$parent.setImage(cart.productData.product_other_image[0], cart.productId)">
                                {{getLocale == 'ar' ? cart.productData.product_name_arabic : cart.productData.product_name }}
                                </a>
                            </h2>  
                            
                            <p v-html="getLocale == 'ar' ? cart.productData.product_description_arabic : cart.productData.product_description"></p>
                        </div>
                        <div class="prooduct_price"> 
                            <h3 class="price_tag">{{ $t('price') }} : <span class="price">{{ $t('aed') }} {{cart.price }}</span></h3>
                            <div class="product_quantity buttons_added">
                                <input type="button" class="minus quantity-left-minus btn btn-danger btn-number" value="-" @click="$parent.removeFromCart(cart.productId)">

                                <input type="number" size="4" class="input-text qty txt" title="Qty" :value="cart.quantity"  @input="changeCart(cart.productId, cart.price, index)" min="1" step="1" :id="'quantity_'+index">
                                
                                <input type="button" class="plus quantity-right-plus btn btn-success btn-number" value="+" @click="$parent.addToCart(cart.productId, cart.price)">
                            </div>
                            <div class="product_subtotal">
                                <h3 class="price_tag">{{ $t('totalPrice') }} : <span class="price ">{{ $t('aed') }} {{ cart.quantity * cart.price }}</span></h3>
                            </div>
                        </div>
                        <div class="product_Remove">
                            <h3 class="price_tag" ><a  @click="$parent.removeCartItem(index, cart.productId)"><i class="fas fa-trash-alt"></i></a></h3>
                        </div>
                  </div>

                  <!-- start payment gateway image -->
                           <div class="payment_container">
                               <div class="payment_bg">
                                   <ul>
                                       <li><img src="/ecommerce/img/visa_card.png" alt=""></li>
                                       <li><img src="/ecommerce/img/mastercard.png" alt=""></li>
                                       <li><img src="/ecommerce/img/discover_card.png" alt=""></li>
                                       <li><img src="/ecommerce/img/american_experess.png" alt=""></li>
                                       <li><img src="/ecommerce/img/paypal.png" alt=""></li>
                                   </ul>
                               </div>
                           </div>
                  <!-- End payment gateway image -->
                   
                   <!-- Start card total -->
                      <div class="order_summary_container order_item">
                          <div class="coupon_code">
                              <h2>{{ $t('orderSummary') }}</h2>
                          </div>
                          <div class="coupon_code">
                              <form action="" class="coupon">
                                  <div class="coupon_apply">
                                     <input type="text" :placeholder="$t('couponCode')" id="coupon_code" :aria-label="$t('couponCode')" :class="{'order_coupon': true, 'alert-danger': errors.first('coupon_code')}" value="" name="coupon_code" v-model="couponCodeModel" v-validate="'required'" data-vv-as="Coupon Code"> 
                                     <button class="pull_right" @click="applyCoupon" v-if="!isCouponCode">
                                        {{ $t('applyCoupon') }}
                                     </button>
                                     <button class="pull_right" @click="removeCouponCode" v-if="isCouponCode">
                                        {{ $t('removeCoupon') }}
                                     </button>
                                     <span style="color: red;" v-if="couponCodeRequired">{{ couponCodeRequiredMessage }}</span>
                                     <span style="color: red;" v-if="couponErrorMessage != ''"> {{couponErrorMessage}} </span>
                                  </div>
                              </form>

                          </div>
                          <div class="coupon_code">
                               <p>{{ $t('cartSubTotal') }} 
                                <span class="amount">{{ $t('aed') }} {{ subTotal ? subTotal : CART_TOTAL_PRICE }}</span>
                               </p>
                               
                               <p>{{ $t('shippingCharge') }}
                                    <span>{{ $t('freeShipping') }}</span>
                               </p>
                               <p>{{ $t('discount') }}
                                    <span class="amount"> {{ $t('aed') }} {{ discount }}</span>
                               </p>
                              
                               <p>{{ $t('total') }}
                                  <span class="amount">{{ $t('aed') }} {{ grandTotal ? grandTotal : CART_TOTAL_PRICE }}</span>
                               </p> 
                          </div>
                          <div class="coupon_code">
                              <button class="checkout" @click="checkOut"> {{ $t('checkOut') }} </button>
                              <button class="checkout" @click="startShopping"> {{ $t('shopMore') }} </button>
                          </div>
                      </div>
               <!-- End card total -->
                </div>
                <div v-else>
                    <div class="product-content-right">
                        <div class="else_cart_empty">
                            <img src="/img/empty-cart.png" >
                            <div class="empty_cart_btn">
                            <button type="button" class="btn btn-primary" @click="startShopping"> {{ $t('startShopping') }} </button>
                            </div>
                        </div>
                    </div>
                </div> 
        </div>
    </div>
    </div>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from 'vuex';
export default {
    computed: {
        ...mapState([
            'productCount',
            'products',
            'cartList',
            'getLocale',
            'couponCode',
            'subTotal',
            'discount',
            'tax',
            'shippingCharge',
            'grandTotal',
            'couponErrorMessage',
        ]),
        ...mapGetters([
            'PRODUCT_FILTER',
            'CART_TOTAL_PRICE',
        ])
    },
    data () {
        return {
            couponCodeModel: this.$session.has('couponCode') ? this.$session.get('couponCode') : '',
            couponCodeRequired: false,
            isCouponCode: false,
            couponCodeRequiredMessage: '',
        }
    },
    created () {
        this.setActiveClass();
    },
    mounted() {
        // if the coupon code is find
        this.applyExistCoupon()
    },
    methods: {
        ...mapActions([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'APPLY_COUPON',
            'ACTION_CALCULATE_TOTAL',
            'ACTION_DISCOUNT_RESET',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
        ]),
        setActiveClass () {
            this.ACTION_ACTIVE_CLASS('cart')
        },
        changeCart (productId, price, index) {
            var cartValue = document.getElementById('quantity_'+ index ).value
            if(cartValue > 0) {
                this.$parent.addToCart(productId, price, parseInt(cartValue))
            } else {
                this.$parent.removeFromCart(productId)
                alert('Please enter value greater than zero.')
            }

        },
        applyCoupon (e) {
            // apply coupon code
            this.couponCodeRequiredMessage = ''
            this.$store.state.couponErrorMessage = ''
            e.preventDefault();
            this.$validator.validateAll().then(result => {
                if(result) {
                    if(this.couponCodeModel != '') {
                        axios.post('/api/getCoupon', {
                            couponCode: this.couponCodeModel
                        })
                        .then(response => {
                            this.$session.set('couponCode', this.couponCodeModel)
                            this.$session.set('couponData', response.data.data)
                            this.APPLY_COUPON({couponCode:this.couponCodeModel, couponData: response.data.data})
                                this.isCouponCode = true
                            // if (this.couponErrorMessage == '') {
                            // }
                            this.ACTION_PUSH_SUCCESS(this.$t('successCouponCode'))
                        })
                        .catch(errorResponse => {
                            this.couponCodeRequired = true
                            this.couponCodeRequiredMessage = this.$t('coupon') + ' ' + this.$t('notFound');
                            this.ACTION_PUSH_ERROR(this.couponCodeRequiredMessage)
                        })
                    } else {
                        this.couponCodeRequired = true
                        this.couponCodeRequiredMessage = "This field is required";
                    }
                }
            });
            
        },
        applyExistCoupon () {
            var self = this;
            setTimeout( function() {
                if(self.$session.has('couponCode') && self.$session.get('couponCode')) {
                    self.APPLY_COUPON({couponCode:self.$session.get('couponCode'), couponData: self.$session.get('couponData')})
                    if (self.couponErrorMessage == '') {
                        self.isCouponCode = true
                    }
                } else {
                    self.ACTION_CALCULATE_TOTAL({cartTotalPrice: 0})
                }
            }, 1000);
        },
        removeCouponCode (e) {
            e.preventDefault();
            this.couponCodeModel = ''
            this.$session.remove('couponCode')
            this.$session.remove('couponData')
            this.isCouponCode = false
            this.$store.state.couponErrorMessage = ''
            this.ACTION_CALCULATE_TOTAL({cartTotalPrice: 0})
            this.ACTION_DISCOUNT_RESET()
            this.ACTION_PUSH_SUCCESS(this.$t('successCouponCodeRemoved'))
        },
        checkOut (e) {
            // check out
            e.preventDefault();
            this.$router.push('/checkout')
        },
         startShopping () {
            //  Go to home and set active class
            this.$router.push('/')
            this.ACTION_ACTIVE_CLASS('/')
         },
    }
}
</script>

<style>

</style>
