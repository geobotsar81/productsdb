<template>
    <Head title="Dashboard" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12"><h1>Dashboard</h1></div>
            </div>
            <div class="row mt-4"><div class="col-12">Welcome to your dashboard, use the links below to handle your movies</div></div>
            <div class="row mt-4">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <ul>
                                <li><inertia-link :href="route('movies.index')"> My Movies </inertia-link></li>
                                <li><inertia-link :href="route('movies.create')"> Add Movie </inertia-link></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </the-main>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TheMain from "@/Shared/TheMain";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        AppLayout,
        TheMain,
        InertiaLink,
    },
    layout: AppLayout,
});
</script>
