<template>
    <li
        class="h-8 list-none mb-9 flex items-center"
        :class="{ active: isActiveComponent }"
    >
        <Link :href="route(routeName)" class="flex items-center gap-4">
            <slot />
        </Link>
    </li>
</template>

<script setup>
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";

const page = usePage();

const props = defineProps({
    routeName: {
        type: String,
        required: true,
    },
    activeText: {
        type: String,
        required: true,
    },
    relatedComp: {
        type: Array,
        default: [],
    },
});

const isActiveComponent = computed(() => {
    const regex = RegExp(`^(${props.activeText})`);
    return (
        regex.test(page.component.value) ||
        props.relatedComp.includes(page.component.value.split("/")[0])
    );
});
</script>

<style lang="scss" scoped>
.active a {
    color: #7059e2;
}

a {
    font-family: 'Montserrat';
    font-style: normal;
    font-weight: 700;
    font-size: 20px;
    line-height: 24px;


    color: #5d5d60;
    span {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 700;
        font-size: 20px;
        line-height: 24px;

        /* Primary/4/1 */

        color: #5d5d60;
    }
}
svg {
    margin-right: 20px;
}
</style>
