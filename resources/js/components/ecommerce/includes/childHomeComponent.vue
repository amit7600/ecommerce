<template>
    <div>
        <SliderComponent></SliderComponent>
        <ProductsComponent></ProductsComponent>
    </div>
</template>

<script>
import SliderComponent from './sliderComponent';
import ProductsComponent from '../products/ProductsComponent';
export default {
    components : {
        SliderComponent,
        ProductsComponent,
    },
    data () {
        return {

        }
    },
    methods: {
        addToCart (productId, price, quantity = null) {
            this.$parent.addToCart (productId, price, quantity)
        },
        setImage (image, productId) {
            this.$parent.setImage (image, productId)
        }
    }
}
</script>

<style>

</style>
