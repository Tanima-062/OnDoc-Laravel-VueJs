<template>
    <div class="language-dropdown relative w-[64px]">
        <div
            class="toggler uppercase flex gap-[6px] pl-[14px] py-[10px] h-10 pr-2 bg-primary-3-1 rounded-[5px] items-center text-white text-16 font-bold"
            @click="(show = !show)"
        >
            <DownArrow />
            {{ option.lang }}
        </div>
        <div
            class="language__switches absolute top-[110%] bg-primary-3-1 divide-y divide-y-white text-white text-16 font-bold w-[64px] rounded-[5px]"
            :class="{ hidden: !show }"
            @click="(show = false)"
            v-click-away="() => show = false"
        >
            <button
                class="h-10 w-full flex items-center justify-center"
                @click.prevent="setLang('it')"
            >IT</button>

            <button
                class="h-10 w-full flex items-center justify-center"
                @click.prevent="setLang('de')"
            >DE</button>

            <button
                class="h-10 w-full flex items-center justify-center"
                @click.prevent="setLang('en')"
            >EN</button>

            <button
                class="h-10 w-full flex items-center justify-center"
                @click.prevent="setLang('fr')"
            >FR</button>
        </div>
    </div>
</template>

<script setup>
import { loadLanguageAsync } from "laravel-vue-i18n";
import { reactive } from "@vue/reactivity";
import { usePage } from "@inertiajs/inertia-vue3";
import DownArrow from "./Icons/DownArrow.vue";
import { ref } from "@vue/reactivity"
const emit = defineEmits(['changeLanguage'])
const show = ref(false)
const option = reactive({
    lang: usePage().props.value.language_code ?? localStorage.getItem("lang") ?? "de"
});
const setLang = (lang) => {
    localStorage.setItem("lang", lang);
    option.lang = lang;
    loadLanguageAsync(lang);
    emit("changeLanguage", lang);
};

</script>
