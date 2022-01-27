<template>
    <div class="row align- align-items-center movie" :class="movieClass">
        <div class="col-sm-2">
            <img v-if="movie.image" height="120" :src="storageUrl + '/' + movie.image" />
        </div>
        <div class="col-sm-4 mt-2 mt-sm-0">
            <div class="row">
                <div class="col-12 movie__title">{{ movie.title }} - {{ movie.year }}</div>
            </div>
            <div class="row" v-if="movie.user">
                <div class="col-12 movie__owner">by {{ movie.user.name }}</div>
            </div>
            <div class="row">
                <div class="col-12 movie__date">{{ movie.formated_created }}</div>
            </div>
        </div>
        <div class="col-sm-6 movie__links">
            <inertia-link :href="route('movies.show', movie.id)"> View </inertia-link>
            <span v-if="loggeInUser && loggeInUser.id == movie.user_id && source != 'home'">
                | <inertia-link :href="route('movies.edit', movie.id)"> Edit </inertia-link> | <inertia-link method="post" :href="route('movies.destroy', movie.id)"> Delete </inertia-link>
            </span>
        </div>
    </div>
</template>
<script>
import { InertiaLink } from "@inertiajs/inertia-vue3";
export default {
    components: { InertiaLink },
    props: {
        movie: {
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
        movieClass() {
            return this.count % 2 == 0 ? "odd" : "even";
        },
    },
};
</script>
<style lang="scss" scoped>
.movie {
    padding: 10px 0px;

    img {
        padding-right: 10px;
        border: solid 1px $appLightGrey;
        padding: 0px;
    }

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
.movie__links {
    text-align: right;
    a {
        font-size: 15px;
        font-weight: 700;
    }
}
.movie__title {
    font-weight: 700;
}
.movie__owner {
    font-style: italic;
    font-size: 14px;
}
.movie__date {
    font-size: 14px;
    color: $appGrey2;
}
@media (max-width: 575.98px) {
    .movie,
    .movie__links {
        text-align: center;
    }
}
</style>
