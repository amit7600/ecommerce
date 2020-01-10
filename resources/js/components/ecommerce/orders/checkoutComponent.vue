<template>
    <div>
        <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>{{ $t('checkOut') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Page title area -->
        <!-- MultiStep Form -->
        <div class="container" v-if="isLogin">
            <div class="">
                <div class="progress_bar">
                    <form class="progress_top">
                        <!-- progressbar -->
                        <ul class="progressbar">
                            <li @click="step = 1" :class="{'active': step == 1 || step == 2 || step == 3}">{{ $t('shippingAddress') }}</li>
                            <li @click="step == 3 ? step = 2: step = 1" :class="{'active': step == 2 || step == 3}" > {{ $t('payment') }}</li>
                            <li @click="step = 1" :class="{'active': step == 3}"> {{ $t('placeOrder') }}</li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset class="feature_product" v-if="step == 1">
                            <!-- <h3 class="fs-subtitle">Tell us something more about you</h3> -->
                            <!-- shipping address component -->
                            <ShippingAddressComponent></ShippingAddressComponent>
                        </fieldset>
                        <fieldset class="feature_product" v-if="step == 2">
                            <h2 class="fs-title">
                            <img src="/ecommerce/img/title_icon1.png" alt="" title="">
                                {{ $t('payment') }}
                            <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">                                
                                </h2>
                            <PaymentComponent></PaymentComponent>
                        </fieldset>
                        <fieldset class="feature_product" v-if="step == 3">
                            <h2 class="fs-title">
                            <img src="/ecommerce/img/title_icon1.png" alt="" title=""> {{ $t('thankYou') }}
                            <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
                            </h2>
                            <PlaceOrderComponent></PlaceOrderComponent>
                        </fieldset>
                    </form>
                </div>
            </div>    
        </div>

    <div class="container" v-else>
            <div class="col-md-6 col-md-offset-3"> 
                <form id="msform">
                     <fieldset class="login_form">
                          <h2><img src="/ecommerce/img/logo.png" alt=" " title=""></h2>
                          <h2 v-if="signUp == true" class="fs-title">{{ $t('login') }}</h2>
                          <div v-if="!signUp">
                                <div class="form-group">
                                 <label for="phone_id" class="control-label">{{ $t('firstName') }}</label>
                                <input type="text" name="firstname" :placeholder="$t('firstName')" data-vv-name="firstname" data-vv-as="First Name" v-validate="'required'"  :class="{'alert-danger': errors.has('firstname')}" v-model="firstName" />
                                </div>
<!-- <span>{{ errors.first('firstname') }}</span> -->
                                <div class="form-group">
                                 <label for="phone_id" class="control-label">{{ $t('lastName') }}</label>
                                <input type="text" name="lname" :placeholder="$t('lastName')"  data-vv-name="lastName" v-validate="'required'"  :class="{'alert-danger': errors.has('lastName')}" v-model="lastName" />
                                </div>
                                <div class="form-group">
                                 <label for="phone_id" class="control-label">{{ $t('mobile') }}</label>
                                <input type="text" name="phone" :placeholder="$t('mobile')"  data-vv-name="phone" v-validate="'required|numeric'"  :class="{'alert-danger': errors.has('phone')}" v-model="mobileNumber" />
                                </div>
                            </div>
                             <div class="form-group">
                            <label for="phone_id" class="control-label">{{ $t('email') }}</label>
                            <input type="email" name="emails" :placeholder="$t('email')"  data-vv-name="email" v-validate="'required|email'"  :class="{'alert-danger': errors.has('email')}" @keyup.enter="login" v-model="email" />
                             </div>
                            <div class="form-group">
                            <label for="phone_id" class="control-label">{{ $t('password') }}</label>
                            <input type="password" name="passwords" :placeholder="$t('password')" data-vv-name="password" v-validate="'required'"  :class="{'alert-danger': errors.has('password')}" ref="password" @keyup.enter="login" v-model="password" />
                            </div>
                             <div class="form-group">
                            <label v-if="!signUp" for="phone_id" class="control-label">{{ $t('confirmPassowrd') }}</label>
                            <input type="password" name="password" :placeholder="$t('confirmPassowrd')" v-if="!signUp" data-vv-name="confirmPassowrd" v-validate="'required|confirmed:password'" :class="{'alert-danger': errors.has('confirmPassowrd')}" v-model="confirmPassword" />
                            </div>
                             <div class="form-group">
                            <label v-if="!signUp" for="phone_id" class="control-label">{{ $t('countryCode') }}</label> 
                            <select name="country" id=""  v-if="!signUp" v-model="countryCode">
                                <option v-for="(count, index) in country" :key="index" :value="count.dial_code" :selected="count.dial_code == 971">  {{ count.dial_code }} - {{ count.name }}</option>
                            </select>
                             </div>
                            <!-- <input v-if="signUp == true" type="button" name="next" class="next action-button" :value="$t('login')" @click="userLogin" />

                            <input v-else type="button" name="next" class="next action-button" :value="$t('register')" @click="userLogin" /> -->
                            <div class="shipping_btn">
                                <button type="button" class="" v-if="signUp == true" @click="login">{{ $t('login') }}</button>

                                <button v-else type="button" name="next"  @click="login">{{ $t('register') }}</button>
                                    <a @click="signUp = false" v-if="signUp == true">{{ $t('register') }}</a>
                                            <a @click="signUp = true" v-if="signUp == false">{{ $t('login') }}</a>
                            </div>
                    </fieldset>
                </form>
             </div> 
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from "vuex";
import ShippingAddressComponent from './shippingAddressComponent';
import PaymentComponent from './paymentComponent';
import PlaceOrderComponent from './placeOrderComponent';
export default {
    components: {
        ShippingAddressComponent,
        PaymentComponent,
        PlaceOrderComponent,
    },
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
            'isLogin',
            'country',
        ]),
        ...mapGetters([
            'PRODUCT_FILTER',
            'CART_TOTAL_PRICE',
        ])
    },
    data () {
        return {
            step: 1,
            signUp: true,
            firstName: '',
            lastName: '',
            email: '',
            password: '',
            confirmPassword: '',
            countryCode: 971,
            mobileNumber: '',
        }
    },
    created () {
        if (!this.isLogin) {
            this.ACTION_PUSH_ERROR(this.$t('notLoggedIn'))
            // this.$router.push('/')
        }
        this.setActiveClass()
        if(this.$session.has('shippingId') && this.$session.get('shippingId') != '') {
            this.addShippingAddress(this.$session.get('shippingId'), this.$session.get('shippingAddress'))
        }
        if (this.$session.has('paymentMethod') && this.$session.get('paymentMethod') != '') {
            this.addPayment(this.$session.get('paymentMethod'))
        }
        var self = this
        setTimeout(function(){ 
            if (self.cartList.length == 0) {
                self.$router.push('/')
            }
        }, 500);
        this.SET_SHIPPING_SAVE_BUTTON(true)
    },
    mounted () {
        
    },
    methods: {
        ...mapActions([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'APPLY_COUPON',
            'ACTION_CALCULATE_TOTAL',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
        ]),
        ...mapMutations ([
            'SET_SHIPPING_ADDRESS',
            'SET_SHIPPING_SAVE_BUTTON',
        ]),
        setActiveClass () {
            this.ACTION_ACTIVE_CLASS('checkout')
        },
        login () {
        // if this.signUp == true means login or false  means create
            if (this.signUp) {
                this.userLogin();
            } else {
                this.register();
            }
                
        },
        register () {
            this.$validator.validateAll().then(result => {
                if(result) {
                    axios.post('/api/users', {
                        first_name: this.firstName,
                        last_name: this.lastName,
                        email: this.email,
                        password: this.password,
                        confirm_password: this.confirmPassword,
                        country_code: this.countryCode,
                        mobile_number: this.mobileNumber,
                    })
                    .then (response => {
                        var access = 'Bearer ' + response.data.accessToken
                        this.$session.set('accessToken', access)
                        this.$session.set('isLogin', true);
                        this.$parent.checkLogin() // call parent function to set login variable
                        this.updateCart()
                    })
                    .catch (errorResponse => {
                        console.log(errorResponse, 'errorResponse check out compoentnmm')
                    })
                }
            })
        },
        userLogin () {
            this.$validator.validateAll().then(result => {
                if(result) {
                    axios.post('/api/login', {
                        email: this.email,
                        password: this.password,
                    })
                    .then (response => {
                        var access = 'Bearer ' + response.data.accessToken
                        this.$session.set('accessToken', access)
                        this.$session.set('isLogin', true);
                        this.$parent.checkLogin() // call parent function to set login variable
                        this.updateCart()
                        
                    })
                    .catch (errorResponse => {
                        this.ACTION_PUSH_ERROR(this.$t('credentialNotFound'))
                    })
                }
            })
        },
        addShippingAddress (shippingId, shippingAddress) {
            this.$session.set('shippingId', shippingId);
            this.$session.set('shippingAddress', shippingAddress)
            this.step = 2
            this.SET_SHIPPING_ADDRESS(shippingAddress)
        },
        addPayment (method) {
            this.$session.set('paymentMethod', method)
            this.step = 3
        },
        updateCart () {
            var cart = JSON.parse(localStorage.getItem("cart")) || {};
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            axios.post('/api/cart/storage',{
                cart: cart,
            })
            .then (response => {
                let responseData = response.data.data
                 this.$parent.setCart(responseData)
                 localStorage.removeItem("cart")
            })
         }
    }
}
</script>

<style>

</style>
