<template>
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6 col-lg-4 text-center text-sm-start">
                    <inertia-link :href="route('home')" class="logo"> TheMovieDB </inertia-link>
                </div>
                <div class="col-sm-6 col-lg-8 text-center text-sm-end">
                    <template v-if="$page.props.user">
                        <div class="row">
                            <div class="col-12">
                                Welcome <strong>{{ $page.props.user.name }}</strong>
                            </div>
                        </div>
                        <inertia-link :href="route('dashboard')"> Dashboard </inertia-link> |
                        <inertia-link :href="route('logout')" method="post"> Logout </inertia-link>
                    </template>
                    <template v-else>
                        <inertia-link :href="route('login')" class="pe-2"> Log in </inertia-link> |
                        <inertia-link :href="route('register')"> Register </inertia-link>
                    </template>
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
