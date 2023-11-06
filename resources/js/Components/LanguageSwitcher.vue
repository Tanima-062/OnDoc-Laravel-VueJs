<template>
    <div class="language__switches">
        <div class="language__switches--item" :class="{active: option.lang == 'it'}">
            <button @click.prevent="setLang('it')">IT</button>
        </div>
        <div class="language__switches--item" :class="{active: option.lang == 'de'}">
            <button @click.prevent="setLang('de')">DE</button>
        </div>
        <div class="language__switches--item" :class="{active: option.lang == 'en'}">
            <button  @click.prevent="setLang('en')">EN</button>
        </div>
        <div class="language__switches--item" :class="{active: option.lang == 'fr'}">
            <button  @click.prevent="setLang('fr')">FR</button>
        </div>
    </div>
</template>

<script>
import { loadLanguageAsync } from "laravel-vue-i18n";
import { reactive } from "@vue/reactivity";
import { usePage } from "@inertiajs/inertia-vue3";

    export default {
        setup(props, {emit}){

            const option = reactive({
                lang:  usePage().props.value.language_code ?? localStorage.getItem('lang') ??  'de'
            });

            const setLang = (lang) => {
                localStorage.setItem('lang', lang);
                option.lang = lang;
                loadLanguageAsync(lang);

                emit('changeLanguage', lang)
            }

            return {
                setLang,
                option
            }
        }
    }
</script>

<style lang="scss" scoped>
    .language__switches {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 50px;

        &--item {
            button {
                border: 0;
                outline: 0;
                width: 40px;
                height: 40px;
                border-radius: 5px;
                background: #FFFFFF;

                font-family: 'Montserrat';
                font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 24px;
                color: #5D5D60;
                cursor: pointer;
            }
        }
        &--item.active {
            button {
                background: #7059E2;
                color: #FFFFFF;
                font-weight: 700;
            }
        }
    }
</style>
