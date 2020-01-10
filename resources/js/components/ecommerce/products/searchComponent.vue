<template>
    <div>
        <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>{{ $t('search') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Page title area -->

        <!-- <div class="col-sm-md-12">
            <div class="single-product-area">
                <div class="zigzag-bottom"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6" v-for="(product, index) in searchResult" :key="index">
                            <div class="single-shop-product">
                                <div class="product-upper">
                                    <img :src="product.product_other_image[0]" alt="">
                                </div>
                                <h2><a @click="$parent.setImage(product.product_other_image[0], product.id)">{{ $i18n.locale == 'ar' ?product.product_name_arabic : product.product_name }}</a></h2>
                                <div class="product-carousel-price">
                                    <ins>{{ $t('aed') }} {{product.sale_price ? product.sale_price : product.price}}</ins> <del>{{ $t('aed') }} {{ product.price }}</del>
                                </div>  
                                
                                <div class="product-option-shop">
                                    <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="70" rel="nofollow"  @click="$parent.addToCart(product.id, product.sale_price ? product.sale_price : product.price)">{{ $t('addToCart') }}</a>
                                </div>                       
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="product-pagination text-center">
                                <nav>
                                <ul class="pagination">
                                    <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    </li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                    </li>
                                </ul>
                                </nav>                        
                            </div>
                        </div>
                    </div> -->
                <!-- </div>
            </div>
        </div> -->


        <!-- start search product -->
             <div class="feature_product">
            <div class="container" id="feature_slider">
                <div class="search_item" v-for="(product, index) in searchResult" :key="index">
                        <div class="inner_product">
                            <div class="product_img">
                                <a @click="$parent.setImage(product.product_other_image[0], product.id)"> <img :src="product.product_other_image[0]" alt=""></a>
                            </div>
                            <h4><a @click="$parent.setImage(product.product_other_image[0], product.id)">{{ GET_PRODUCT_SHORT_NAME($i18n.locale == 'ar' ?product.product_name_arabic : product.product_name) }}</a></h4>
                            <!-- <div class="star_rating">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="far fa-star"></i></a>
                                <a href="#"><i class="far fa-star"></i></a>
                            </div> -->
                            <h3 class="price_tag">
                                <span class="price line_above">{{ $t('aed') }} {{ product.price }}</span>
                                <span class="discount_price">({{ $t('aed') }} {{product.sale_price ? product.sale_price : product.price}})</span>
                            </h3>
                            <div class="all_btn">
                                <!-- <router-link :to="'/product-details/' + product.id"><span><i class="fas fa-heart"></i></span></router-link> -->
                                <a @click="$parent.addToCart(product.id, product.sale_price ? product.sale_price : product.price)"><span><i class="fas fa-shopping-cart"></i></span></a>
                                <a @click="$parent.setImage(product.product_other_image[0], product.id)"><span><i class="fas fa-eye"></i></span></a>
                            </div>
                        </div>
                 </div>   
            </div>
        </div>
          
          <!-- End search product -->
        
    </div>
</template>

<script>
import { mapMutations, mapState, mapGetters, mapActions } from 'vuex';
export default {
    computed: {
        ...mapState([
            'isActive',
            'products',
            'searchResult',
        ]),
        ...mapGetters([
            'GET_PRODUCT_SHORT_NAME',
        ])
    },
    data () {
        return {
            productKey: 0,
            productDetail: [],
        }
    },
    created () {
        this.setIsActive('product')
        this.productDetails()
    },
    watch: {
        '$route.params.id': function (id) {
            this.productDetails()
        }
    },
    methods: {
        ...mapMutations([
            'SET_SEARCH_RESULT',
        ]),
        ...mapActions([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'ACTION_SET_IMAGE',
        ]),
        setIsActive () {
            var currentUrl = window.location.pathname;
            this.ACTION_ACTIVE_CLASS('product')
            
        },
        productDetails() {
            if (this.$route.params.id) {
                axios.post('/api/search', {
                    search: this.$route.params.id
                })
                .then(response => {
                    this.SET_SEARCH_RESULT(response.data.data)
                })
            }  
        },
        
    }
}
</script>

<style>

</style>
