<template>
    <div class="grid md:grid-cols-2 md:grid-rows-1 grid-cols-1 grid-row-2 w-full bg-primary-1-1 md:bg-transparent">
        <div class="mobile-top-bar flex md:hidden h-20 items-center px-4">
            <LanguageSwitcherMobile @changeLanguage="setLanguage" />
        </div>
        <div class="contnet min-h-screen bg-background rounded-t-[32px] md:rounded-[0px] flex flex-col">
            <div class="card flex flex-col justify-center md:px-[163px] px-4 py-9 items-center">
                <div class="logo mx-auto mb-[130px]">
                    <svg
                        width="215"
                        height="64"
                        viewBox="0 0 215 64"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <g clip-path="url(#clip0_753_78)">
                            <path
                                d="M47.2971 14.9445C46.3592 14.8105 45.3543 14.7435 44.3494 14.7435H24.5195C21.8397 14.7435 19.696 16.888 19.696 19.5686V48.7204C8.44112 46.5089 0 36.5236 0 24.5948C0 11.0576 11.0539 0 24.5864 0C34.7694 0 43.4785 6.16544 47.2971 14.9445Z"
                                fill="#7059E2"
                            />
                            <path
                                d="M49.24 24.5948C49.24 38.199 38.1861 49.2566 24.5865 49.2566C22.9117 49.2566 21.2369 49.0556 19.696 48.7875V19.6357C19.696 16.955 21.8398 14.8105 24.5195 14.8105H44.2825C45.2874 14.8105 46.2923 14.8776 47.2302 15.0116C48.5031 17.8933 49.24 21.177 49.24 24.5948Z"
                                fill="#2929CC"
                            />
                            <path
                                d="M68.9359 39.6061C68.8019 53.2103 57.5471 64.0668 44.0145 64.0668H24.5195C21.8398 64.0668 19.696 61.9223 19.696 59.2417V48.7873C21.3039 49.1223 22.9117 49.2564 24.5865 49.2564C38.1861 49.2564 49.24 38.1988 49.24 24.5946C49.24 21.1768 48.503 17.893 47.2972 14.9443C59.5569 16.4187 69.0029 26.9401 68.9359 39.6061Z"
                                fill="#569FE8"
                            />
                            <path
                                d="M40.7987 27.0744H25.6583C25.0554 27.0744 24.5864 26.6053 24.5864 26.0021V23.1875C24.5864 22.5843 25.0554 22.1152 25.6583 22.1152H40.7987C41.4017 22.1152 41.8706 22.5843 41.8706 23.1875V26.0021C41.8706 26.6053 41.4017 27.0744 40.7987 27.0744Z"
                                fill="white"
                            />
                            <path
                                d="M38.521 39.4054H25.4573C24.9884 39.4054 24.5864 39.0034 24.5864 38.5342V35.3175C24.5864 34.8484 24.9884 34.4463 25.4573 34.4463H38.521C38.9899 34.4463 39.3919 34.8484 39.3919 35.3175V38.5342C39.3919 39.0034 38.9899 39.4054 38.521 39.4054Z"
                                fill="white"
                            />
                            <path
                                d="M111.208 39.8071C110.472 41.6835 109.4 43.2919 107.993 44.6992C106.586 46.1066 104.978 47.1788 103.102 48.05C101.227 48.8542 99.1497 49.2563 96.805 49.2563C94.4602 49.2563 92.4504 48.8542 90.5076 48.05C88.6318 47.2458 86.957 46.1736 85.6171 44.7663C84.2773 43.3589 83.2054 41.7505 82.4685 39.8741C81.7315 37.9977 81.3296 36.0542 81.3296 33.9097C81.3296 31.8322 81.7315 29.8217 82.4685 27.9453C83.2054 26.0689 84.2773 24.4605 85.6841 23.0532C87.091 21.6458 88.6988 20.5736 90.5746 19.7024C92.4504 18.8982 94.5272 18.4961 96.872 18.4961C99.2167 18.4961 101.227 18.8982 103.169 19.7024C105.045 20.5066 106.72 21.5788 108.06 22.9861C109.4 24.3935 110.472 26.0019 111.208 27.8783C111.945 29.7547 112.347 31.6982 112.347 33.8427C112.347 35.9872 111.945 37.9306 111.208 39.8071ZM106.117 29.8888C105.648 28.6155 104.911 27.4762 104.04 26.538C103.169 25.5998 102.097 24.7956 100.825 24.2594C99.5517 23.7233 98.2118 23.3882 96.738 23.3882C95.2641 23.3882 93.9243 23.6563 92.7184 24.1924C91.5125 24.7286 90.4406 25.4657 89.5697 26.471C88.6988 27.4092 88.0289 28.5484 87.493 29.8217C87.024 31.095 86.756 32.5024 86.756 33.9097C86.756 35.317 87.024 36.7244 87.493 37.9977C87.9619 39.271 88.6988 40.4102 89.5697 41.3484C90.4406 42.2867 91.5125 43.0909 92.7854 43.627C94.0583 44.1631 95.3981 44.4982 96.872 44.4982C98.3458 44.4982 99.6857 44.2301 100.892 43.694C102.097 43.1579 103.169 42.4207 104.04 41.4155C104.911 40.4772 105.581 39.338 106.117 38.0647C106.586 36.7914 106.854 35.3841 106.854 33.9767C106.854 32.5024 106.653 31.1621 106.117 29.8888Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M120.186 48.7201H115.027V26.3369H120.186V29.8217C120.521 29.2856 120.922 28.7495 121.391 28.2804C121.86 27.8113 122.329 27.4092 122.932 27.0071C123.535 26.605 124.138 26.3369 124.808 26.1359C125.478 25.9348 126.282 25.8008 127.153 25.8008C129.699 25.8008 131.641 26.605 133.048 28.1463C134.455 29.6877 135.125 31.7652 135.125 34.4458V48.7201H129.967V36.0542C129.967 34.3118 129.565 32.9715 128.694 32.0332C127.823 31.095 126.684 30.6259 125.21 30.6259C123.736 30.6259 122.53 31.095 121.592 32.1003C120.655 33.1055 120.186 34.4458 120.186 36.1882V48.7201Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M165.406 39.74C164.669 41.5494 163.53 43.1578 162.19 44.4981C160.783 45.8384 159.109 46.8436 157.166 47.6478C155.223 48.385 153.079 48.7871 150.801 48.7871H139.748V19.0991H150.734C153.079 19.0991 155.156 19.5012 157.099 20.2384C159.042 20.9756 160.716 22.0478 162.123 23.3211C163.53 24.6614 164.602 26.2028 165.339 28.0122C166.076 29.8216 166.478 31.7651 166.478 33.8426C166.545 35.9871 166.143 37.9305 165.406 39.74ZM160.314 29.8886C159.845 28.6824 159.109 27.6101 158.238 26.6719C157.367 25.7337 156.295 25.0635 154.955 24.5274C153.682 23.9913 152.275 23.7902 150.734 23.7902H144.839V44.029H150.734C152.275 44.029 153.682 43.7609 154.955 43.2918C156.228 42.8227 157.3 42.0855 158.238 41.2143C159.109 40.3431 159.845 39.2708 160.314 37.9975C160.783 36.7913 161.051 35.3839 161.051 33.9096C161.051 32.5023 160.783 31.0949 160.314 29.8886Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M191.533 42.0855C190.93 43.4928 190.059 44.7661 189.054 45.7713C187.983 46.8436 186.71 47.6478 185.236 48.3179C183.762 48.9211 182.154 49.2562 180.479 49.2562C178.805 49.2562 177.197 48.9211 175.723 48.3179C174.249 47.7148 173.043 46.8436 171.971 45.8384C170.899 44.7661 170.095 43.5598 169.492 42.1525C168.89 40.7452 168.622 39.2708 168.622 37.6624C168.622 36.0541 168.957 34.5127 169.559 33.1054C170.162 31.698 171.033 30.4247 172.038 29.3525C173.11 28.2802 174.383 27.4761 175.79 26.8059C177.264 26.2028 178.805 25.8677 180.546 25.8677C182.288 25.8677 183.829 26.2028 185.303 26.8059C186.777 27.409 187.983 28.2802 189.054 29.2855C190.126 30.3577 190.93 31.564 191.533 32.9713C192.136 34.3787 192.404 35.92 192.404 37.5284C192.471 39.1368 192.136 40.6781 191.533 42.0855ZM186.777 34.8478C186.442 33.9766 185.973 33.1724 185.37 32.5692C184.767 31.8991 184.03 31.363 183.226 31.0279C182.422 30.6928 181.484 30.4247 180.479 30.4247C179.474 30.4247 178.537 30.6258 177.733 31.0279C176.929 31.43 176.192 31.8991 175.589 32.5692C174.986 33.2394 174.517 33.9766 174.249 34.8478C173.914 35.719 173.78 36.6572 173.78 37.5954C173.78 38.6007 173.981 39.5389 174.316 40.4101C174.651 41.2813 175.12 42.0855 175.723 42.6886C176.326 43.3588 177.063 43.8279 177.867 44.23C178.671 44.6321 179.608 44.8331 180.613 44.8331C181.618 44.8331 182.556 44.6321 183.427 44.23C184.298 43.8279 184.968 43.3588 185.571 42.6886C186.174 42.0185 186.643 41.2813 186.911 40.4101C187.246 39.5389 187.38 38.6007 187.38 37.6624C187.313 36.6572 187.112 35.719 186.777 34.8478Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M211.028 48.1169C209.621 48.9211 207.812 49.2562 205.669 49.2562C203.994 49.2562 202.453 48.9211 201.046 48.3179C199.639 47.7148 198.433 46.8436 197.362 45.8384C196.29 44.7661 195.486 43.5598 194.95 42.1525C194.347 40.7452 194.079 39.2708 194.079 37.6624C194.079 36.0541 194.347 34.5127 194.95 33.1054C195.553 31.698 196.357 30.4247 197.362 29.3525C198.433 28.2802 199.639 27.409 201.046 26.8059C202.453 26.2028 203.994 25.8677 205.669 25.8677C207.812 25.8677 209.554 26.2028 210.961 26.9399C212.368 27.6771 213.574 28.5483 214.646 29.7546L211.497 33.1724C210.693 32.3682 209.889 31.698 208.951 31.1619C208.08 30.6258 206.942 30.3577 205.669 30.3577C204.731 30.3577 203.86 30.5588 203.056 30.9609C202.252 31.363 201.582 31.8321 201.046 32.5022C200.51 33.1724 200.041 33.9096 199.706 34.7808C199.371 35.652 199.237 36.5902 199.237 37.5284C199.237 38.5336 199.371 39.4719 199.706 40.3431C200.041 41.2143 200.51 41.9514 201.113 42.6216C201.716 43.2918 202.386 43.7609 203.257 44.163C204.061 44.5651 204.999 44.7661 205.937 44.7661C207.142 44.7661 208.214 44.498 209.152 43.9619C210.09 43.4258 210.961 42.7556 211.765 41.9514L214.847 45.0342C213.708 46.3075 212.435 47.3127 211.028 48.1169Z"
                                fill="#5D5D60"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_753_78">
                                <rect
                                    width="214.78"
                                    height="64"
                                    fill="white"
                                />
                            </clipPath>
                        </defs>
                    </svg>

                </div>
                <form @submit.prevent="update" class="w-[300px]">
                    <h3 class="text-base text-20 font-bold mb-[37px]">{{ $t('Forgot Password?') }}</h3>
                    <p class="text-base text-[14px] leading-[17px] mb-[41px]">{{ $t('Please enter and confirm your new password to reset your password.') }}</p>

                    <div class="mt-[64px]">
                        <div class="mb-3 text-primary-1-1 text-16 font-bold">
                            {{ $t('E-Mail') }}
                        </div>
                        <div class="text-placeholder text-16 font-normal">
                            {{ form.email }}
                        </div>
                        <div class="mt-[32px]">
                            <div class="password-input">
                                <PasswordInput
                                    name="password"
                                    id="password"
                                    :label="$t('New Password')"
                                    v-model="form.password"
                                    inputClass="border-[0px] shadow-form"
                                    labelClass="text-primary-1-1"
                                    :placeholder="$t('Enter new password')"
                                />
                            </div>
                        </div>
                        <div class="mt-[32px]">
                            <div class="password-input">
                                <PasswordInput
                                    name="password_confirmation"
                                    id="password-confirmation"
                                    :label="$t('Confirm Password')"
                                    :placeholder="$t('Re enter new password')"
                                    inputClass="border-[0px] shadow-form"
                                    labelClass="text-primary-1-1"
                                    v-model="form.password_confirmation"
                                />
                            </div>
                        </div>
                        <div>
                            <PrimaryButton
                                class="text-white font-bold text-18 px-[21px] py-[18px] bg-primary-1-1 text-center rounded-[8px] flex justify-center w-full mt-[55px]"
                                :disabled="v$.$invalid || form.processing"
                            >{{ $t('Update password') }}</PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
            <Link
                class="mt-auto mb-[65px] mx-auto text-base text-16 underline"
                :href="route('login')"
            >{{ $t('Go back to Login') }}</Link>
        </div>
        <div class="image h-full w-full relative items-end justify-end hidden md:flex">
            <img
                src="/images/left_background.png"
                class="h-full w-full absolute z-[-1]"
            >
            <div class="languages flex gap-[27px] z-1 fixed top-[92%] right-[2%]">
                <LanguageSwitcher @changeLanguage="setLanguage" />
            </div>
        </div>
    </div>
</template>

<script setup>
import LanguageSwitcher from "../../Components/LanguageSwitcher.vue";
import LanguageSwitcherMobile from "../../Components/LanguageSwitcherMobile.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import PasswordInput from "../../Components/Form/PasswordInput.vue";
import { Link } from "@inertiajs/inertia-vue3";
import PrimaryButton from "../../Components/PrimaryButton.vue";

import useVuelidate from '@vuelidate/core'
import { required, helpers, email } from '@vuelidate/validators'
import usePasswordValidation from "../../Composables/passwordValidationRules"

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
    reset: {
        type: Boolean,
        default: false,
    },
})
const form = useForm({
    password: "",
    password_confirmation: "",
    email: props.email,
    token: props.token,
});

const update = async () => {
    const isValid = await v$.value.$validate()
    if (!isValid) return;

    form.clearErrors();
    form.post(route("password.update"), {
        onSuccess: () => {
            form.reset();
        },
        onError: (err) => console.log(err),
    });
};

const isSame = (form, key) => (value) => {
    return form[key] == value
}

const rules = {
    password: {
        required: helpers.withMessage("The password field is required.", required),
        ...usePasswordValidation()
    },
    password_confirmation: {
        required: helpers.withMessage("The confirm password field is required.", required),
        isSame: helpers.withMessage('The confirm password and password must match.', isSame(form, 'password'))
    },
}

const setLanguage = (code) => {
    switch (code) {
        case 'de':
            form.language_id = 1;
            break
        case 'en':
            form.language_id = 2;
            break
        case 'fr':
            form.language_id = 3;
            break
        case 'it':
            form.language_id = 4;
            break
        default:
            form.language_id = 2;
    }
}

const v$ = useVuelidate(rules, form)
</script>

<script>
import AuthLayout from "../../Layouts/Auth.vue";
export default {
    layout: AuthLayout
}
</script>

<style lang="scss" scoped>

</style>
