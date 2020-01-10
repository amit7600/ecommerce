<template>
    <div>
        <!-- start feature_product -->
        <div class="feature_product">
            <div class="container" id="feature_slider">
                <h2>
                    <img src="/ecommerce/img/title_icon.png" alt="" title=""> 
                    {{ $t('featureProductrs') }}
                    <img src="/ecommerce/img/title_icon_mirror.png" alt="" title="">
                </h2>
                <carousel :perPageCustom="[[600, 2],[767, 3], [1024, 4],[320, 1],[575, 1], [414, 1]]" :autoplay="true" :navigationEnabled="true" :paginationEnabled="true" :loop="true" :autoplayTimeout="4000">
                    <slide  v-for="(product, index) in futuredProduct" :key="index">
                        <div class="inner_product">
                            <div class="product_img">
                                <a @click="$parent.setImage(product.product_other_image[0], product.id)"><img :src="product.product_other_image[0]" alt="" title=""></a>
                            </div>
                            <h4><a @click="$parent.setImage(product.product_other_image[0], product.id)">{{ GET_PRODUCT_SHORT_NAME (getLocale == 'ar' ? product.product_name_arabic : product.product_name) }}</a></h4>
                            <!-- <div class="star_rating">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="far fa-star"></i></a>
                                <a href="#"><i class="far fa-star"></i></a>
                            </div> -->
                            <h3 class="price_tag">
                                <span class="price line_above">{{ $t('aed') }} {{ product.getChildProduct[0].price }}</span>
                                <span class="discount_price">({{ $t('aed') }} {{product.getChildProduct[0].sale_price ? product.getChildProduct[0].sale_price : product.getChildProduct[0].price}})</span>
                            </h3>
                            <div class="all_btn">
                                <!-- <router-link :to="'/product-details/' + product.id"><span><i class="fas fa-heart"></i></span></router-link> -->
                                <a @click="addToCart(product.getChildProduct[0].id, product.getChildProduct[0].sale_price ? product.getChildProduct[0].sale_price : product.getChildProduct[0].price)"><span><i class="fas fa-shopping-cart"></i></span></a>
                                <a @click="$parent.setImage(product.product_other_image[0], product.id)"><span><i class="fas fa-eye"></i></span></a>
                            </div>
                        </div>
                    </slide>
                </carousel>
            </div>
        </div>

   <!-- end feature_productssss -->
      <!-- start latest_product -->

        <div class="feature_product latest_product">
            <div class="container">
                <h2>
                    <img src="/ecommerce/img/title_icon1.png" alt="" title=""> 
                    {{ $t('latestProduct') }}
                    <img src="/ecommerce/img/title_icon_mirror1.png" alt="" title="">
                </h2>
                    <carousel :perPageCustom="[[600, 2],[767, 3], [1024, 4],[320, 1],[575, 1], [414, 1]]" :autoplay="true" :navigationEnabled="true" :paginationEnabled="true" :loop="true" :autoplayTimeout="4000">
                        <slide id="latest_product" v-for="(product, index) in latestProduct" :key="index">
                            <div class="inner_product">
                                <div class="product_img">
                                    <a @click="$parent.setImage(product.product_other_image[0], product.id)"><img :src="product.product_other_image[0]" alt="" title=""></a>
                                </div>
                                <h4><a @click="$parent.setImage(product.product_other_image[0], product.id)">{{ GET_PRODUCT_SHORT_NAME (getLocale == 'ar' ? product.product_name_arabic : product.product_name) }}</a></h4>
                                <!-- <div class="star_rating">
                                    <a href="#"><i class="fas fa-star"></i></a>
                                    <a href="#"><i class="fas fa-star"></i></a>
                                    <a href="#"><i class="fas fa-star"></i></a>
                                    <a href="#"><i class="far fa-star"></i></a>
                                    <a href="#"><i class="far fa-star"></i></a>
                                </div> -->
                                <h3 class="price_tag">
                                    <span class="price line_above">{{ $t('aed') }} {{ product.getChildProduct[0].price }}</span>
                                    <span class="discount_price">({{ $t('aed') }} {{product.getChildProduct[0].sale_price ? product.getChildProduct[0].sale_price : product.getChildProduct[0].price}})</span>
                                </h3>
                                <div class="all_btn">
                                    <!-- <router-link :to="'/product-details/' + product.id"><span><i class="fas fa-heart"></i></span></router-link> -->
                                    <a @click="addToCart(product.getChildProduct[0].id, product.getChildProduct[0].sale_price ? product.getChildProduct[0].sale_price : product.getChildProduct[0].price)"><span><i class="fas fa-shopping-cart"></i></span></a>
                                    <a @click="$parent.setImage(product.product_other_image[0], product.id)"><span><i class="fas fa-eye"></i></span></a>
                                </div>
                            </div>
                        </slide>
                    </carousel>
            </div>
        </div>
         <!-- end latest_product -->

      <!-- start dry fruit and snack card  -->
        <div class="snack_dryfruit">
            <div class="container">
                <router-link :to="'categories/'+ one">
                    <div class="dry_fruit_card">
                        <div class="text-dry_fruit">
                                <img class="overlay_img" src="/ecommerce/img/dry_fruit_overlay.png" alt="" >
                                <h4 class="overlay_text"> {{ $t('dryFruits') }} </h4>
                        </div>
                    </div>
                </router-link>

                <router-link :to="'categories/'+ two">
                <div class="dry_fruit_card">
                    <div class="text-snack">
                            <img class="overlay_img" src="/ecommerce/img/snack_overlay.png" alt="" >
                            <h4 class="overlay_text"> {{ $t('snacks') }} </h4>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>  <!-- End dry fruit and snack card  -->


        <!-- start tab panel  -->
        <div class="tab_background feature_product" id="recently_viewed">
            <div class="container">
                <h2>
                    <img src="/ecommerce/img/title_icon.png" alt="" title=""> 
                    {{ $t('recentlyViewed') }}
                    <img src="/ecommerce/img/title_icon_mirror.png" alt="" title="">
                </h2>
                <div class="tab-content">
                    <carousel :perPageCustom="[[600, 2],[767, 3], [1024, 4],[320, 1],[575, 1], [414, 1]]" :autoplay="true" :navigationEnabled="true" :paginationEnabled="true" :loop="true" :autoplayTimeout="4000">
                        <slide id="recently_viewed"  v-for="(product, index) in recentlyViews" :key="index">
                            <div class="inner_product">
                                <div class="product_img">
                                    <a @click="$parent.setImage(product.product_other_image[0], product.id)"><img :src="product.product_other_image[0]" alt="" title=""></a>
                                </div>
                                <h4><a @click="$parent.setImage(product.product_other_image[0], product.id)">{{ GET_PRODUCT_SHORT_NAME (getLocale == 'ar' ? product.product_name_arabic : product.product_name) }}</a></h4>
                                <!-- <div class="star_rating">
                                    <a href="#"><i class="fas fa-star"></i></a>
                                    <a href="#"><i class="fas fa-star"></i></a>
                                    <a href="#"><i class="fas fa-star"></i></a>
                                    <a href="#"><i class="far fa-star"></i></a>
                                    <a href="#"><i class="far fa-star"></i></a>
                                </div> -->
                                <h3 class="price_tag">
                                    <span class="price line_above">{{ $t('aed') }} {{ product.getChildProduct[0].price }}</span>
                                    <span class="discount_price">({{ $t('aed') }} {{ product.getChildProduct[0].sale_price ? product.getChildProduct[0].sale_price : product.getChildProduct[0].price }})</span>
                                </h3>
                                <div class="all_btn">
                                    <!-- <router-link :to="'/product-details/' + product.id"><span><i class="fas fa-heart"></i></span></router-link> -->
                                    <a @click="addToCart(product.getChildProduct[0].id, product.getChildProduct[0].sale_price ? product.getChildProduct[0].sale_price : product.getChildProduct[0].price)"><span><i class="fas fa-shopping-cart"></i></span></a>
                                    <a @click="$parent.setImage(product.product_other_image[0], product.id)"><span><i class="fas fa-eye"></i></span></a>
                                </div>
                            </div>
                        </slide>
                    </carousel>
                </div>
            </div>

        </div>
        <!-- End tab panel -->


        <!-- Start above footer slider -->
               
        <div class="feature_product">
            <div class="container">
                <div class="owl-carousel owl-theme" id="slider_above_footer">
                    <div class="item" >
                        <div class="inner_product">
                            <div class="product_img">
                                <a href="#"><img src="/ecommerce/img/almonds.jpg" alt="" title="" class="image" >
                                    <div class="middle">
                                        <div class="inner_middle">
                                            <img  src="/ecommerce/img/almonds_overlay.png" alt="" title="" class="text" >
                                            <h3 class="text">ALMONDS</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End above footer slider -->
    </div>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
import { Carousel, Slide } from 'vue-carousel';
export default {
    computed: {
        ...mapState([
            'products',
            'latestProduct',
            'futuredProduct',
            'cartList',
            'getLocale',
            'recentlyViews',
        ]),
        ...mapGetters([
            'PRODUCT_FILTER',
            'CART_TOTAL_PRICE',
            'GET_PRODUCT_SHORT_NAME',
        ])
    },
    data () {
        return {
            one: btoa(1),
            two: btoa(2),
        }
    },
    components: {
        Carousel,
        Slide
    },
    methods: {
        ...mapActions([
            'SET_CART',
        ]),
        addToCart (productId, price) {
            this.$parent.addToCart(productId, price)
        },
        // getPostBody (post) {
        //     // for substring of long product name
        //     let body = this.stripTags(post);
        //     return body.length > 50 ? body.substring(0, 30) + '...' : body;           
        // },
        // stripTags (text) {
        //     return text.replace(/(<([^>]+)>)/ig, '');
        // }
    }
}
</script>

<style>

</style>
