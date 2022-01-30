<template>
    <Head title="Welcome" />
    <the-main id="main">
        <div class="container">
            <div class="row">
                <div class="col-12"><h1>Statistics</h1></div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    Seeded data: <strong>Price Range:</strong>10 - 10,000 | <strong>Reviews Range:</strong>0 - 1,000 | <strong>Ratings Range:</strong>0 - 10 | <strong>Date Range:</strong>last 2 years
                </div>
            </div>

            <div class="row mt-4" v-if="errorMessage">
                <div class="col-12">
                    <div class="alert alert-danger" v-html="errorMessage"></div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <form id="searchForm" @submit.prevent="getStatistics">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <label for="minPrice">Min Price</label>
                                <input id="minPrice" type="number" min="0" max="10000" v-model="minPrice" class="form-control" placeholder="Min Price" />
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label for="maxPrice">Max Price</label>
                                <input id="maxPrice" type="number" min="0" max="10000" v-model="maxPrice" class="form-control" placeholder="Max Price" />
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label for="minReviews">Min Reviews</label>
                                <input id="minReviews" type="number" min="0" max="1000" v-model="minReviews" class="form-control" placeholder="Min Reviews" />
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label for="maxReviews">Max Reviews</label>
                                <input id="maxReviews" type="number" min="0" max="1000" v-model="maxReviews" class="form-control" placeholder="Max Reviews" />
                            </div>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-sm-6 col-lg-3">
                                <label for="minDate">Min Date</label>
                                <input id="minDate" type="text" v-model="minDate" class="form-control" placeholder="d/m/Y" />
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <label for="maxDate">Max Date</label>
                                <input id="maxDate" type="text" v-model="maxDate" class="form-control" placeholder="d/m/Y" />
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="row">
                                    <div class="col-12"><span class="searchProductsBtn" @click="getStatistics">Search</span></div>
                                </div>
                                <div class="row mt-1"><div class="col-12">Just click search to see some magic happening!</div></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <div class="col-12">
                    <!--Total Stats-->
                    <div class="row mt-2" v-if="searchingTotal">
                        <div class="col-12"><img src="img/LoaderIcon.gif" /> Querying 6m records ...Average waiting time 2s-10s</div>
                    </div>
                    <div class="row" v-if="statisticsTotal && !searchingTotal">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12"><h2>Total Stats</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-12"><hr /></div>
                            </div>
                            <div class="row">
                                <div class="col-12"><strong>Total Products: </strong>{{ statisticsTotal.totalProducts }}</div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12"><strong>Query Time: </strong>{{ statisticsTotal.totalProductsTime }}</div>
                            </div>
                        </div>
                    </div>
                    <!--Day Stats-->
                    <div class="row mt-2" v-if="searchingDays">
                        <div class="col-12"><img src="img/LoaderIcon.gif" /> Querying 6m records ...Average waiting time 2s-10s</div>
                    </div>
                    <div class="row mt-5" v-if="statisticsChartsDays && !searchingDays">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12"><h2>Products added per week day</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-12"><hr /></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6">
                                    <div class="row" v-for="(day, index) in statisticsChartsDays.days" :key="index">
                                        <div class="col-12">
                                            <strong>{{ getWeekday(day.dataLabel) }}: </strong>{{ day.dataCount }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12"><strong>Query Time: </strong>{{ statisticsChartsDays.totalDaysTime }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <vue3-chart-js type="pie" :data="getChart(statisticsChartsDays.days)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Prices Stats-->
                    <div class="row mt-2" v-if="searchingPrices">
                        <div class="col-12"><img src="img/LoaderIcon.gif" /> Querying 6m records ...Average waiting time 2s-10s</div>
                    </div>
                    <div class="row mt-5" v-if="statisticsChartsPrices && !searchingPrices">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12"><h2>Products per price range</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-12"><hr /></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6">
                                    <div class="row" v-for="(price, index) in statisticsChartsPrices.prices" :key="index">
                                        <div class="col-12">
                                            <strong>{{ price.dataLabel - 999 }} - {{ price.dataLabel }}: </strong>{{ price.dataCount }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12"><strong>Query Time: </strong>{{ statisticsChartsPrices.totalPricesTime }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <vue3-chart-js type="doughnut" :data="getChart(statisticsChartsPrices.prices)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Ratings Stats-->
                    <div class="row mt-2" v-if="searchingRatings">
                        <div class="col-12"><img src="img/LoaderIcon.gif" /> Querying 6m records ...Average waiting time 2s-10s</div>
                    </div>
                    <div class="row mt-5" v-if="statisticsChartsRatings && !searchingRatings">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12"><h2>Products per rating</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-12"><hr /></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6">
                                    <div class="row" v-for="(rating, index) in statisticsChartsRatings.ratings" :key="index">
                                        <div class="col-12">
                                            <span v-if="rating.dataLabel != 0"
                                                ><strong>{{ Number.parseFloat(rating.dataLabel - 0.9).toPrecision(2) }} - {{ rating.dataLabel }}: </strong>{{ rating.dataCount }}</span
                                            >
                                            <span v-else
                                                ><strong>{{ rating.dataLabel }}: </strong>{{ rating.dataCount }}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12"><strong>Query Time: </strong>{{ statisticsChartsRatings.totalRatingsTime }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <vue3-chart-js type="bar" :data="getChart(statisticsChartsRatings.ratings)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Reviews Stats-->
                    <div class="row mt-2" v-if="searchingReviews">
                        <div class="col-12"><img src="img/LoaderIcon.gif" /> Querying 6m records ...Average waiting time 2s-10s</div>
                    </div>
                    <div class="row mt-5" v-if="statisticsChartsReviews && !searchingReviews">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12"><h2>Products per reviews range</h2></div>
                            </div>
                            <div class="row">
                                <div class="col-12"><hr /></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6">
                                    <div class="row" v-for="(review, index) in statisticsChartsReviews.reviews" :key="index">
                                        <div class="col-12" v-if="review.dataLabel != 0">
                                            <strong>{{ review.dataLabel - 99 }} - {{ review.dataLabel }}: </strong>{{ review.dataCount }}
                                        </div>
                                        <div class="col-12" v-else>
                                            <strong>{{ review.dataLabel }}: </strong>{{ review.dataCount }}
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-12"><strong>Query Time: </strong>{{ statisticsChartsReviews.totalReviewsTime }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <vue3-chart-js type="doughnut" :data="getChart(statisticsChartsReviews.reviews)" />
                                </div>
                            </div>
                        </div>
                    </div>
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
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";

export default defineComponent({
    components: {
        Head,
        InertiaLink,
        AppLayout,
        TheMain,
        AppProduct,
        Vue3ChartJs,
    },
    layout: AppLayout,
    setup() {
        const statisticsTotal = ref(null);
        const statisticsChartsDays = ref(null);
        const statisticsChartsPrices = ref(null);
        const statisticsChartsRatings = ref(null);
        const statisticsChartsReviews = ref(null);
        const minPrice = ref(0);
        const maxPrice = ref(5000);
        const minReviews = ref(0);
        const maxReviews = ref(500);
        const minDate = ref("01/01/2019");
        const maxDate = ref("31/01/2022");
        const searchingTotal = ref(null);
        const searchingDays = ref(null);
        const searchingPrices = ref(null);
        const searchingRatings = ref(null);
        const searchingReviews = ref(null);
        const errorMessage = ref("");

        //Get the name of the day
        function getWeekday(day) {
            const weekdays = ["Monday", " Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
            return weekdays[day];
        }

        //Get statistics from the database. To improve performance queries were split into seperate calls
        function getStatistics() {
            getStatisticsData("products.get_statistics_total", "statisticsTotal", "searchingTotal");
            getStatisticsData("products.get_statistics_charts_days", "statisticsChartsDays", "searchingDays");
            getStatisticsData("products.get_statistics_charts_prices", "statisticsChartsPrices", "searchingPrices");
            getStatisticsData("products.get_statistics_charts_reviews", "statisticsChartsReviews", "searchingRatings");
            getStatisticsData("products.get_statistics_charts_ratings", "statisticsChartsRatings", "searchingReviews");
        }

        function getStatisticsData(statisticsRoute, statisticsDataObject, searchIndicator) {
            eval(searchIndicator).value = true;
            errorMessage.value = "";
            axios({
                method: "post",
                url: route(statisticsRoute),
                data: {
                    minPrice: minPrice.value,
                    maxPrice: maxPrice.value,
                    minReviews: minReviews.value,
                    maxReviews: maxReviews.value,
                    minDate: minDate.value,
                    maxDate: maxDate.value,
                },
            })
                .then((response) => {
                    //assign values from response
                    eval(statisticsDataObject).value = response.data;
                    eval(searchIndicator).value = false;
                })
                .catch((error) => {
                    //Display validation errors
                    if (error.response.data.errors) {
                        const errors = error.response.data.errors;
                        errorMessage.value = "";
                        for (const [key, value] of Object.entries(errors)) {
                            errorMessage.value += `${key}: ${value}<br>`;
                        }
                    }

                    eval(searchIndicator).value = false;
                });
        }

        //Generate the Chart
        function getChart(statsValues) {
            const randomColors = getColorArray();
            const data = statsValues;
            const colorsArray = [];
            const dataArray = [];
            const labelsArray = [];

            //Populate the arrays for the chart
            data.forEach(function (item, index) {
                labelsArray.push(item.dataLabel);
                dataArray.push(item.dataCount);
                colorsArray.push("#" + randomColors[index]);
            });

            //Create the chart
            const chart = {
                labels: labelsArray,
                datasets: [
                    {
                        label: "Products Stats",
                        backgroundColor: colorsArray,
                        data: dataArray,
                    },
                ],
            };

            return chart;
        }

        //Assign a colors from a hex array
        function getColorArray() {
            const colors = [
                "ffcdb2",
                "ffb4a2",
                "e5989b",
                "b5838d",
                "6d6875",
                "464d77",
                "36827f",
                "157a6e",
                "499f68",
                "77b28c",
                "9b1d20",
                "3d2b3d",
                "635d5c",
                "cbefb6",
                "d0ffce",
                "17bebb",
                "edb88b",
                "fad8d6",
                "f1bf98",
                "eee5e9",
                "ceec97",
                "f4b393",
                "fc60a8",
                "7a28cb",
                "494368",
                "462255",
                "1d2f6f",
                "8390fa",
                "4c061d",
                "736f4e",
                "000000",
                "839788",
                "eee0cb",
                "baa898",
                "bfd7ea",
                "ed6a5a",
                "8c7284",
                "7a6174",
                "af7a6d",
                "a1683a",
            ];

            const shuffledArray = colors.sort((a, b) => 0.5 - Math.random());

            return shuffledArray;
        }

        return {
            statisticsTotal,
            statisticsChartsDays,
            statisticsChartsPrices,
            statisticsChartsRatings,
            statisticsChartsReviews,
            minPrice,
            maxPrice,
            minReviews,
            maxReviews,
            minDate,
            maxDate,
            searchingTotal,
            searchingDays,
            searchingPrices,
            searchingRatings,
            searchingReviews,
            getStatistics,
            errorMessage,
            getChart,
            getWeekday,
        };
    },
});
</script>
<style lang="scss" scoped>
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

.searchProductsBtn {
    font-size: 15px;
    font-weight: 700;
    background-color: $appRed;
    color: #fff;
    padding: 10px 40px;
    border-radius: 25px;
    display: inline-block;
    margin-top: 30px;
    text-align: center;
    cursor: pointer;
}
</style>
