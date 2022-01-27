<template>
    <Head title="Forgot Password" />
    <the-main id="main">
        <div class="container">
            <jet-authentication-card>
                <div class="mb-4 text-sm text-gray-600">
                    Forgot your password? Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <jet-validation-errors class="mb-4" />

                <form @submit.prevent="submit">
                    <div>
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="email" class="mt-1 form-control" v-model="form.email" required autofocus />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" class="buttonBlack" :disabled="form.processing"> Email Password Reset Link </jet-button>
                    </div>
                </form>
            </jet-authentication-card>
        </div>
    </the-main>
</template>

<script>
import { defineComponent } from "vue";
import { Head } from "@inertiajs/inertia-vue3";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import AppLayout from "@/Layouts/AppLayout";
import TheMain from "@/Shared/TheMain";

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
        AppLayout,
        TheMain,
    },
    layout: AppLayout,
    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route("password.email"));
        },
    },
});
</script>
