<template>
    <div>
        <div class="product-big-title-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-bit-title text-center">
                            <h2>{{ $t('products') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page title area -->
        <div class="container">
            <div class="item_product_detail">
                <div class="product_image">
                    <!-- <img :src="productDetail.product_other_image" alt=""> -->
                    <ProductZoomer :base-images="images" :base-zoomer-options="zoomerOptions" style="width: 90%" />
                </div>
                <div class="product_discription">
                    <h4><a>{{ $i18n.locale == 'ar' ? productDetail.product_name_arabic : productDetail.product_name }}</a></h4>
                    <!-- <h4 class="brand">Brand</h4> -->
                    <!-- <div class="star_rating">
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="fas fa-star"></i></a>
                        <a href="#"><i class="far fa-star"></i></a>
                        <a href="#"><i class="far fa-star"></i></a>
                    </div> -->
                    <!-- <h4>Weight</h4> -->
                    <div class="">
                        <div class="single-shop-product">
                            <div v-if="productOtherData && productOtherData.length > 0">
                                <div class="" v-for="(attribute, index) in productOtherData" :key="index">
                                    <label>
                                        
                                        <input type="radio" name="price" v-if="attribute.child_attributes != null" @click="changePrice(attribute.id, attribute.price, attribute.sale_price)"> {{ attribute.child_attributes != null ? attribute.child_attributes.replace(/,/g, ' - ') : '' }}
                                    </label>

                                </div>

                            </div>
                        </div>
                    </div>
                    <h4>{{ $t('quantity') }}</h4>
                    <div class="detail_prod">
                        <div class="product_quantity buttons_added">
                            <input type="button" class="minus quantity-left-minus btn btn-danger btn-number" value="-" @click="removeCart">

                            <input type="number" size="4" class="input-text qty txt" min="1" title="Qty"  v-model="quantity" >

                            <input type="button" class="plus quantity-right-plus btn btn-success btn-number" value="+" @click="addCart">
                        </div>
                    </div>

                    <h3 class="price_tag">
                                <span class="price line_above">{{ $t('aed') }} {{ productDetail.price }}</span>
                                <span class="discount_price">({{ $t('aed') }} {{ productDetail.sale_price ? productDetail.sale_price : productDetail.price }})</span>
                            </h3>
                    <div class="pad_adjust_copy">
                        {{productDetail.id}}
                        <input type="submit" class="btn btn-warning btn-block" :value="$t('addToCart')" @click="addToCart(productDetail.id, productDetail.sale_price ? productDetail.sale_price : productDetail.price, quantity)">
                    </div>

                </div>
            </div>
            <div class="panel panel-default">
                <ul class="nav nav-tabs prod_detail">
                    <li class="active"><a data-toggle="tab" href="#discription">{{ $t('description') }}</a></li>
                    <!-- <li><a data-toggle="tab" href="#review">{{ $t('review') }}</a></li> -->
                </ul>
                <div class="panel-body">
                    <div class="tab-content tab-product-detail">
                        <div id="discription" class="tab-pane fade in active">
                            <h4>{{ $t('description') }}</h4>
                            <p v-html="$i18n.locale == 'ar' ? productDetail.product_description_arabic : productDetail.product_description"></p>
                        </div>
                        <div id="review" class="tab-pane fade">
                            <h4>{{ $t('review') }}</h4>
                            <div class="btn_review">
                                <button type="button" class="create_btn" data-toggle="modal" data-target="#myModal">{{ $t('writeReview') }}</button>
                            </div>

                            <form id="shipping_form" class="shipping_form">
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">{{ $t('createShippingAddress') }}</h4>
                                            </div>
                                            <div class="modal-body">

                                                <div class="fast_last">
                                                    <div class="form-group">
                                                        <!-- Full Name -->
                                                        <label for="full_name_id1" class="control-label">{{ $t('firstName') }}</label>
                                                        <input type="text" class="form-control" id="full_name_id1" name="full_name" :placeholder="$t('firstName')" data-vv-name="firstName" v-validate="'required'" />
                                                    </div>

                                                    <div class="form-group ">
                                                        <!-- Full Name -->
                                                        <label for="full_name_id" class="control-label">{{ $t('lastName') }}</label>
                                                        <input type="text" class="form-control" id="full_name_id" name="full_name" :placeholder="$t('lastName')" data-vv-name="lastName" v-validate="'required'" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <!-- Street 1 -->
                                                    <label for="street1_id" class="control-label">{{ $t('email') }}</label>
                                                    <input type="text" class="form-control" id="street1_id" name="street1" :placeholder="$t('email')" data-vv-name="address" v-validate="'required'" />

                                                </div>
                                                <div class="form-group">
                                                    <!-- area 2 -->
                                                    <label for="area_id" class="control-label">{{ $t('rating') }}</label>
                                                    <!-- <div class="star_rating">
                                                        <a href="#"><i class="fas fa-star"></i></a>
                                                        <a href="#"><i class="fas fa-star"></i></a>
                                                        <a href="#"><i class="fas fa-star"></i></a>
                                                        <a href="#"><i class="far fa-star"></i></a>
                                                        <a href="#"><i class="far fa-star"></i></a>
                                                    </div> -->
                                                </div>

                                                <div class="form-group">
                                                    <!-- area 2 -->
                                                    <label for="area_id" class="control-label">{{ $t('reviewTitle') }}</label>
                                                    <input type="text" class="form-control" id="area_id" name="area" :placeholder="$t('reviewTitle')" />
                                                </div>

                                                <div class="form-group">
                                                    <!-- Zip Code-->
                                                    <label for="zip_id" class="control-label">{{ $t('writereview') }}</label>
                                                    <textarea type="text" class="form-control" id="zip_id" name="pincode" :placeholder="$t('writeyourreview')" data-vv-name="pinCode" v-validate="'required'"></textarea>

                                                </div>

                                            </div>
                                            <div class="modal-footer shipping_btn">
                                                <button type="button" class="btn btn-default" id="close_model" data-dismiss="modal">{{ $t('close') }}</button>

                                                <button type="submit" class=" " :value="$t('save')">{{ $t('save') }}</button>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            <h2>{{ $t('reviewTitle') }}</h2>
                            <h5> <i>{{ $t('nameNDate') }} </i></h5>
                            <div class="star_rating">
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="fas fa-star"></i></a>
                                <a href="#"><i class="far fa-star"></i></a>
                                <a href="#"><i class="far fa-star"></i></a>
                            </div>
                            <blockquote>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapMutations, mapState, mapGetters, mapActions } from 'vuex';
import PicZoom from 'vue-piczoom'
export default {
    computed: {
        ...mapState([
            'isActive',
            'products',
        ]),
    },
    components: {
        PicZoom
    },
    data () {
        return {
            productKey: 0,
            productDetail: [],
            attributes: [],
            productChild: [],
            productOtherData: [],
            images: {
                thumbs:[{
                    id: 0,
                    url: this.$session.get('productImage'),
                }],
                normal_size: [{
                    id: 0,
                    url: this.$session.get('productImage'),
                }],
                large_size: [{
                    id: 0,
                    url: this.$session.get('productImage'),
                }],
            },
            zoomerOptions: {
                zoomFactor: 4,
                pane: 'container',
                hoverDelay: 300,
                namespace: 'container-zoomer',
                move_by_click:true,
                scroll_items: 4,
                choosed_thumb_border_color: "#ff3d00"
            },
            quantity: 1,
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
            'SET_RECENTLY_VIEWS',
        ]),
        ...mapActions([
            'SET_CART',
            'ACTION_ACTIVE_CLASS',
            'ACTION_PUSH_SUCCESS',
            'ACTION_PUSH_ERROR',
        ]),
        setIsActive () {
            var currentUrl = window.location.pathname;
            this.ACTION_ACTIVE_CLASS('product')
            
        },
        productDetails() {
            // alert(this.$route.params.id)
            // conasole.log(id, 'id')
            this.recentlyViews(this.$route.params.id)
            if (this.$route.params.id) {
                axios.get('/api/products/'+ this.$route.params.id)
                .then (response => {
                    var str = response.data.product.product_other_image
                    var str_array = str.split(',')
                    response.data.product.product_other_image = str_array[0]
                    response.data.product.price = response.data.data[0].price
                    response.data.product.sale_price = response.data.data[0].sale_price
                    this.productDetail = response.data.product
                    this.productOtherData = response.data.child
                    this.productDetail.id = response.data.child[0].id
                    for (let index = 1; index < str_array.length; index++) {
                        const element = str_array[index];
                        this.images.thumbs.push({
                            id: index,
                            url: element,
                        })
                        this.images.normal_size.push({
                            id: index,
                            url: element,
                        })
                        this.images.large_size.push({
                            id: index,
                            url: element,
                        })
                    }
                })
            }  
        },
        changePrice (productId, price, sale_price) {
            // var test = this.productChild.find(product => product.id == productChildId)
            this.productDetail.id = productId
            this.productDetail.price = price
            this.productDetail.sale_price = sale_price
        },
        addToCart (productId, price, quantity) {
            if (quantity == 0) {
                this.ACTION_PUSH_ERROR(this.$t('cartMustBeGreateThanZero'))
                this.quantity = 1
            } else {
                this.$parent.addToCart(productId, price, parseInt(quantity))
            }
        },
        recentlyViews (productId) {
            // localStorage.removeItem("recentlyViews")
            var recentlyViews = JSON.parse(localStorage.getItem("recentlyViews")) || {};
            var recentArray = []
            var isExist = false;
            if (recentlyViews != undefined && recentlyViews.length > 0) {
                recentArray = recentlyViews
                recentArray.forEach((element,index) => {
                    if(element.productId == productId) {
                        isExist = true
                        return;
                    }
                });
                if (!isExist) {
                    console.log(recentlyViews, 'recentlyViews extiser')
                    recentArray[recentlyViews.length] = {
                        productId, // shorthand for `productPrice: productPrice,`
                    }; 
                    localStorage.setItem("recentlyViews", JSON.stringify(recentArray));
                    this.SET_RECENTLY_VIEWS(recentArray)
                }
            } else {
                recentArray[0] = {
                    productId, // shorthand for `productPrice: productPrice,`
                };
                localStorage.setItem("recentlyViews", JSON.stringify(recentArray));
                this.SET_RECENTLY_VIEWS(recentArray)
            }
            // console.log(localStorage.getItem("recentlyViews"))

        },
        removeCart () {
            if (this.quantity > 1) {
                this.quantity = (parseInt(this.quantity) - 1)
            }
        },
        addCart () {
            this.quantity = (parseInt(this.quantity) + 1)
        },
    }
}
</script>

<style>

</style>
