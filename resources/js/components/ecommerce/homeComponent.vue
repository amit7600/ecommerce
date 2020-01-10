<template>
    <div :class="classRTL">
        <TopSectionComponent></TopSectionComponent>
        <HeaderNavbarComponent></HeaderNavbarComponent>
        <div v-if="isActive == '/'">
            <!-- <SliderComponent></SliderComponent> -->
            <!-- <PromoAreaComponent></PromoAreaComponent> -->
            <!-- <ProductsComponent></ProductsComponent> -->
        </div>
        <router-view class="view"></router-view>
        <FooterComponent></FooterComponent>
        <!-- <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    
                </div>
            </div>
        </div> -->
    </div>
</template>

<script>
import TopSectionComponent from './includes/topSectionComponent';
import HeaderNavbarComponent from './includes/headerNavbarComponent';
import SliderComponent from './includes/sliderComponent';
import ProductsComponent from './products/ProductsComponent';
import PromoAreaComponent from './includes/PromoAreaComponent';
import FooterComponent from './includes/footerComponent';
import ChildHomeComponent from './includes/childHomeComponent';
import { mapMutations, mapState, mapGetters, mapActions } from 'vuex';
export default {
    components : {
        TopSectionComponent,
        HeaderNavbarComponent,
        SliderComponent,
        PromoAreaComponent,
        ProductsComponent,
        FooterComponent,
        ChildHomeComponent
    },
    computed: {
        ...mapState([
            'products',
            'latestProduct',
            'futuredProduct',
            'isActive',
            'isLogin',
            'cartList',
            'country',
            'classRTL',
        ]),
         ...mapGetters([
            'cartCount',
        ]),
    },
    created () {
        this.checkLogin(); // check if user login
        this.setIsActive(); // set active class
        this.getCategoryList() //get category list
    },
    mounted () {
        this.getProducts(); // get products
        this.getCountryCode()
    },
    methods: {
        ...mapMutations([
            'GET_PRODUCTS',
            'SET_COUNTRY',
            'GET_LATEST_PRODUCT',
            'SET_RECENTLY_VIEWS',
            'SET_FUTURED_PRODUCT',
            'SET_MENU_ITEMS',
        ]),
        ...mapActions([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'ACTION_IS_LOGIN',
            'ACTION_PUSH_TO_CART',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
            'APPLY_COUPON',
            'ACTION_CHANGE_BUTTON',
            'ACTION_CALCULATE_TOTAL',
            'ACTION_SET_IMAGE',
        ]),
        getProducts () {
            axios.get('/api/products')
            .then(response => {
                this.GET_PRODUCTS(response.data.data)
                this.GET_LATEST_PRODUCT(response.data.latestProduct)
                this.SET_FUTURED_PRODUCT(response.data.futuredProduct)
                this.recentViews()
            })
            .catch(errorResponse => {
                console.log(errorResponse, 'errorResponse get products')
            })
        },
        addToCart (productId, price, quantity = null) {
            // console.log(productId, price, quantity)
            // localStorage.removeItem("cart")
            if (this.isLogin)
                var cart = this.cartList
            else
                var cart = JSON.parse(localStorage.getItem("cart")) || {};
            var inCart = false;
            var cartArray = []
            // var productData = this.products.find(product => product.getChildProduct[0].id == productId)
            for (let index = 0; index < this.products.length; index++) {
                const element = this.products[index];
                for (let j = 0; j < element.getChildProduct.length; j++) {
                    const child = element.getChildProduct[j];
                    if (child.id == productId) {
                        var productData = this.products.find(product => product.id == element.id)
                    }
                    
                }
            }
            // update the cart by adding an entry or incrementing an existing one
            if (cart != undefined && cart.length > 0) {
                cartArray = cart;
                cartArray.forEach((element,index) => {
                    if(element.productId == productId) {
                        inCart = true
                        if(quantity != null)
                            element.quantity = parseInt(quantity)
                        else
                            element.quantity += 1
                        return;
                    }
                });
                if(!inCart) {
                    cartArray[cart.length] = {
                        productId, // shorthand for `productPrice: productPrice,`
                        price,
                        quantity: 1,
                        productData,
                    };
                }
            } else {
                cartArray = [{
                    productId, // shorthand for `productPrice: productPrice,`
                    price,
                    quantity: 1,
                    productData,
                }];
            }
            // put the result back in localStorage
            if (this.isLogin) {
                // if is user login
                this.storeDataTocart(productId, price, quantity, productData)
            } else {
                // if is user not login
                localStorage.setItem("cart", JSON.stringify(cartArray));
            }
            if (!this.isLogin) {
                // set cart item
                this.SET_CART(cartArray)
            }
            if(this.$session.has('couponCode') && this.$session.get('couponCode')) {
                this.APPLY_COUPON({couponCode: this.$session.get('couponCode'), couponData: this.$session.get('couponData')})
            }
            // calculate grand total
            this.ACTION_CALCULATE_TOTAL({cartTotalPrice: 0})
            this.ACTION_PUSH_SUCCESS(this.$t('cartItemAdd'))
        },
        storeDataTocart (productId, price, quantity, productData) {
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            axios.post('/api/cart', {
                productId: productId,
                price: price,
                quantity: quantity ,
                productData: productData,

            })
            .then (response => {
                this.setCart(response.data.data)
            })
            .catch (errorResponse => {
                console.log(errorResponse.response, 'errorResponse sdtorecart home component')
            })
        },
        removeFromCart (productId) {
            // remove quantity from cart
            if (this.isLogin)
                var cart = this.cartList
            else
                var cart = JSON.parse(localStorage.getItem("cart")) || {};
            
            var productData = this.products.find(product => product.id == productId)
            var cartArray = []
            if (cart != undefined && cart.length > 0) {
                cartArray = cart;
                cartArray.forEach((element,index) => {
                    if(element.productId == productId) {
                        if(element.quantity > 1)
                            element.quantity -= 1
                        return;
                    }
                });
                 if (this.isLogin)
                    this.updateItemFromUserCart(productId, cartArray)
                else
                    localStorage.setItem("cart", JSON.stringify(cartArray));

                // set cart item
                this.SET_CART(cartArray)
                if(this.$session.has('couponCode') && this.$session.get('couponCode')) {
                    this.APPLY_COUPON({couponCode: this.$session.get('couponCode'), couponData: this.$session.get('couponData')})
                }
                // calculate grand total
                this.ACTION_CALCULATE_TOTAL({cartTotalPrice: 0})
            }
        },
        removeCartItem (index, productId) {
            // remove quantity from cart
            if (this.isLogin)
                var cart = this.cartList
            else
                var cart = JSON.parse(localStorage.getItem("cart")) || {};

            var productData = this.products.find(product => product.id == productId)
            var cartArray = []
            if (cart != undefined && cart.length > 0) {
                cartArray = cart;
                cartArray.forEach((element,index) => {
                    if(element.productId == productId) {
                        cartArray.splice(index, 1)
                        return;
                    }
                });
                if (this.isLogin)
                    this.removeFromUserCart(index, productId)
                else
                    localStorage.setItem("cart", JSON.stringify(cartArray));

                // set cart item
                this.SET_CART(cartArray)
                if(this.$session.has('couponCode') && this.$session.get('couponCode')) {
                    this.APPLY_COUPON({couponCode: this.$session.get('couponCode'), couponData: this.$session.get('couponData')})
                }
                // calculate grand total
                this.ACTION_CALCULATE_TOTAL({cartTotalPrice: 0})
            }
            this.ACTION_PUSH_SUCCESS(this.$t('cartItemRemoved'))
        },
        setIsActive () {
            var currentUrl = window.location.pathname;
            var replace = currentUrl.replace('/', '');
            this.ACTION_ACTIVE_CLASS(replace)
            
        },
        setIsActiveHome () {
            this.ACTION_ACTIVE_CLASS('/')
            this.$router.push('/')
            
        },
        checkLogin () {
            if(this.$session.has('isLogin') && this.$session.get('isLogin') == true) {
                this.ACTION_IS_LOGIN(true)
            } else {
                this.ACTION_IS_LOGIN(false)
            }
            this.getCartDetails()
        },
        getCartDetails () {
            if (this.isLogin) {
                axios.get('/api/cart', {
                    headers: {
                        Authorization: this.$session.get('accessToken')
                    }
                })
                .then (response => {
                    let responseData = response.data.data
                    this.setCart(responseData)
                })
            }
        },
        setCart (responseData) {
            let cartArray = []
            if (responseData.length > 0) {
                responseData.forEach((element, index) => {
                    cartArray[index] = {
                        productId: element.product_child_id, // shorthand for `productPrice: productPrice,`
                        price: element.price,
                        quantity: element.quantity,
                        productData: JSON.parse(element.cartData),
                    };
                });
                // set cart item
                this.SET_CART(cartArray)
            }
        },
        removeFromUserCart (index, productId) {
            axios.delete('/api/cart/' + productId, {
                headers: {
                    Authorization: this.$session.get('accessToken')
                }
            })
            .then (response => {
                // if (response.data.success == true)
                //     this.ACTION_PUSH_SUCCESS('Cart removed')
            })
            .catch (errorResponse => {
                console.log(errorResponse, 'errorResponse remove from cart homecompoenet')
            })
        },
        updateItemFromUserCart (productId, cartArray) {
            // update cart from
            axios.defaults.headers.common['Authorization'] = this.$session.get('accessToken')
            axios.put('/api/cart/' + productId, {
                cartArray: cartArray,
            })
            .then (response => {
                console.log(response, 'update cart home component')
            })
            .catch (errorResponse => {
                console.log(errorResponse, 'errorResponse update cart home component')
            })
        },
        getCountryCode () {
            axios.get('/api/getCountryCode')
            .then(response => {
                this.SET_COUNTRY(response.data.data)
            })
            .catch(errorResponse => {
            console.log(errorResponse, 'errorResponse gfet counrty code')
            })
        },
        recentViews () {
            var recentlyViews = JSON.parse(localStorage.getItem("recentlyViews")) || {};
            // var recentArray = []
            // if (recentlyViews != undefined && recentlyViews.length > 0) {
            //     this.products.filter(element => {
            //         recentlyViews.forEach(value => {
            //             if (value.productId == element.id) {
            //                 recentArray.push(element)
            //             }
            //         });
            //     })
            // }
            this.SET_RECENTLY_VIEWS(recentlyViews)
        },
        setImage (image, productId) {
            this.ACTION_SET_IMAGE(image)
            this.$session.set('productImage', image)
            this.$router.push('/product-details/' + productId)
        },
        getCategoryList () {
            axios.get('/api/categories')
            .then (response => {
                // set menu items
                this.SET_MENU_ITEMS(response.data.data)
                
            })
        }
        
    }
}
</script>

<style>

</style>
