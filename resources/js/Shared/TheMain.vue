<template>
    <main id="main">
        <slot></slot>
    </main>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
main {
    font-size: 18px;
    line-height: 24px;
    font-weight: 400;
    padding: 120px 0px;
    color: $appBlack;
    min-height: calc(100vh - 200px);
    position: relative;
    text-align: left;

    :deep(a) {
        color: $appRed;
        text-decoration: none;
        transition: $appTransition;

        &:hover,
        &:focus {
            color: $appBlack;
        }
    }

    :deep(ul, ol) {
        li {
            padding: 5px 0px;
        }
    }
}

@media (max-width: 575.98px) {
    main {
        text-align: center;
    }
}
</style>
