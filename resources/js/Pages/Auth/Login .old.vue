<template>
    <div class="auth__container min-h-[914px] box-border pb-20">
        <div class="auth__card">
            <div
                class="auth__alert auth__alert--success"
                v-if="attrs.flash?.message"
            >
                <div class="auth__alert--header">
                    <h4 class="auth__alert--title">Benachrichtigung</h4>

                    <span class="auth__alert--close">
                        <close-icon />
                    </span>
                </div>

                <div class="auth__alert--body">
                    thanks_very_much_your_password_has_been_successfully_reset_you_can_now_log_in_with_your_new_password
                </div>
            </div>

            <div class="auth__card-header flex justify-center">
                <!-- <LogoDark /> -->

                <div class="w-[280px] h-[62px]">
                    <svg
                        width="162"
                        height="48"
                        viewBox="0 0 162 48"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <g clip-path="url(#clip0_4_30)">
                            <path
                                d="M35.4728 11.2084C34.7694 11.1079 34.0157 11.0576 33.262 11.0576H18.3896C16.3798 11.0576 14.772 12.666 14.772 14.6764V36.5403C6.33084 34.8817 0 27.3927 0 18.4461C0 8.29319 8.29039 0 18.4398 0C26.077 0 32.6089 4.62408 35.4728 11.2084Z"
                                fill="#7059E2"
                            />
                            <path
                                d="M36.9299 18.4461C36.9299 28.6492 28.6395 36.9424 18.4398 36.9424C17.1837 36.9424 15.9276 36.7916 14.772 36.5906V14.7267C14.772 12.7162 16.3798 11.1078 18.3896 11.1078H33.2118C33.9655 11.1078 34.7191 11.1581 35.4226 11.2586C36.3772 13.4199 36.9299 15.8827 36.9299 18.4461Z"
                                fill="#2929CC"
                            />
                            <path
                                d="M51.7019 29.7047C51.6014 39.9078 43.1603 48.0503 33.0108 48.0503H18.3896C16.3798 48.0503 14.772 46.4419 14.772 44.4314V36.5906C15.9778 36.8419 17.1837 36.9424 18.4398 36.9424C28.6395 36.9424 36.9299 28.6492 36.9299 18.4461C36.9299 15.8827 36.3772 13.4199 35.4728 11.2084C44.6676 12.3141 51.7521 20.2052 51.7019 29.7047Z"
                                fill="#569FE8"
                            />
                            <path
                                d="M30.5991 20.3058H19.2437C18.7915 20.3058 18.4398 19.9539 18.4398 19.5016V17.3906C18.4398 16.9382 18.7915 16.5864 19.2437 16.5864H30.5991C31.0513 16.5864 31.403 16.9382 31.403 17.3906V19.5016C31.403 19.9539 31.0513 20.3058 30.5991 20.3058Z"
                                fill="white"
                            />
                            <path
                                d="M28.8907 29.5539H19.093C18.7413 29.5539 18.4398 29.2524 18.4398 28.9005V26.488C18.4398 26.1361 18.7413 25.8346 19.093 25.8346H28.8907C29.2424 25.8346 29.5439 26.1361 29.5439 26.488V28.9005C29.5439 29.2524 29.2424 29.5539 28.8907 29.5539Z"
                                fill="white"
                            />
                            <path
                                d="M83.4063 29.8555C82.8536 31.2628 82.0497 32.4691 80.9946 33.5246C79.9394 34.5801 78.7336 35.3843 77.3267 36.0377C75.9199 36.6408 74.3623 36.9424 72.6037 36.9424C70.8451 36.9424 69.3378 36.6408 67.8807 36.0377C66.4738 35.4346 65.2177 34.6304 64.2128 33.5749C63.2079 32.5194 62.404 31.3131 61.8513 29.9058C61.2986 28.4984 60.9972 27.0408 60.9972 25.4325C60.9972 23.8743 61.2986 22.3665 61.8513 20.9592C62.404 19.5518 63.2079 18.3456 64.2631 17.2901C65.3182 16.2346 66.5241 15.4304 67.9309 14.777C69.3378 14.1738 70.8954 13.8723 72.654 13.8723C74.4125 13.8723 75.9199 14.1738 77.377 14.777C78.7838 15.3801 80.0399 16.1843 81.0448 17.2398C82.0497 18.2953 82.8536 19.5016 83.4063 20.9089C83.959 22.3162 84.2605 23.7738 84.2605 25.3822C84.2605 26.9906 83.959 28.4482 83.4063 29.8555ZM79.5877 22.4168C79.236 21.4618 78.6833 20.6073 78.0301 19.9037C77.377 19.2 76.573 18.5969 75.6184 18.1948C74.6637 17.7927 73.6588 17.5414 72.5535 17.5414C71.4481 17.5414 70.4432 17.7424 69.5388 18.1445C68.6344 18.5466 67.8304 19.0995 67.1773 19.8534C66.5241 20.5571 66.0216 21.4115 65.6197 22.3665C65.268 23.3215 65.067 24.377 65.067 25.4325C65.067 26.488 65.268 27.5435 65.6197 28.4984C65.9714 29.4534 66.5241 30.3079 67.1773 31.0115C67.8304 31.7152 68.6344 32.3183 69.589 32.7204C70.5437 33.1225 71.5486 33.3738 72.654 33.3738C73.7593 33.3738 74.7642 33.1728 75.6686 32.7707C76.573 32.3686 77.377 31.8157 78.0301 31.0618C78.6833 30.3581 79.1858 29.5037 79.5877 28.5487C79.9394 27.5937 80.1404 26.5382 80.1404 25.4827C80.1404 24.377 79.9897 23.3717 79.5877 22.4168Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M90.1391 36.5403H86.2703V19.7529H90.1391V22.3665C90.3903 21.9644 90.6918 21.5623 91.0435 21.2105C91.3952 20.8587 91.7469 20.5571 92.1991 20.2555C92.6514 19.9539 93.1036 19.7529 93.606 19.6021C94.1085 19.4513 94.7114 19.3508 95.3646 19.3508C97.2739 19.3508 98.731 19.9539 99.7861 21.11C100.841 22.266 101.344 23.8241 101.344 25.8346V36.5403H97.4748V27.0409C97.4748 25.734 97.1734 24.7288 96.5202 24.0251C95.867 23.3215 95.0129 22.9696 93.9075 22.9696C92.8021 22.9696 91.8977 23.3215 91.1943 24.0754C90.4908 24.8293 90.1391 25.8346 90.1391 27.1414V36.5403Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M124.054 29.8052C123.502 31.1623 122.648 32.3686 121.643 33.3738C120.587 34.3791 119.331 35.133 117.874 35.7361C116.417 36.289 114.809 36.5906 113.101 36.5906H104.811V14.3246H113.051C114.809 14.3246 116.367 14.6262 117.824 15.1791C119.281 15.7319 120.537 16.5361 121.592 17.4911C122.648 18.4963 123.451 19.6524 124.004 21.0094C124.557 22.3665 124.858 23.8241 124.858 25.3822C124.909 26.9906 124.607 28.4482 124.054 29.8052ZM120.236 22.4168C119.884 21.512 119.331 20.7079 118.678 20.0042C118.025 19.3005 117.221 18.7979 116.216 18.3958C115.262 17.9937 114.206 17.8429 113.051 17.8429H108.629V33.022H113.051C114.206 33.022 115.262 32.8209 116.216 32.4691C117.171 32.1173 117.975 31.5644 118.678 30.911C119.331 30.2576 119.884 29.4534 120.236 28.4984C120.587 27.5937 120.788 26.5382 120.788 25.4325C120.788 24.377 120.587 23.3215 120.236 22.4168Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M143.65 31.5644C143.198 32.6199 142.544 33.5749 141.791 34.3288C140.987 35.133 140.032 35.7361 138.927 36.2388C137.821 36.6911 136.616 36.9424 135.359 36.9424C134.103 36.9424 132.897 36.6911 131.792 36.2388C130.687 35.7864 129.782 35.133 128.978 34.3791C128.174 33.5749 127.571 32.6702 127.119 31.6147C126.667 30.5592 126.466 29.4534 126.466 28.2471C126.466 27.0409 126.717 25.8848 127.17 24.8293C127.622 23.7738 128.275 22.8189 129.029 22.0147C129.832 21.2105 130.787 20.6073 131.842 20.1047C132.948 19.6524 134.103 19.4011 135.41 19.4011C136.716 19.4011 137.872 19.6524 138.977 20.1047C140.082 20.5571 140.987 21.2105 141.791 21.9644C142.595 22.7686 143.198 23.6733 143.65 24.7288C144.102 25.7843 144.303 26.9403 144.303 28.1466C144.353 29.3529 144.102 30.5089 143.65 31.5644ZM140.082 26.1361C139.831 25.4827 139.479 24.8796 139.027 24.4272C138.575 23.9246 138.022 23.5225 137.419 23.2712C136.817 23.0199 136.113 22.8189 135.359 22.8189C134.606 22.8189 133.902 22.9696 133.299 23.2712C132.696 23.5728 132.144 23.9246 131.692 24.4272C131.239 24.9299 130.888 25.4827 130.687 26.1361C130.435 26.7895 130.335 27.4932 130.335 28.1969C130.335 28.9508 130.486 29.6545 130.737 30.3079C130.988 30.9613 131.34 31.5644 131.792 32.0168C132.244 32.5194 132.797 32.8712 133.4 33.1728C134.003 33.4744 134.706 33.6251 135.46 33.6251C136.214 33.6251 136.917 33.4744 137.57 33.1728C138.223 32.8712 138.726 32.5194 139.178 32.0168C139.63 31.5142 139.982 30.9613 140.183 30.3079C140.434 29.6545 140.535 28.9508 140.535 28.2471C140.484 27.4932 140.334 26.7895 140.082 26.1361Z"
                                fill="#5D5D60"
                            />
                            <path
                                d="M158.271 36.088C157.216 36.6911 155.859 36.9424 154.251 36.9424C152.995 36.9424 151.84 36.6911 150.785 36.2388C149.729 35.7864 148.825 35.133 148.021 34.3791C147.217 33.5749 146.614 32.6702 146.212 31.6147C145.76 30.5592 145.559 29.4534 145.559 28.2471C145.559 27.0409 145.76 25.8848 146.212 24.8293C146.665 23.7738 147.267 22.8189 148.021 22.0147C148.825 21.2105 149.729 20.5571 150.785 20.1047C151.84 19.6524 152.995 19.4011 154.251 19.4011C155.859 19.4011 157.166 19.6524 158.221 20.2053C159.276 20.7581 160.18 21.4115 160.984 22.3162L158.623 24.8796C158.02 24.2765 157.417 23.7738 156.713 23.3717C156.06 22.9696 155.206 22.7686 154.251 22.7686C153.548 22.7686 152.895 22.9194 152.292 23.221C151.689 23.5225 151.187 23.8744 150.785 24.377C150.383 24.8796 150.031 25.4325 149.78 26.0859C149.528 26.7393 149.428 27.4429 149.428 28.1466C149.428 28.9005 149.528 29.6042 149.78 30.2576C150.031 30.911 150.383 31.4639 150.835 31.9665C151.287 32.4691 151.789 32.821 152.443 33.1225C153.046 33.4241 153.749 33.5749 154.452 33.5749C155.357 33.5749 156.161 33.3738 156.864 32.9717C157.568 32.5696 158.221 32.067 158.824 31.4639L161.135 33.7759C160.281 34.7309 159.326 35.4848 158.271 36.088Z"
                                fill="#5D5D60"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_4_30">
                                <rect
                                    width="161.085"
                                    height="48"
                                    fill="white"
                                />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>

            <div class="auth__card-body mt-[145px]">
                <form @submit.prevent="login">
                    <div class="auth__card--input-wrapper mt-[41px]">
                        <div class="auth__card--form-input">
                            <label
                                class="form-label text-16 font-normal font-montserrat"
                                for="email"
                                >Email*</label
                            >
                            <TextInput
                                placeholder="E-Mail Adresse eingeben"
                                v-model="form.username"
                                :error="
                                    form.errors.username
                                        ? 'Das Feld für den Benutzernamen ist erforderlich.'
                                        : undefined
                                "
                                labelClass="block mb-[5px] font-ropa font-normal text-16"
                                :show_error="errors.username"
                            />
                        </div>

                        <div class="auth__card--form-input mt-[30px]">
                            <div class="label flex mb-[8px]">
                                <label
                                    class="form-label text-16 font-normal font-montserrat"
                                    for="password"
                                    >Passwort*</label
                                >

                                <!-- <PasswordTooltip svgClass="mt-0 ml-0 top-[3px] right-[-17px]" /> -->
                            </div>

                            <PasswordInput
                                :show-label="false"
                                v-model="form.password"
                                placeholder="Passwort eingeben"
                                :showError="false"
                                :error="
                                    form.errors.email
                                        ? 'Das Feld für den Benutzernamen ist erforderlich.'
                                        : undefined
                                "
                                :hasError="errors.password"
                            />
                        </div>

                        <div class="auth__card--form-input mt-[30px]">
                            <button
                                class="challo__btn btn-block btn-primary font-poppins text-15 font-semibold bg-primary-1-1"
                                type="submit"
                                :disabled="form.processing"
                            >
                                Anmelden
                            </button>
                        </div>

                        <div class="auth__card--form-input mt-[16px]">
                            <Link
                                class="auth__card--link text-gray-text"
                                :href="route('password.request')"
                            >
                                Passwort vergessen?
                            </Link>
                        </div>

                        <div
                            class="auth__card--form-input mt-[32px]"
                            v-if="form.hasErrors"
                        >
                            <div class="messages flex flex-row gap-[9px]">
                                <div class="messages__icon mt-[6px]">
                                    <failed-icon />
                                </div>

                                <div
                                    class="messages__text text-tints-5 text-14 font-normal"
                                >
                                    Ungültige Anmeldedaten. Bitte versuchen Sie
                                    es erneut oder klicken Sie auf "Passwort
                                    vergessen?" sollten Sie Ihr Passwort
                                    vergessen haben.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import AuthLayout from "../../Layouts/Auth.vue";
import TextInput from "../../Components/Form/TextInput.vue";

import { useForm } from "@inertiajs/inertia-vue3";
import EyeClose from "../../Components/Icons/EyeClose.vue";
import EyeOpen from "../../Components/Icons/EyeOpen.vue";
import CloseIcon from "../../Components/Icons/CloseIcon.vue";
import FailedIcon from "../../Components/Icons/FailedIcon.vue";
import { reactive } from "@vue/reactivity";
import { Link } from "@inertiajs/inertia-vue3";
import { inject, useAttrs } from "@vue/runtime-core";
import FieldMissing from "../../Components/Modal/Content/FieldMissing";
import PasswordInput from "../../Components/Form/PasswordInput.vue";
import PasswordTooltip from "../../Components/Form/PasswordTooltip.vue";

export default {
    layout: AuthLayout,
    props: {
        message: {
            type: String,
            default: null,
        },
    },
    components: {
        TextInput,
        EyeClose,
        EyeOpen,
        Link,
        FailedIcon,
        CloseIcon,
        PasswordInput,
        PasswordTooltip,
    },
    setup() {
        const attrs = useAttrs();
        const option = reactive({
            password_type: "password",
        });

        const form = useForm({
            username: "",
            password: "",
        });

        const errors = reactive({
            username: false,
            password: false,
        });

        const modal = inject("modal");

        const login = () => {
            form.clearErrors();
            manageError();
            if (!manageError()) {
                return;
            }

            form.post(route("login"), {
                forceFormData: true,
                onError: function (error) {
                    errors.username = true;
                    errors.password = true;
                },
            });
        };

        const manageError = () => {
            errors.username = false;
            errors.password = false;

            if (form.username === "" || form.password === "") {
                modal.show(FieldMissing, {
                    config: {
                        staticBackdrop: true,
                    },
                });

                if (form.username === "") {
                    errors.username = true;
                }

                if (form.password === "") {
                    errors.password = true;
                }

                return false;
            }
            return true;
        };

        return {
            form,
            option,
            login,
            attrs,
            errors,
        };
    },
};
</script>

<style lang="scss" scoped>
.error {
    border-color: #c81717;
}

.form-error {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 18px;
    display: flex;
    align-items: center;
    color: #ff0000;
    margin-top: 5px;
}
</style>
