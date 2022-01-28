<template>
    <div class="row align- align-items-center product" :class="productClass">
        <div class="col-sm-2">
            <div class="product__image"><i class="fab fa-amazon"></i></div>
        </div>
        <div class="col-sm-6 mt-2 mt-sm-0">
            <div class="row">
                <div class="col-12 product__rating">{{ product.rating }}/10</div>
            </div>
            <div class="row">
                <div class="col-12 product__title">{{ product.title }} - €{{ product.price }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-12 product__reviews">{{ product.reviews }} reviews</div>
            </div>
            <div class="row mt-2">
                <div class="col-12 product__date">added {{ product.date_listed }}</div>
            </div>
        </div>
        <div class="col-sm-4 product__links" v-if="source != 'product'">
            <inertia-link :href="route('products.show', product.id)"> View </inertia-link>
        </div>
    </div>
</template>
<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";
export default {
    components: { InertiaLink },
    props: {
        product: {
            type: Object,
            required: true,
        },
        count: {
            type: Number,
            required: true,
        },
        source: {
            type: String,
            required: false,
        },
    },
    data() {
        return {
            loggeInUser: this.$page.props.user,
            storageUrl: this.$page.props.storageUrl,
        };
    },
    computed: {
        productClass() {
            return this.count % 2 == 0 ? "odd" : "even";
        },
    },
};
</script>
<style lang="scss" scoped>
.product {
    padding: 10px 0px;

    &.even {
        background-color: $appLightGrey;
        border-top: solid 1px $appLightGrey2;
        border-bottom: solid 1px $appLightGrey2;
    }
    &:hover,
    &:focus {
        background-color: $appYellow;
    }
}

.product__image {
    background-color: $appBlack;
    text-align: center;
    height: 150px;

    i {
        color: $appGreen;
        font-size: 60px;
        padding-top: 40px;
    }
}
.product__links {
    text-align: right;
    a {
        font-size: 15px;
        font-weight: 700;
        background-color: $appRed;
        color: #fff;
        padding: 10px 20px;
        border-radius: 25px;
    }
}
.product__title {
    font-weight: 500;
    color: $appBlack;
}
.product__rating {
    font-style: italic;
    font-size: 14px;
    font-weight: 700;
    color: $appOrange;
}
.product__reviews {
    font-size: 14px;
    font-weight: 700;
    color: $appRed;
}
.product__date {
    font-size: 14px;
    color: $appBlack;
}
@media (max-width: 575.98px) {
    .product,
    .product__links {
        text-align: center;
    }
}
</style>
