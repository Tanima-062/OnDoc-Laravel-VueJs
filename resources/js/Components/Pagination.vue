<template>
    <div class="pagination flex gap-2" v-if="paginationData.current_page == 1 && !paginationData.next_page_url">
    </div>

    <div class="pagination flex gap-2" v-else>
        <Link
            class="bg-white w-12 h-12 flex justify-center items-center rounded-[8px]"
            :href="paginationData.prev_page_url"
            v-if="paginationData.prev_page_url"
            preserve-scroll
            preserve-state
        >
        <LeftArrow />
        </Link>
        <template v-for="(link, index) in paginationData.links">
            <Link
                class="bg-white w-12 h-12 flex justify-center items-center rounded-[8px] text-base text-18 font-montserrat"
                :class="{ 'bg-sky-2': link.active }"
                :key="`link-${index}`"
                :href="link.url"
                v-html="link.label"
                v-if="index != 0 && index != paginationData.links.length - 1"
                preserve-scroll
                preserve-state
            >
            </Link>
        </template>

        <Link
            class="bg-white w-12 h-12 flex justify-center items-center rounded-[8px]"
            :href="paginationData.next_page_url"
            v-if="paginationData.next_page_url"
            preserve-scroll
            preserve-state
        >
        <RightArrow />
        </Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import RightArrow from "./Icons/RightArrow.vue";
import LeftArrow from "./Icons/LeftArrow.vue";

defineProps({
    paginationData: {
        type: Object,
        required: true,
    },
})
</script>
