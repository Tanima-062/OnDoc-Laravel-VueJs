<template>
    <button
        class="w-[127px] h-[48px] bg-white rounded-[8px] flex items-center gap-[19px] pl-[15px] text-base text-18 font-bold"
        :class="{ active: showFilter, 'border-tints-2': showFilter, 'border-0': !showFilter }"
        @click="toggleFilter"
    >
        <filter-icon fill="currentColor" />
        <span>{{ $t('Filter') }}</span>
    </button>
</template>

<script>
import FilterIcon from '../Icons/FilterIcon.vue';
export default {
    components: {
        FilterIcon,
    },
    data() {
        return {
            showFilter: this.$attrs.showFilter ?? false,
        };
    },

    methods: {
        toggleFilter() {
            this.showFilter = !this.showFilter;
            this.$emit("toggleShowFilter", this.showFilter);
        },
    },
};
</script>

<style lang="scss" scoped>

</style>
