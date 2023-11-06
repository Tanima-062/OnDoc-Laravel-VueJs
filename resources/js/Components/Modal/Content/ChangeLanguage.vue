<template>
    <div
        class="flex flex-col pt-10 px-[30px] pb-[30px] items-center w-[600px] h-max bg-white m-auto rounded-[8px] shadow-form border-primary-3-1 border-[1px]"
        :class="$attrs['class']"
        v-bind:style="$attrs['style']"
    >
        <h5 class="title text-20 font-bold text-[#7059E2] text-center mb-8">{{ $t('Change Language') }}</h5>

        <div class="flex gap-5 w-full items-center justify-center">
            <div
                class="w-[71px] h-[53px] rounded-[16px] text-base text-18 flex items-center justify-center"
                :class="{ 'text-primary-1-1 border-primary-1-1 border-[2px]': option.lang == 'it' }"
            >
                <button @click.prevent="setLang('it')">IT</button>
            </div>
            <div
                class="w-[71px] h-[53px] rounded-[16px] text-base text-18 flex items-center justify-center"
                :class="{ 'text-primary-1-1 border-primary-1-1 border-[2px]': option.lang == 'de' }"
            >
                <button @click.prevent="setLang('de')">DE</button>
            </div>
            <div
                class="w-[71px] h-[53px] rounded-[16px] text-base text-18 flex items-center justify-center"
                :class="{ 'text-primary-1-1 border-primary-1-1 border-[2px]': option.lang == 'en' }"
            >
                <button @click.prevent="setLang('en')">EN</button>
            </div>
            <div
                class="w-[71px] h-[53px] rounded-[16px] text-base text-18 flex items-center justify-center"
                :class="{ 'text-primary-1-1 border-primary-1-1 border-[2px]': option.lang == 'fr' }"
            >
                <button @click.prevent="setLang('fr')">FR</button>
            </div>
        </div>

    </div>
</template>

<script setup>
import { reactive } from "@vue/reactivity"
import { usePage } from "@inertiajs/inertia-vue3";
import { loadLanguageAsync } from "laravel-vue-i18n";
import axios from "axios";

const option = reactive({
    lang: usePage().props.value.language_code ?? localStorage.getItem('lang') ?? 'de'
});

const setLang = (lang) => {
    const codes_to_id = { de: 1, en: 2, fr: 3, it: 4 }
    localStorage.setItem('lang', lang);
    option.lang = lang;
    loadLanguageAsync(lang);
    axios.put(route('update.language'), { language_id: codes_to_id[lang] })
}

</script>

<script>
export default {
    inheritAttrs: false,
};
</script>

