<template>
    <CustomModal>
        <StatusShower />
        <div class="wrapper flex">
            <sidebar v-click-away="closeSidebar" />
            <!-- Page Content  -->
            <div id="conten" class="bg-[#ecf6fd] flex-1">
                <!-- <navbar @open="showSidebar" class="h-60 bg-background flex justify-between py-2.5 px-6" /> -->

                <main class="px-6 py-12 pt-4">
                    <div class="navbar flex justify-center mb-4">
                        <AppLogo />
                    </div>
                    <slot />
                </main>
            </div>
        </div>
    </CustomModal>
</template>

<script>
import Navbar from "../Components/Navbar";
import Sidebar from "../Components/Sidebar/Sidebar.vue";
import CustomModal from "../Components/Modal/CustomModal.vue";
import StatusShower from "../Components/StatusShower.vue";

import { computed, onMounted, reactive } from "@vue/runtime-core";
import { loadLanguageAsync, trans } from "laravel-vue-i18n";
import { usePage } from "@inertiajs/inertia-vue3";
import AppLogo from "../Components/Icons/AppLogo.vue";

export default {
    components: { Sidebar, Navbar, CustomModal, StatusShower, AppLogo },
    setup(props) {
        onMounted(() => {
            const user = usePage().props.value.auth_user;
            const lang = usePage().props.value.auth_user.language.code || "de";

            // console.log("language", user.language);
            loadLanguageAsync(lang);
        });

        const option = reactive({
            openSidebar: false,
        });

        const style = computed(() =>
            option.openSidebar ? "display:block" : "display:none;"
        );

        const showSidebar = () => {
            option.openSidebar = true;
            //   console.log("clicked");
        };

        const closeSidebar = () => {
            option.openSidebar = false;
            //   console.log("close");
        };
        return {
            showSidebar,
            style,
            closeSidebar,
        };
    },
};
</script>
