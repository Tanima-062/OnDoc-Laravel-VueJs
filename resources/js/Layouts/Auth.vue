<template>
    <CustomModal>
        <StatusShower />
        <div class="auth">
            <slot />
        </div>
    </CustomModal>
</template>

<script>
import CustomModal from "../Components/Modal/CustomModal.vue";
import StatusShower from "../Components/StatusShower.vue";
import { onMounted } from 'vue';
import { loadLanguageAsync } from 'laravel-vue-i18n';
import { usePage } from "@inertiajs/inertia-vue3";


export default {
    components: { CustomModal, StatusShower },
    setup() {
        onMounted(() => {
            let lang = 'de';
            let cacheLanguage = localStorage.getItem('lang');

            lang = usePage().props.value.language_code ?? (cacheLanguage ?? lang) ;
            localStorage.setItem('lang', lang);
            loadLanguageAsync(lang);

        });
        return {};
    },
};

</script>
