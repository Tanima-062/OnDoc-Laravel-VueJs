<template>
    <div class="filter-box w-[285px] absolute p-4 bg-white rounded-[8px] top-[120%] text-base flex flex-col z-[1] shadow-md">
        <slot />
        <button
            class="font-bold text-[12px] leading-[11px] ml-auto mt-4"
            @click="reset"
        >{{ $t('Reset') }}</button>
    </div>
</template>

<script setup>
import { computed } from '@vue/reactivity';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    excludeColumns: {
        type: Array,
        default: [],
    },

    routeName: {
        type: String,
        required: false,
    }
})

const excludeColumns = computed(() => {
    return ['order_by', 'direction', 'per_page', ...props.excludeColumns]
})
const reset = () => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    for (const filter in params) {
        if (excludeColumns.value.includes(filter))
            continue
        delete params[filter]
    }
    const path = location.href.split(/[?#]/)[0]
    Inertia.visit(props.routeName ? route(props.routeName) : path, {
        data: params,
    })
}
</script>
