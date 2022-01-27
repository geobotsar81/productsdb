<template>
    <Head :title="movie.title + '-' + movie.year" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <inertia-link :href="route('home')"><i class="far fa-long-arrow-alt-left"></i> back to home page</inertia-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <h1>{{ movie.title }} - {{ movie.year }}</h1>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-6 col-lg-3"><img class="img-fluid" :src="storageUrl + '/' + movie.image" /></div>
            </div>
            <div class="row mt-4">
                <div class="col-12">{{ movie.description }}</div>
            </div>
        </div>
    </the-main>
</template>
<script>
import { defineComponent } from "vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import TheMain from "@/Shared/TheMain";

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
    },
    layout: AppLayout,
    data() {
        return {
            movie: this.$page.props.movie,
            storageUrl: this.$page.props.storageUrl,
        };
    },
});
</script>
