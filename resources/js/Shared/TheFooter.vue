<template>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12"><h2>TheMovieDB</h2></div>
            </div>
            <div class="row footer__copyrights">
                <div class="col-12">© George Botsaris - {{ currentYear }}</div>
            </div>
        </div>
    </footer>
</template>
<script>
export default {
    data() {
        return {
            currentYear: this.$page.props.currentYear,
        };
    },
};
</script>
<style lang="scss" scoped>
.footer {
    padding: 60px 0px 20px 0px;
    color: #fff;
    background-color: $appBlack;
    min-height: 200px;
    text-align: center;

    h2 {
        color: #fff;
        font-size: 60px;
        font-weight: 700;
    }
}
.footer__copyrights {
    font-size: 16px;
}
</style>
