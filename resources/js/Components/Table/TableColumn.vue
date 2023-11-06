<template>
    <div class="column flex font-bold text-20 text-base py-6 gap-[8px]">
        <slot name="column">
            <span>
                <slot />
            </span>
            <SortIcon
                class="cursor-pointer"
                @click="sort"
            />
        </slot>
    </div>
</template>

<script setup>
import SortIcon from '../Icons/SortIcon.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    routeName: {
        type: String,
    },
    columnName: {
        type: String,
    }
})

const sort = () => {
    const currentFilterParams = Object.fromEntries(new URLSearchParams(location.search))
    let direction = currentFilterParams.order_by == props.columnName ? currentFilterParams.direction == "ASC" ? "DESC" : "ASC" : "ASC"

    currentFilterParams.order_by = props.columnName
    currentFilterParams.direction = direction
    Inertia.visit(route(props.routeName, currentFilterParams))
}
</script>
