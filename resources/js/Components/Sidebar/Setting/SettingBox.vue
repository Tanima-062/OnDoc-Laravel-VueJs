<template>
    <div class="dropdown-menu fixed bottom-8 max-w-content">
        <div class="wrapper relative">
            <button
                class="flex gap-5 items-center p-3 text-base font-700 text-20 rounded-[8px]"
                :class="{ 'text-primary-1-1 bg-violet-1': (isActiveComponent || showDropdown), 'w-[277px]': sidebarFullView }"
                @click="toggle"
            >
                <SettingsIcon fill='currentcolor' /> <span class="hide-on-collapse">{{ $t('Settings') }}</span>
            </button>
            <div
                class="items overflow-hidden absolute bottom-[120%] bg-white text-base text-18 rounded-[8px] shadow-form [&>.item:hover]:bg-violet-1"
                :class="{ 'w-[277px]': sidebarFullView }"
                v-if="showDropdown"
                v-click-away="() => showDropdown = false"
                @click="showDropdown = false"
            >
                <Link
                    :href="route('profile-management.update-password.show')"
                    class="item flex gap-[17px] items-center p-[18px] w-full"
                >
                <svg
                    width="22"
                    height="12"
                    viewBox="0 0 22 12"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M1 12.0001V10.0001H21V12.0001H1ZM2.15 5.95006L0.85 5.20006L1.7 3.70006H0V2.20006H1.7L0.85 0.750061L2.15 6.10352e-05L3 1.45006L3.85 6.10352e-05L5.15 0.750061L4.3 2.20006H6V3.70006H4.3L5.15 5.20006L3.85 5.95006L3 4.45006L2.15 5.95006ZM10.15 5.95006L8.85 5.20006L9.7 3.70006H8V2.20006H9.7L8.85 0.750061L10.15 6.10352e-05L11 1.45006L11.85 6.10352e-05L13.15 0.750061L12.3 2.20006H14V3.70006H12.3L13.15 5.20006L11.85 5.95006L11 4.45006L10.15 5.95006ZM18.15 5.95006L16.85 5.20006L17.7 3.70006H16V2.20006H17.7L16.85 0.750061L18.15 6.10352e-05L19 1.45006L19.85 6.10352e-05L21.15 0.750061L20.3 2.20006H22V3.70006H20.3L21.15 5.20006L19.85 5.95006L19 4.45006L18.15 5.95006Z"
                        fill="#5D5D60"
                    />
                </svg>
                <span class="hide-on-collapse">
                    {{ $t('Change password') }}
                </span>
                </Link>

                <button
                    @click="changeLanguage"
                    class="item flex gap-[17px] items-center p-[18px] w-full"
                >
                    <svg
                        width="23"
                        height="20"
                        viewBox="0 0 23 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M10.9 20.0005L15.45 8.00049H17.55L22.1 20.0005H20L18.95 16.9505H14.1L13 20.0005H10.9ZM14.7 15.2005H18.3L16.55 10.2505H16.45L14.7 15.2005ZM3 17.0005L1.6 15.6005L6.65 10.5505C6.01667 9.85049 5.46267 9.12549 4.988 8.37549C4.51267 7.62549 4.1 6.83382 3.75 6.00049H5.85C6.15 6.60049 6.471 7.14215 6.813 7.62549C7.15433 8.10882 7.56667 8.61715 8.05 9.15049C8.78333 8.35049 9.39167 7.52982 9.875 6.68849C10.3583 5.84649 10.7667 4.95049 11.1 4.00049H0V2.00049H7V0.000488281H9V2.00049H16V4.00049H13.1C12.75 5.18382 12.275 6.33382 11.675 7.45049C11.075 8.56715 10.3333 9.61716 9.45 10.6005L11.85 13.0505L11.1 15.1005L8 12.0005L3 17.0005Z"
                            fill="#5D5D60"
                        />
                    </svg>
                    <span class="hide-on-collapse">{{ $t('Change language') }}</span>
                </button>

                <button
                    @click="logout"
                    class="item flex gap-[17px] items-center p-[18px] w-full"
                >
                    <svg
                        width="18"
                        height="18"
                        viewBox="0 0 18 18"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M2 18.0001C1.45 18.0001 0.979 17.8044 0.587 17.4131C0.195667 17.0211 0 16.5501 0 16.0001V2.00006C0 1.45006 0.195667 0.979061 0.587 0.587061C0.979 0.195728 1.45 6.10352e-05 2 6.10352e-05H9V2.00006H2V16.0001H9V18.0001H2ZM13 14.0001L11.625 12.5501L14.175 10.0001H6V8.00006H14.175L11.625 5.45006L13 4.00006L18 9.00006L13 14.0001Z"
                            fill="#5D5D60"
                        />
                    </svg>
                    <span class="hide-on-collapse">{{ $t('Sign Out') }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import { usePage, Link } from "@inertiajs/inertia-vue3";
import SettingsIcon from "../../Icons/SettingsIcon.vue";
import { computed, ref } from "@vue/reactivity";
import { inject } from "vue";
import Confirmation from "../../Modal/Content/Confirmation.vue";
import { trans } from "laravel-vue-i18n";
import ChangeLanguage from "../../Modal/Content/ChangeLanguage.vue";

defineProps({
    sidebarFullView: {
        type: Boolean,
        required: false,
    }
})

const page = usePage()
const showDropdown = ref(false)
const isActiveComponent = computed(() => {
    const regex = RegExp(`^(ProfileManagement)`);
    return regex.test(page.component.value)

});

const toggle = () => showDropdown.value = !showDropdown.value

const modal = inject('modal')


const changeLanguage = () => {
    modal.show(ChangeLanguage)
}

const logout = () => {
    modal.show(Confirmation, {
        props: {
            title: trans("Sign Out"),
            description: trans("Are you sure you want to sign out?")
        },
        events: {
            yesClick: () => Inertia.post(route('logout')),
            noClick: modal.hide
        }
    })
}

</script>
