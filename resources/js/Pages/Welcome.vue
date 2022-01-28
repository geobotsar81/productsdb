<template>
    <Head title="Welcome" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12"><h1>Welcome to TheProductDB</h1></div>
            </div>

            <div class="row mt-4">
                <div class="col-12">Visit the <inertia-link :href="route('products.statistics')">Statistics</inertia-link> section for some insights regarding our products</div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <form id="searchForm" @submit.prevent="searchProducts">
                        <div class="row">
                            <div class="col-sm-8">
                                <label for="searchProducts">Search products</label>
                                <input id="searchProducts" type="text" v-model="searchFilter" class="form-control searchProducts" placeholder="Search Product DB(Type your query and press enter)" />
                            </div>
                            <div class="col-sm-4">
                                <label for="sortProducts">Sort products by</label>
                                <select id="sortProducts" v-model="sortFilter" class="form-select" aria-label="Sort products by">
                                    <option value="1" selected>Price</option>
                                    <option value="2">Date listed</option>
                                    <option value="3">Reviews</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-2" v-if="searching">
                <div class="col-12"><img src="img/LoaderIcon.gif" /></div>
            </div>
            <div class="mt-4" v-if="products && !searching">
                <div v-for="(product, index) in products" :key="index">
                    <app-product :product="product" :count="index" source="home"></app-product>
                </div>
                <app-pagination :currentPage="currentPage" :links="paginationLinks" v-model="currentPage" />
            </div>
        </div>
    </the-main>
</template>

<style scoped></style>

<script>
import { ref, watch, defineComponent } from "vue";
import { Head, InertiaLink } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import TheMain from "@/Shared/TheMain";
import AppProduct from "@/Shared/AppProduct";
import AppPagination from "@/Shared/AppPagination";

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
        AppProduct,
        AppPagination,
    },
    layout: AppLayout,
    setup() {
        const products = ref(null);
        const paginationLinks = ref(null);
        const currentPage = ref(1);
        const searchFilter = ref(null);
        const sortFilter = ref(1);
        const searching = ref(null);

        //Search for a product
        function searchProducts() {
            currentPage.value = 1;
            getProducts();
        }

        //Get products from the database
        function getProducts() {
            searching.value = true;
            axios({
                method: "post",
                url: route("products.paginated"),
                data: {
                    page: currentPage.value,
                    search: searchFilter.value,
                    sort: sortFilter.value,
                },
            })
                .then((response) => {
                    products.value = response.data.data;
                    paginationLinks.value = response.data.links;
                    searching.value = false;
                })
                .catch((error) => {
                    searching.value = false;
                });
        }

        //Watch for changes in search or sort filters in order to refresh the products list
        watch(
            [searchFilter, sortFilter],
            () => {
                searchProducts();
            },
            { immediate: true }
        );

        //Watch for changes in current page in order to refresh the products list
        watch([currentPage], () => {
            getProducts();
        });

        return { products, paginationLinks, currentPage, searchFilter, sortFilter, searching, searchProducts, getProducts };
    },
});
</script>
<style lang="scss" scoped>
.searchProducts {
    width: 100%;
}
label {
    font-size: 14px;
}
</style>
