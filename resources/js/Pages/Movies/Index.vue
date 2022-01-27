<template>
    <Head title="My Movies" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <inertia-link :href="route('dashboard')"><i class="far fa-long-arrow-alt-left"></i> back to Dashboard</inertia-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12"><h1>My Movies</h1></div>
            </div>
            <div class="row" v-if="message">
                <div class="col-12 alert alert-success">{{ message }}</div>
            </div>
            <div class="row mt-4" v-if="userMovies && userMovies.length > 0">
                <div class="col-12">
                    <div v-for="(movie, index) in userMovies" :key="index">
                        <app-movie :movie="movie" :count="index"></app-movie>
                    </div>
                </div>
            </div>
            <div class="row mt-4" v-else>
                <div class="col-12">No movies added yet. <inertia-link :href="route('movies.create')"> Add a new movie </inertia-link></div>
            </div>
        </div>
    </the-main>
</template>
<script>
import { defineComponent } from "vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import TheMain from "@/Shared/TheMain";
import AppMovie from "@/Shared/AppMovie";

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
        AppMovie,
    },
    layout: AppLayout,
    computed: {
        userMovies() {
            return this.$page.props.userMovies;
        },
    },
});
</script>
<style lang="scss" scoped></style>
