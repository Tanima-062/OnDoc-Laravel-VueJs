<template>
    <div class="flex flex-col pt-7 px-[30px] pb-[30px] items-center w-[600px] h-max bg-white m-auto rounded-[8px] shadow-form border-primary-3-1 border-[1px]" :class="attrs['class']" v-bind:style="attrs['style']">

        <h5 class="title text-20 font-bold text-[#7059E2] text-center mb-4">{{ $t(title) }}</h5>
        <p class="description text-base  text-center w-[75%] mb-12" v-html="$t(description)"></p>

        <div class="flex flex-col gap-5 ">
            <PrimaryButton class="text-white font-bold text-18"  @click="$emit('yesClick')">
                {{ $t(yes_btn_text) }}
            </PrimaryButton>
            <PrimaryButton class="bg-black-3 text-white font-bold text-18"  @click="$emit('noClick')">
                {{ $t(no_btn_text) }}
            </PrimaryButton>
        </div>

    </div>
</template>

<script setup>
import { useAttrs } from "@vue/runtime-core";
import PrimaryButton from "../../PrimaryButton.vue";
import {trans} from "laravel-vue-i18n"

const attrs = useAttrs();
defineProps({
    title: {
        type: String,
        required: false,
        default: trans("Are You Sure")
    },

    description: {
        type: String,
        required: false,
    },

    yes_btn_text: {
        type: String,
        required: false,
        default: trans("Yes")
    },

    no_btn_text: {
        type: String,
        required: false,
        default: trans("No"),
    }
});
</script>

<script>
export default {
    inheritAttrs: false,
    components: { PrimaryButton }
};
</script>



<style lang="scss" scoped>
    .description {
        font-family: 'Montserrat';
font-style: normal;
font-weight: 400;
font-size: 18px;
line-height: 25px;
    }
</style>
