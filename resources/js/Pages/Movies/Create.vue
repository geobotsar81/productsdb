<template>
    <Head title="Create a new movie" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <inertia-link :href="route('dashboard')"><i class="far fa-long-arrow-alt-left"></i> back to Dashboard</inertia-link>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12"><h1>Create a new movie</h1></div>
            </div>
            <div class="row mt-4" v-if="formSuccess"><div class="col-12 alert alert-success">Thanks, your movie was successfully submited</div></div>
            <div class="row mt-4">
                <div class="col-12">
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input id="image" class="form-control" type="file" @input="form.image = $event.target.files[0]" />
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">{{ form.progress.percentage }}%</progress>
                            <div class="formError" v-if="$page.props.errors.image">
                                {{ $page.props.errors.image }}
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="title">Title</label>
                            <input type="text" v-model="form.title" class="form-control" id="title" aria-describedby="title" placeholder="Enter movie title" />
                            <small id="titleHelp" class="form-text text-muted">Provide the title for the movie you are adding.</small>
                            <div class="formError" v-if="$page.props.errors.title">
                                {{ $page.props.errors.title }}
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="year">Year</label>
                            <input type="number" min="1800" max="2022" v-model="form.year" class="form-control" id="year" aria-describedby="year" placeholder="Enter year" />
                            <small id="yearHelp" class="form-text text-muted">Provide the year the movie you are adding was created.</small>
                            <div class="formError" v-if="$page.props.errors.year">
                                {{ $page.props.errors.year }}
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="description">Description</label>
                            <textarea v-model="form.description" class="form-control" id="description" rows="10"></textarea>
                            <small id="descriptionHelp" class="form-text text-muted">Provide a short description for the movie you are adding.</small>
                            <div class="formError" v-if="$page.props.errors.description">
                                {{ $page.props.errors.description }}
                            </div>
                        </div>
                        <button type="submit" class="buttonBlack mt-4">Submit</button>
                    </form>
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
import { useForm } from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
    },
    layout: AppLayout,
    setup() {
        const form = useForm({
            title: null,
            image: null,
            year: null,
            description: null,
        });

        const formSuccess = false;

        function submit() {
            this.form.submit("post", route("movies.store"), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset();
                    this.formSuccess = true;
                },
            });
        }

        return { form, formSuccess, submit };
    },
});
</script>
