<template>
	<div>
        <h2 class="fs-title">
            <img src="/ecommerce/img/title_icon1.png" alt="" title=""> 
             {{ $t('myOrders') }}
            <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
        </h2>
        <div class="my_orders my_profile">
        	<div class="detail_address_view">
				<div class="item" v-for="(order, index) in myOrders " :key="index">
	                <div class="card">
	                    <div class="content_ship_address">
	                        <h4><b>	{{ $t('orderId') }} </b> <i> {{ order.order_number }} </i> </h4>
	                        <h4><b> {{ $t('orderDate') }} :</b> <i>{{ order.ordered_at }}</i></h4>
	                    </div>
	                    <div class="btn_shipping">
	                         <button type="button" @click="showOrderDetails(order.id)" class="btn btn-default btn-read" > {{ $t('orderDetails') }}
	                        </button>     
	                    </div>
	                </div>
	            </div>
	         </div> 
        </div>
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from "vuex";
export default {
	 computed: {
        totalPages: function() {
          return Math.ceil(this.resultCount / this.itemsPerPage)
        }
	},
	data () {
		return {
			myOrders: [],
		}
	},
	created () {
		this.ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS('myOrders')
		this.getOrders()
	},
	
	methods: {
		...mapMutations([
			'SET_MY_ORDERS',
		]),
		...mapActions([
			'ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS',
		]),
		showOrderDetails(orderId) {
			this.$router.push({name: 'OrderDetailComponent', params: {id: orderId}})
		},
		getOrders () {
			axios.get('/api/orders', {
				headers: {
					Authorization: this.$session.get('accessToken')
				}
			})
			.then (reponse => {
				this.SET_MY_ORDERS = reponse.data.data
				this.myOrders = reponse.data.data
			})
		},
		setPage: function(pageNumber) {
          this.currentPage = pageNumber
		},
	},
	
}
</script>

<style>

</style>
