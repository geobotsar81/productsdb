<template>
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6 col-lg-4 text-center text-sm-start">
                    <inertia-link :href="route('home')" class="logo"> ProductsDB </inertia-link>
                </div>
                <div class="col-sm-6 col-lg-8 text-center text-sm-end">
                    <inertia-link :href="route('products.statistics')" class="pe-2"> Statistics </inertia-link> |
                    <a href="https://github.com/geobotsar81/productsdb" target="blank"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";

export default {
    components: {
        InertiaLink,
    },
    data() {
        return {};
    },
    props: {},
};
</script>

<style lang="scss" scoped>
.header {
    padding: 15px 45px;
    position: fixed;
    width: 100%;
    left: 0;
    top: 0;
    transition: $appTransition;
    z-index: $zindexHeader;
    border-bottom: 1px solid $appLightGrey2;
    background-color: #fff;

    a {
        color: $appRed;
    }

    i {
        font-size: 18px;
        color: $appBlack;
        margin-left: 5px;
        padding-top: 5px;
    }

    .logo {
        font-size: 16px;
        font-weight: 700;
    }
}
@media (max-width: 575.98px) {
    .header {
        padding: 10px;
    }
}
</style>
