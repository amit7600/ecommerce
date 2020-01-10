<template>
    <div>
        <div class="site-branding-area">
            <div class="container">
                <div class="">
                    <nav class="navbar">
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span> 
                          </button>
                          <a class="navbar-brand" @click="$parent.setIsActiveHome" to="/"><img src="/ecommerce/img/logo.png" alt=" " title=""></a>
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar" :loop="false">
                            <ul class="nav navbar-nav menu_list">
                                <li :class="{ active: isActive == '/' }" @click="changeRoute('/')"> <a>{{ $t('home') }}</a></li>
                                <li :class="{'active': false}" @click="changeRoute('/')"> <a  >{{ $t('about') }}</a></li>

                                <li v-for="(menu, index) in menuItems" :key="index" :class="{ 'dropdown' : true }" @click="changeRoute('/categories')"> <a class="dropdown-toggle" >{{ $i18n.locale == 'ar' ? menu.category_name_arabic : menu.category_name }}<span class="caret"></span></a>
                                    <ul class="dropdown-menu" v-if="menu.childCategory.length > 0">
                                      <li v-for="(childMenu, index) in menu.childCategory" :key="index" @click="searchCategory(childMenu.category_name)"><a >{{ $i18n.locale == 'ar' ? childMenu.category_name_arabic : childMenu.category_name }}</a></li>
                                    </ul>
                                </li>
                                <!-- <li :class="{ 'dropdown' : true }" @click="changeRoute('/')"> <a class="dropdown-toggle" >{{ $t('snacks') }}<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="#">Potato Chips</a></li>
                                      <li><a href="#">Banana Chips</a></li>
                                    </ul>
                                </li> -->
                                <li :class="{ active: isActive == 'cart' }"><a @click="changeRoute('/cart')" >{{ $t('cart') }}</a></li>
                                <li :class="{ active: isActive == 'contact' }"><a href="#">{{ $t('contact') }}</a></li>
                            </ul>
                        </div>
                        <div class="form-inline menu_search">
                              <input class="form-control mr-sm-2" type="search" :placeholder="$t('search')" aria-label="Search" @input="searchData" v-model="search" @keyup.enter="searchFrom">
                              <button class="btn btn-outline-success my-2 my-sm-0" type="button" @click="searchFrom"><i class="fas fa-search"></i></button>
                              <div id="myDropdown" :class="{'dropdown-content': true,  'hide': hide}">
                                <ul v-if="search.length > 2 && searchResult.length > 0">
                                    <li v-for="(product, index) in searchResult" :key="index">
                                        <a @click="productDetails(product.id)">{{ $i18n.locale == 'ar' ? product.product_name_arabic : product.product_name }} - {{$t('in')}} ( {{ $i18n.locale == 'ar' ?  product.category_name_arabic : product.category_name }} )</a>
                                    </li>
                                </ul>
                                <ul v-else-if="search.length > 2 && searchResult.length == 0">
                                    <li> <a>{{ $t('noResultFound') }}</a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cart_button">
                            <div class="shopping-item">
                                <router-link to="/cart" id="tak-list"><i class="fa fa-shopping-cart"></i> {{ $t('cart') }}<span class="product-count">{{cartCount}}</span></router-link>
                            </div>
                        </div>
                    </nav>
                    
                    <div class="col-sm-4">
                        <!-- <div class="shopping-item">
                            <router-link to="/cart" id="tak-list">{{ $t('cart') }} - <span class="cart-amunt">{{ $t('aed') }} {{CART_TOTAL_PRICE}}</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">{{cartCount}}</span></router-link>
                        </div> -->
                    </div>
                </div>
            </div>
        </div> <!-- End site branding area -->
        <div class="mainmenu-area">
        
    </div> <!-- End mainmenu area -->
    </div>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions  } from 'vuex'
export default {
    computed: {
        ...mapState([
            'name',
            'isActive',
            'menuItems',
        ]),
        ...mapGetters([
            'cartCount',
            'CART_TOTAL_PRICE',
        ])
    },
    data () {
        return {
            search: '',
            searchResult: [],
            hide: true,
        }
    },
    created () {
        if (this.$session.has('isLogged')) {
            this.getCartDetail();
        } else {
            this.getLocalStoreDetails();
        }
        this.getCategory();
    },
    methods: {
        ...mapMutations([
            'SET_CARTLIST',
            'SET_SEARCH_RESULT',
            'SET_ACTIVE_CLASS',
        ]),
        ...mapActions([
            'ACTION_ACTIVE_CLASS',
            'ACTION_SEARCH_PRODUCTS',
        ]),
        getCartDetail () {
            axios.get('/api/cart')
            .then(response => {
                this.SET_CARTLIST(response.data.data)
                // this.cartCount = response.data.data.length
            })
            .catch (errorResponse => {

            })
        },
        getLocalStoreDetails () {
            var cart = JSON.parse(localStorage.getItem("cart")) || {}; 
            if (cart != undefined && cart.length > 0) {
                this.SET_CARTLIST(cart)
            }
        },
        changeRoute (path) {
            this.$router.push(path)
            this.ACTION_ACTIVE_CLASS(path)
        },
        getCategory () {
            // axios.get('/api/categories')
            // .then (response => {
            //     console.log(response.data.data)
            // })
        },
        searchData () {
            this.searchResult = []
            if (this.search.length > 2) {
                axios.post('/api/search', {
                    search: this.search
                })
                .then(response => {
                    this.searchResult = response.data.data
                    this.hide = false
                    this.SET_SEARCH_RESULT(this.searchResult)
                })
            }
        },
        productDetails (productId) {
            this.$router.push({name: 'ProductDetailsComponent', params: {id: productId}})
            this.hide = true
        },
        searchFrom () {
            if (this.search.length > 2) {
                this.$router.push({name: 'SearchComponent', params: {id: this.search}})
                this.hide = true
            }
        },
        searchCategory (value) {
            this.$router.push({name: 'SubCategoryComponent', params: {id: value}})
            location.reload()
        }
    }

}
</script>

<style>

</style>
