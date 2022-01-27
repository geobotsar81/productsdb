<template>
    <Head :title="product.title + '-' + product.year" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <inertia-link :href="route('home')"><i class="far fa-long-arrow-alt-left"></i> back to home page</inertia-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <app-product :product="product" source="product"></app-product>
                </div>
            </div>
        </div>
    </the-main>
</template>
<script>
import { defineComponent } from "vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import TheMain from "@/Shared/TheMain";
import AppProduct from "@/Shared/AppProduct";

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
        AppProduct,
    },
    layout: AppLayout,
    data() {
        return {
            product: this.$page.props.product,
        };
    },
});
</script>
