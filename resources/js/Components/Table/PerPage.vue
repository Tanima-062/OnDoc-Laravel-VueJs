<template>
    <div class="per-page flex gap-4 items-center px-5">
        <p class="text-base m-0 text-18">{{ $t('Entries per page:') }}</p>

        <div class="wrapper relative">
            <div class="selected-option w-[67px] h-[48px] bg-white rounded-[8px] flex justify-center items-center text-base text-18 cursor-pointer" @click="toggle">{{perPage ?? 15}}</div>
            <div
                class="options absolute bg-white w-max divide-y divide-black-1 bottom-[115%] rounded-[8px] overflow-hidden cursor-pointer shadow-md"
                v-click-away="() => active = false" v-if="active"
            >
                <div class="option bg-white py-3 px-5" :class="{active: perPage == 15}" @click="setPerPage(15)">15</div>
                <div class="option bg-white py-3 px-5" :class="{active: perPage == 25}" @click="setPerPage(25)">25</div>
                <div class="option bg-white py-3 px-5" :class="{active: perPage == 50}" @click="setPerPage(50)">50</div>
                <div class="option bg-white py-3 px-5" :class="{active: perPage == 100}" @click="setPerPage(100)">100</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import {computed, ref} from "@vue/reactivity"

const props = defineProps({
    routeName: {
        type: String,
        required: true,
    }
})

const active = ref(false)

const perPage = computed(() => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    return params.per_page
})

const setPerPage = (value) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.per_page = value
    delete params.page
    Inertia.visit(route(props.routeName, params))
}

const toggle = () => {
    active.value = !active.value
}

</script>
