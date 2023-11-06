<template>
  <div
    class="grid md:grid-cols-2 md:grid-rows-1 grid-cols-1 grid-row-2 w-full bg-primary-1-1 md:bg-transparent"
  >
    <div class="mobile-top-bar flex md:hidden h-20 items-center px-4">
      <LanguageSwitcherMobile @changeLanguage="setLanguage" />
    </div>
    <div class="contnet min-h-screen bg-background rounded-t-[32px] md:rounded-[0px]">
      <div class="card flex flex-col justify-center md:px-[163px] px-4 py-9">
        <div class="logo mx-auto mb-[134px]">
          <svg
            width="215"
            height="64"
            viewBox="0 0 215 64"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g clip-path="url(#clip0_52_402)">
              <path
                d="M47.2971 14.9445C46.3592 14.8105 45.3543 14.7435 44.3494 14.7435H24.5195C21.8397 14.7435 19.696 16.888 19.696 19.5686V48.7204C8.44112 46.5089 0 36.5236 0 24.5948C0 11.0576 11.0539 0 24.5864 0C34.7694 0 43.4785 6.16544 47.2971 14.9445Z"
                fill="#7059E2"
              />
              <path
                d="M49.2397 24.5948C49.2397 38.199 38.1859 49.2566 24.5863 49.2566C22.9115 49.2566 21.2366 49.0555 19.6958 48.7875V19.6356C19.6958 16.955 21.8396 14.8105 24.5193 14.8105H44.2822C45.2871 14.8105 46.292 14.8775 47.2299 15.0115C48.5028 17.8932 49.2397 21.177 49.2397 24.5948Z"
                fill="#2929CC"
              />
              <path
                d="M68.9357 39.6063C68.8017 53.2104 57.5469 64.067 44.0143 64.067H24.5193C21.8396 64.067 19.6958 61.9225 19.6958 59.2419V48.7874C21.3036 49.1225 22.9115 49.2565 24.5863 49.2565C38.1859 49.2565 49.2397 38.1989 49.2397 24.5947C49.2397 21.1769 48.5028 17.8932 47.2969 14.9445C59.5567 16.4188 69.0027 26.9403 68.9357 39.6063Z"
                fill="#569FE8"
              />
              <path
                d="M40.7987 27.0743H25.6583C25.0554 27.0743 24.5864 26.6052 24.5864 26.0021V23.1874C24.5864 22.5843 25.0554 22.1152 25.6583 22.1152H40.7987C41.4017 22.1152 41.8706 22.5843 41.8706 23.1874V26.0021C41.8706 26.6052 41.4017 27.0743 40.7987 27.0743Z"
                fill="white"
              />
              <path
                d="M38.521 39.4052H25.4573C24.9884 39.4052 24.5864 39.0031 24.5864 38.534V35.3173C24.5864 34.8482 24.9884 34.4461 25.4573 34.4461H38.521C38.9899 34.4461 39.3919 34.8482 39.3919 35.3173V38.534C39.3919 39.0031 38.9899 39.4052 38.521 39.4052Z"
                fill="white"
              />
              <path
                d="M111.208 39.8073C110.472 41.6838 109.4 43.2921 107.993 44.6995C106.586 46.1068 104.978 47.1791 103.102 48.0503C101.227 48.8544 99.1497 49.2565 96.805 49.2565C94.4602 49.2565 92.4504 48.8544 90.5076 48.0503C88.6318 47.2461 86.957 46.1738 85.6171 44.7665C84.2773 43.3592 83.2054 41.7508 82.4685 39.8743C81.7315 37.9979 81.3296 36.0545 81.3296 33.9099C81.3296 31.8325 81.7315 29.822 82.4685 27.9456C83.2054 26.0691 84.2773 24.4607 85.6841 23.0534C87.091 21.6461 88.6988 20.5738 90.5746 19.7026C92.4504 18.8984 94.5272 18.4963 96.872 18.4963C99.2167 18.4963 101.227 18.8984 103.169 19.7026C105.045 20.5068 106.72 21.5791 108.06 22.9864C109.4 24.3937 110.472 26.0021 111.208 27.8785C111.945 29.755 112.347 31.6984 112.347 33.8429C112.347 35.9874 111.945 37.9309 111.208 39.8073ZM106.117 29.889C105.648 28.6157 104.911 27.4764 104.04 26.5382C103.169 25.6 102.097 24.7958 100.825 24.2597C99.5517 23.7236 98.2118 23.3885 96.738 23.3885C95.2641 23.3885 93.9243 23.6565 92.7184 24.1927C91.5125 24.7288 90.4406 25.466 89.5697 26.4712C88.6988 27.4094 88.0289 28.5487 87.493 29.822C87.024 31.0953 86.756 32.5026 86.756 33.9099C86.756 35.3173 87.024 36.7246 87.493 37.9979C87.9619 39.2712 88.6988 40.4105 89.5697 41.3487C90.4406 42.2869 91.5125 43.0911 92.7854 43.6272C94.0583 44.1634 95.3981 44.4984 96.872 44.4984C98.3458 44.4984 99.6857 44.2304 100.892 43.6942C102.097 43.1581 103.169 42.4209 104.04 41.4157C104.911 40.4775 105.581 39.3382 106.117 38.0649C106.586 36.7916 106.854 35.3843 106.854 33.977C106.854 32.5026 106.653 31.1623 106.117 29.889Z"
                fill="#5D5D60"
              />
              <path
                d="M120.185 48.7204H115.027V26.3372H120.185V29.822C120.52 29.2859 120.922 28.7497 121.391 28.2806C121.86 27.8115 122.329 27.4094 122.932 27.0073C123.535 26.6052 124.138 26.3372 124.808 26.1361C125.478 25.9351 126.282 25.8011 127.153 25.8011C129.698 25.8011 131.641 26.6052 133.048 28.1466C134.455 29.688 135.125 31.7655 135.125 34.4461V48.7204H129.966V36.0545C129.966 34.312 129.564 32.9717 128.693 32.0335C127.823 31.0953 126.684 30.6262 125.21 30.6262C123.736 30.6262 122.53 31.0953 121.592 32.1005C120.654 33.1058 120.185 34.4461 120.185 36.1885V48.7204V48.7204Z"
                fill="#5D5D60"
              />
              <path
                d="M165.406 39.7403C164.669 41.5497 163.53 43.1581 162.19 44.4984C160.783 45.8388 159.109 46.844 157.166 47.6482C155.223 48.3853 153.079 48.7874 150.801 48.7874H139.748V19.0995H150.734C153.079 19.0995 155.156 19.5016 157.099 20.2388C159.042 20.9759 160.716 22.0482 162.123 23.3215C163.53 24.6618 164.602 26.2032 165.339 28.0126C166.076 29.822 166.478 31.7655 166.478 33.8429C166.545 35.9874 166.143 37.9309 165.406 39.7403ZM160.314 29.889C159.845 28.6827 159.109 27.6105 158.238 26.6723C157.367 25.734 156.295 25.0639 154.955 24.5278C153.682 23.9916 152.275 23.7906 150.734 23.7906H144.839V44.0293H150.734C152.275 44.0293 153.682 43.7613 154.955 43.2922C156.228 42.823 157.3 42.0859 158.238 41.2147C159.109 40.3435 159.845 39.2712 160.314 37.9979C160.783 36.7916 161.051 35.3843 161.051 33.91C161.051 32.5026 160.783 31.0953 160.314 29.889Z"
                fill="#5D5D60"
              />
              <path
                d="M191.533 42.0859C190.93 43.4932 190.059 44.7665 189.054 45.7717C187.983 46.844 186.71 47.6482 185.236 48.3183C183.762 48.9215 182.154 49.2566 180.479 49.2566C178.805 49.2566 177.197 48.9215 175.723 48.3183C174.249 47.7152 173.043 46.844 171.971 45.8388C170.899 44.7665 170.095 43.5602 169.492 42.1529C168.89 40.7456 168.622 39.2712 168.622 37.6628C168.622 36.0545 168.957 34.5131 169.559 33.1058C170.162 31.6984 171.033 30.4251 172.038 29.3529C173.11 28.2806 174.383 27.4765 175.79 26.8063C177.264 26.2032 178.805 25.8681 180.546 25.8681C182.288 25.8681 183.829 26.2032 185.303 26.8063C186.777 27.4094 187.983 28.2806 189.054 29.2859C190.126 30.3581 190.93 31.5644 191.533 32.9717C192.136 34.3791 192.404 35.9204 192.404 37.5288C192.471 39.1372 192.136 40.6785 191.533 42.0859ZM186.777 34.8482C186.442 33.977 185.973 33.1728 185.37 32.5696C184.767 31.8995 184.03 31.3634 183.226 31.0283C182.422 30.6932 181.484 30.4251 180.479 30.4251C179.474 30.4251 178.537 30.6262 177.733 31.0283C176.929 31.4304 176.192 31.8995 175.589 32.5696C174.986 33.2398 174.517 33.977 174.249 34.8482C173.914 35.7194 173.78 36.6576 173.78 37.5958C173.78 38.6011 173.981 39.5393 174.316 40.4105C174.651 41.2817 175.12 42.0859 175.723 42.689C176.326 43.3592 177.063 43.8283 177.867 44.2304C178.671 44.6325 179.608 44.8335 180.613 44.8335C181.618 44.8335 182.556 44.6325 183.427 44.2304C184.298 43.8283 184.968 43.3592 185.571 42.689C186.174 42.0189 186.643 41.2817 186.911 40.4105C187.246 39.5393 187.38 38.6011 187.38 37.6628C187.313 36.6576 187.112 35.7194 186.777 34.8482Z"
                fill="#5D5D60"
              />
              <path
                d="M211.028 48.1173C209.621 48.9215 207.813 49.2566 205.669 49.2566C203.994 49.2566 202.453 48.9215 201.046 48.3183C199.64 47.7152 198.434 46.844 197.362 45.8388C196.29 44.7665 195.486 43.5602 194.95 42.1529C194.347 40.7456 194.079 39.2712 194.079 37.6628C194.079 36.0545 194.347 34.5131 194.95 33.1058C195.553 31.6984 196.357 30.4251 197.362 29.3529C198.434 28.2806 199.64 27.4094 201.046 26.8063C202.453 26.2032 203.994 25.8681 205.669 25.8681C207.813 25.8681 209.554 26.2032 210.961 26.9403C212.368 27.6775 213.574 28.5487 214.646 29.755L211.497 33.1728C210.693 32.3686 209.889 31.6984 208.952 31.1623C208.081 30.6262 206.942 30.3581 205.669 30.3581C204.731 30.3581 203.86 30.5592 203.056 30.9613C202.252 31.3634 201.582 31.8325 201.046 32.5026C200.51 33.1728 200.041 33.91 199.707 34.7812C199.372 35.6524 199.238 36.5906 199.238 37.5288C199.238 38.534 199.372 39.4723 199.707 40.3435C200.041 41.2147 200.51 41.9518 201.113 42.622C201.716 43.2922 202.386 43.7613 203.257 44.1634C204.061 44.5655 204.999 44.7665 205.937 44.7665C207.143 44.7665 208.215 44.4984 209.153 43.9623C210.09 43.4262 210.961 42.756 211.765 41.9518L214.847 45.0346C213.708 46.3079 212.435 47.3131 211.028 48.1173Z"
                fill="#5D5D60"
              />
            </g>
            <defs>
              <clipPath id="clip0_52_402">
                <rect width="214.78" height="64" fill="white" />
              </clipPath>
            </defs>
          </svg>
        </div>

        <form class="form flex flex-col" @submit.prevent="submitForm">
          <h2 class="field-title mb-8 font-bold text-20 md:text-base text-[#2929CC]">
            {{ $t("Register") }}
          </h2>
          <div class="wrapper grid grid-cols-1 md:grid-cols-2 mb-10">
            <div class="input-field flex gap-4 flex-col">
              <label class="text-[#7059E2] text-16 font-bold" for="email">{{
                $t("E-Mail")
              }}</label>
              <p class="p-0 text-[#AAAAB1]">{{ appuser.email }}</p>
            </div>
          </div>

          <div class="wrapper grid grid-cols-1 md:grid-cols-2 gap-[30px] mb-10">
            <TextInput
              :label="`${$t('First Name')}*`"
              :inputClass="`${
                form.errors.first_name || v$.first_name.$invalid ? '' : 'border-[0px]'
              } shadow-form`"
              placeholder="First Name"
              maxLength="41"
              labelClass="text-[#7059E2]"
              v-model="form.first_name"
              :error="
                (form.errors.first_name ? true : false) ||
                v$.first_name.$errors[0]?.$message
              "
              @input="
                () => {
                  v$.first_name.$touch();
                  form.clearErrors('first_name');
                }
              "
            />

            <TextInput
              :label="`${$t('Last Name')}*`"
              placeholder="Last Name"
              :inputClass="`${
                form.errors.last_name || v$.last_name.$invalid ? '' : 'border-[0px]'
              } shadow-form`"
              labelClass="text-[#7059E2]"
              maxLength="41"
              v-model="form.last_name"
              :error="
                (form.errors.last_name ? true : false) ||
                v$.last_name.$errors[0]?.$message
              "
              @input="
                () => {
                  v$.last_name.$touch();
                  form.clearErrors('last_name');
                }
              "
            />
          </div>

          <div
            class="wrapper grid grid-cols-1 md:grid-cols-2 gap-[30px] md:mb-16 mb-[30px]"
          >
            <PhoneInputWithCountryCode
              :label="`${$t('Phone Number')}*`"
              labelClass="text-[#7059E2]"
              :class="`${form.errors.phone_number ? '' : 'border-[0px]'} shadow-form`"
              :error="form.errors.phone_number"
              v-model:phone_number="form.phone_number"
              v-model:country_code="form.country_iso_code"
              @updated="
                () => {
                  form.clearErrors('phone_number', 'country_iso_code');
                }
              "
              :lang="lang"
              :key="componentKey"
            />
            <TextInput
              label="Company"
              placeholder="Company Name"
              :inputClass="`${
                form.errors.company || v$.company.$invalid ? '' : 'border-[0px]'
              } shadow-form`"
              labelClass="text-[#7059E2]"
              maxLength="31"
              v-model="form.company"
              :error="
                v$.company.$errors[0]?.$message ?? (form.errors.company ? true : false)
              "
              @input="
                () => {
                  form.clearErrors('company');
                  v$.company.$touch();
                }
              "
            />
          </div>

          <h2 class="field-title mb-8 font-bold text-20 text-base hidden md:block">
            {{ $t("Password") }}
          </h2>
          <div class="wrapper grid grid-cols-1 md:grid-cols-2 gap-[30px] mb-[34px]">
            <TextInput
              labelClass="text-[#7059E2]"
              :inputClass="`${form.errors.password ? '' : 'border-[0px]'} shadow-form`"
              :label="`${$t('Password')}*`"
              placeholder="Set password"
              type="password"
              :error="form.errors.password"
              v-model="form.password"
              @clearError="form.clearErrors('password', 'confirm_password')"
            />
            <TextInput
              labelClass="text-[#7059E2]"
              :inputClass="`${
                form.errors.confirm_password ? '' : 'border-[0px]'
              } shadow-form`"
              :label="`${$t('Confirm Password')}*`"
              placeholder="Repeat password"
              type="password"
              :error="form.errors.confirm_password"
              v-model="form.confirm_password"
              @clearError="form.clearErrors('confirm_password')"
            />
          </div>

          <div class="wrapper grid grid-cols-2 md:grid-cols-2 gap-[30px] mb-[47px]">
            <div
              class="input-field flex col-span-2 gap-2 md:justify-start justify-center"
            >
              <Checkbox
                :checked="form.tos"
                @click="
                  () => {
                    form.tos = !form.tos;
                    form.clearErrors('tos');
                  }
                "
                :error="form.errors.tos"
              />
              <span class="text-base">
                {{ $t("Accept") }}
                <a class="underline cursor-pointer" href="https://ondoc.ch/en/allgemeine-geschaeftsbedingungen/" target="_blank">{{ $t("terms of use") }}</a>
              </span>
            </div>
          </div>

          <div class="wrapper flex mb-[47px] md:justify-start justify-center">
            <PrimaryButton
              class="text-white font-bold text-18 px-[21px] py-[18px] bg-[#7059E2] text-center rounded-[8px]"
              >{{ $t("Submit Registration") }}</PrimaryButton
            >
          </div>
        </form>
      </div>
    </div>
    <div class="image h-full w-full relative items-end justify-end hidden md:flex">
      <img src="/images/left_background.png" class="h-full w-full absolute z-[-1]" />
      <div class="languages flex gap-[27px] z-1 fixed top-[92%] right-[2%]">
        <LanguageSwitcher @changeLanguage="setLanguage" />
      </div>
    </div>
  </div>
</template>

<script setup>
import TextInput from "../../Components/Form/TextInput.vue";
import PhoneInputWithCountryCode from "../../Components/PhoneInputWithCountryCode";
import PrimaryButton from "../../Components/PrimaryButton";
import { useForm } from "@inertiajs/inertia-vue3";
import { useVuelidate } from "@vuelidate/core";
import { maxLength, helpers, required, sameAs } from "@vuelidate/validators";
import Checkbox from "./Components/Checkbox.vue";
import LanguageSwitcher from "../../Components/LanguageSwitcher.vue";
import LanguageSwitcherMobile from "../../Components/LanguageSwitcherMobile.vue";
import { trans } from "laravel-vue-i18n";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
const props = defineProps({
  appuser: {
    type: Object,
    required: true,
  },
  company: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  first_name: props.appuser.first_name,
  last_name: props.appuser.last_name,
  language_id: props.appuser.language_id,
  password: "",
  company_id: props.company.id,
  company: "",
  confirm_password: "",
  country_iso_code: "CH",
  phone_number: "",
  tos: false,
});

const setLanguage = (code) => {
  const codes_to_id = { de: 1, en: 2, fr: 3, it: 4 };
  form.language_id = codes_to_id[code] ?? "en";
  lang.value = code;
  componentKey.value++;
};

const code = usePage().props.value.language_code ?? localStorage.getItem("lang") ?? "de";

const lang = ref(code);
const componentKey = ref(0);

const rules = {
  first_name: {
    maxLength: helpers.withMessage(
      trans("Maximum :length characters allowed", { length: 40 }),
      maxLength(40)
    ),
  },
  last_name: {
    maxLength: helpers.withMessage(
      trans("Maximum :length characters allowed", { length: 40 }),
      maxLength(40)
    ),
  },
  company: {
    maxLength: helpers.withMessage(
      trans("Maximum :length characters allowed", { length: 30 }),
      maxLength(30)
    ),
  },
};
const v$ = useVuelidate(rules, form);

const submitForm = () => {
  form.clearErrors();
  form.put(route("appusers.register.success", { appuser: props.appuser.id }), {
    onSuccess: () => console.log("form submited"),
  });
};
</script>

<script>
import AuthLayout from "../../Layouts/Auth.vue";

export default {
  layout: AuthLayout,
};
</script>
