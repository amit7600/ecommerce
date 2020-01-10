import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        cartList: [],
        name: 'Kandarp Pandya',
        products: [],
        latestProduct: [],
        futuredProduct: [],
        isActive: '/',
        cartCount: 0,
        getLocale: 'en',
        cartTotalPrice: 0,
        couponCode: '',
        subTotal: 0,
        discount: 0,
        tax: 0,
        shippingCharge: 0,
        grandTotal: 0,
        isLogin: false,
        errorMessage: [],
        successMessage: [],
        shippingAddress: '',
        country: [],
        couponErrorMessage: '',
        minus: false,
        plus: true,
        searchResult: [],
        classRTL: 'ltr',
        recentlyViews: [],
        productImage: '',
        menuItems: [],
        myActiveClass: 'myAccount',
        myOrders: [],
        orderId: '',
        isSaveShippingAddressButtonShow: true,
    },
    getters: {
        cartCount: state => {
            state.cartCount = 0
            if(state.cartList.length > 0) {                
                state.cartList.forEach(element => {
                    state.cartCount += parseInt(element.quantity)
                });
            }
            return parseInt(state.cartCount)
          
        },
        PRODUCT_FILTER: (state) => (productId) => {
            // filter product list
            // alert(productId)
        },
        CART_TOTAL_PRICE: state => {
            state.cartTotalPrice = 0
            if(state.cartList.length > 0) {                
                state.cartList.forEach(element => {
                    state.cartTotalPrice += element.quantity * element.price
                });
            }
            return state.cartTotalPrice
        },
        GET_PRODUCT_SHORT_NAME: (state) => (productName) => {
            // for substring of long product name
            productName = productName.replace(/(<([^>]+)>)/ig, '');
            let body = productName;
            return body.length > 50 ? body.substring(0, 20) + '...' : body;           
        },
        
    },
    mutations: {

        SET_CARTLIST(state, value) {
            state.cartList = []
            state.cartList = value
        },
        GET_PRODUCTS(state, value) {
            state.products = value
        },
        GET_LATEST_PRODUCT (state, value) {
            state.latestProduct = value
        },
        SET_ACTIVE_CLASS (state, value) {
            // set active class on active menu
            if(value) {
                state.isActive = value
            } else {
                state.isActive = '/'
            }
        },
        CALCULATE_COUPON (state, value) {
            state.couponCode = value.couponCode
            state.subTotal = value.cartTotalPrice
            let discount = 0;
            if(value.couponData.minimum_order_amount) {
                state.couponErrorMessage = ''
                if (state.subTotal >= value.couponData.minimum_order_amount) {
                    if(value.couponData.discount == 'percentage') {
                        // if discount is percentage
                        discount = parseInt(state.subTotal) * parseInt(value.couponData.discount_amount) / 100;
                    } else {
                        // if discount is flat
                        discount = parseInt(value.couponData.discount_amount);
                    }
                } else {
                    state.couponErrorMessage = 'Coupon applied on minimum order amount of AED ' + value.couponData.minimum_order_amount;
                }
            }
            // If discount is greater than minimum offer amount
            if(discount > parseInt(value.couponData.minimum_offer_amount) && value.couponData.discount == 'percentage') {
                discount = parseInt(value.couponData.minimum_offer_amount)
            }
            // set discount value to state
            state.discount = discount
            state.grandTotal = parseInt(state.subTotal) - discount
        },
        CALCULATE_TOTAL (state, value) {
            // calucate order amount
            state.subTotal = value.cartTotalPrice
            state.grandTotal = value.cartTotalPrice - state.discount
            // state.discount = 0
        },
        SET_LOCALE (state, value) {
            state.getLocale = value
        },
        IS_LOGIN (state, value) {
            state.isLogin = value
        },
        PUSH_SUCCESS (state, value) {
            state.successMessage = []
            state.successMessage.push(value)
        },
        PUSH_ERROR (state, value) {
            state.errorMessage = []
            state.errorMessage.push(value)
        },
        NULL_MESSAGES (state, value) {
            state.successMessage = []
            state.errorMessage = []
        },
        SET_SHIPPING_ADDRESS (state, value) {
            // set shipping address values
            state.shippingAddress = value
        },
        PUSH_TO_CART (state, value) {
            console.log(value, 'PUSH_TO_CART')
        },
        SET_COUNTRY (state, value) {
            state.country = value
        },
        RESET_DISCOUNT (state, value) {
            // Remove discount and calculate
            state.subTotal = value
            state.grandTotal = value
            state.discount = 0
        },
        SET_SEARCH_RESULT (state, value) {
            state.searchResult = value
        },
        SET_RTL_CLASS (state, value) {
            state.classRTL = value
        },
        SET_RECENTLY_VIEWS (state, value) {
            // recently views
            var recentArray = []
            var recentlyViews = value
            if (recentlyViews != undefined && recentlyViews.length > 0) {
                state.products.filter(element => {
                    recentlyViews.forEach(value => {
                        if (value.productId == element.id) {
                            recentArray.push(element)
                        }
                    });
                })
            }
            state.recentlyViews = recentArray
        },
        SET_FUTURED_PRODUCT (state, value) {
            state.futuredProduct = value
        },
        SET_PRODUCT_IMAGE (state, value) {
            state.productImage = value
        },
        SET_MENU_ITEMS (state, value) {
            state.menuItems = value
        },
        SET_MY_ACCOUNT_ACTIVE_CLASS (state, value) {
            state.myActiveClass = value
        },
        SET_MY_ORDERS (state, value) {
            state.myOrders = value
        },
        SET_ORDER_ID (state, value) {
            state.orderId = value
        },
        SET_SHIPPING_SAVE_BUTTON (state, value) {
            state.isSaveShippingAddressButtonShow = value
        },
        SET_EMPTY_CART_LIST (state) {
            state.cartList = []
        }
    },
    actions: {
        SET_CART (context, value) {
            context.commit('SET_CARTLIST', value)
        },
        ACTION_ACTIVE_CLASS (context, value) {
            context.commit('SET_ACTIVE_CLASS', value)
        },
        ACTION_SET_LOCALE (context, value) {
            context.commit('SET_LOCALE', value)
        },
        APPLY_COUPON (context, value) {
            value.cartTotalPrice = context.getters.CART_TOTAL_PRICE
            context.commit('CALCULATE_COUPON', value)
        },
        ACTION_CALCULATE_TOTAL (context, value) {
            value.cartTotalPrice = context.getters.CART_TOTAL_PRICE
            context.commit('CALCULATE_TOTAL', value)
        },
        ACTION_IS_LOGIN (context, value) {
            context.commit('IS_LOGIN', value)
        },
        ACTION_PUSH_SUCCESS (context, value) {
            // push success message
            context.commit('PUSH_SUCCESS', value)
        },
        ACTION_PUSH_ERROR (context, value) {
            // push error message
            context.commit('PUSH_ERROR', value)
        },
        ACTION_NULL_MESSAGES (context, value) {
            context.commit('NULL_MESSAGES', value)
        },
        ACTION_PUSH_TO_CART (context, value) {
            context.commit('PUSH_TO_CART', value)
        },
        ACTION_DISCOUNT_RESET (context) {
            var value = context.getters.CART_TOTAL_PRICE
            context.commit('RESET_DISCOUNT', value)
        },
        ACTION_SEARCH_PRODUCTS (context, value) {
            console.log(value, 'kandarp')
        },
        ACTION_CHANGE_RTL(context, value) {
            context.commit('SET_RTL_CLASS', value);
        },
        ACTION_SET_IMAGE (context, value) {
            context.commit('SET_PRODUCT_IMAGE', value)
        },
        ACTION_CHANGE_MY_ACCOUNT_ACTIVE_CLASS (context, value) {
            context.commit('SET_MY_ACCOUNT_ACTIVE_CLASS', value)
        }
    },
    modules: {

    }

})