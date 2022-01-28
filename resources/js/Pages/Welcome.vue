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

            <div class="row mt-5" v-if="errorMessage">
                <div class="col-12">
                    <div class="alert alert-danger" v-html="errorMessage"></div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <form id="searchForm" @submit.prevent="searchProducts">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="minPrice">Min Price</label>
                                <input id="minPrice" type="number" min="0" max="10000" v-model="minPrice" class="form-control" placeholder="Min Price" />
                            </div>
                            <div class="col-sm-2">
                                <label for="maxPrice">Max Price</label>
                                <input id="maxPrice" type="number" min="0" max="10000" v-model="maxPrice" class="form-control" placeholder="Max Price" />
                            </div>
                            <div class="col-sm-2">
                                <label for="minReviews">Min Reviews</label>
                                <input id="minReviews" type="number" min="0" max="1000" v-model="minReviews" class="form-control" placeholder="Min Reviews" />
                            </div>
                            <div class="col-sm-2">
                                <label for="maxReviews">Max Reviews</label>
                                <input id="maxReviews" type="number" min="0" max="1000" v-model="maxReviews" class="form-control" placeholder="Max Reviews" />
                            </div>
                            <div class="col-sm-2">
                                <label for="minDate">Min Date</label>
                                <input id="minDate" type="text" v-model="minDate" class="form-control" placeholder="d/m/Y" />
                            </div>
                            <div class="col-sm-2">
                                <label for="maxDate">Max Date</label>
                                <input id="maxDate" type="text" v-model="maxDate" class="form-control" placeholder="d/m/Y" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="sortProducts">Sort products by</label>
                                <select id="sortProducts" v-model="sortFilter" class="form-select" aria-label="Sort products by">
                                    <option value="1" selected>Price &#8595;</option>
                                    <option value="2">Price &#8593;</option>
                                    <option value="3">Date listed &#8595;</option>
                                    <option value="4">Date listed &#8593;</option>
                                    <option value="5">Reviews &#8595;</option>
                                    <option value="6">Reviews &#8593;</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <div class="searchProducts" @click="searchProducts">Search</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-2" v-if="searching">
                <div class="col-12"><img src="img/LoaderIcon.gif" /> Querying 6m records ...</div>
            </div>
            <div class="mt-4" v-if="products && !searching">
                <div v-for="(product, index) in products" :key="index">
                    <app-product :product="product" :count="index" source="home"></app-product>
                </div>
            </div>
            <div class="row mt-4" v-if="products && !searching">
                <div class="col-12 text-center paginationLinks">
                    <div>Page: {{ currentPage }}</div>

                    <i v-if="currentPage > 1" class="far fa-arrow-alt-circle-left" @click="changePage(false)"></i>
                    <i v-if="nextPage" class="far fa-arrow-alt-circle-right" @click="changePage(true)"></i>
                </div>
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

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
        AppProduct,
    },
    layout: AppLayout,
    setup() {
        const products = ref(null);
        const paginationLinks = ref(null);
        const currentPage = ref(1);
        const nextPage = ref(null);
        const minPrice = ref(0);
        const maxPrice = ref(10000);
        const minReviews = ref(0);
        const maxReviews = ref(1000);
        const minDate = ref("01/01/2018");
        const maxDate = ref("31/01/2022");
        const sortFilter = ref(1);
        const searching = ref(null);
        const errorMessage = ref("");

        //Search for a product
        function searchProducts() {
            currentPage.value = 1;
            getProducts();
        }

        //Get products from the database
        function getProducts() {
            searching.value = true;
            errorMessage.value = "";
            axios({
                method: "post",
                url: route("products.search"),
                data: {
                    page: currentPage.value,
                    minPrice: minPrice.value,
                    maxPrice: maxPrice.value,
                    minReviews: minReviews.value,
                    maxReviews: maxReviews.value,
                    minDate: minDate.value,
                    maxDate: maxDate.value,
                    sort: sortFilter.value,
                },
            })
                .then((response) => {
                    //assign values from response
                    products.value = response.data.data;
                    paginationLinks.value = response.data.links;
                    searching.value = false;
                    nextPage.value = response.data.next_page_url;
                })
                .catch((error) => {
                    //Display validation errors
                    if (error.response.data.error) {
                        const errors = error.response.data.error;
                        errorMessage.value = "";
                        for (const [key, value] of Object.entries(errors)) {
                            errorMessage.value += `${key}: ${value}<br>`;
                        }
                    }

                    searching.value = false;
                });
        }

        //Modify Current Page
        function changePage(isNext = true) {
            return isNext ? currentPage.value++ : currentPage.value--;
        }

        //Watch for changes in current page in order to refresh the products list
        watch(
            [currentPage],
            () => {
                getProducts();
            },
            { immediate: true }
        );

        return {
            products,
            paginationLinks,
            currentPage,
            nextPage,
            minPrice,
            maxPrice,
            minReviews,
            maxReviews,
            minDate,
            maxDate,
            sortFilter,
            searching,
            searchProducts,
            getProducts,
            changePage,
            errorMessage,
        };
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
.paginationLinks {
    color: $appBlack;
    i {
        font-size: 30px;
        color: $appRed;
        cursor: pointer;
        padding: 15px 10px;
    }
}

.searchProducts {
    font-size: 15px;
    font-weight: 700;
    background-color: $appRed;
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    display: inline-block;
    margin-top: 30px;
    text-align: center;
    cursor: pointer;
}
</style>
