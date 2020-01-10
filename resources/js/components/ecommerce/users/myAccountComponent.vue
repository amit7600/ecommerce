<template>
    <div>
        <div class="product-big-title-area myaccount_background">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>{{ $t('myAccount') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="inner_myaccount">
        	<div class="container">
        		<div class="left_sidebar">
        			<ul>
        				<li :class="{'active': myActiveClass == 'myAccount'}"><router-link to="/myAccount"><i class="fas fa-user"></i> {{ $t('myProfile') }}</router-link></li>
        				<li :class="{'active': myActiveClass == 'myChangePass'}"><router-link to="/myAccount/changePassword"><i class="fas fa-key"></i> {{ $t('changePassword') }}</router-link></li>
        				<li :class="{'active': myActiveClass == 'myOrders'}"><router-link to="/myAccount/myOrders"><i class="fas fa-cube"></i> {{ $t('myOrders') }}</router-link></li>
        				<li :class="{'active': myActiveClass == 'myShipping'}"><router-link to="/myAccount/shippingAddress"><i class="fas fa-truck"></i> {{ $t('shippingAddress') }}</router-link></li>
        				<li :class="{'active': myActiveClass == 'myLogout'}"><a @click="logOut"><i class="fas fa-sign-out-alt"></i> {{ $t('logOut') }}</a></li>
        			</ul>
        		</div>
        		<div class="right_side">
        			<router-view></router-view>
        		</div>
        	</div>
       </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from "vuex";
import ShippingAddressComponent from '../orders/shippingAddressComponent';
export default {
    computed: {
        ...mapState([
            'myActiveClass',
            'isLogin',
        ])
    },
    components: {
        ShippingAddressComponent,
    },
    created () {
        if (!this.isLogin) {
            this.$session.clear();
            this.$router.push('/')
        }
        this.SET_SHIPPING_SAVE_BUTTON(false)
    },
    methods: {
        ...mapMutations([
            'SET_SHIPPING_SAVE_BUTTON'
        ]),
        logOut () {
            this.$session.clear();
            this.$router.push('/')
            location.reload();
        },
    }
}
</script>

<style>

</style>
