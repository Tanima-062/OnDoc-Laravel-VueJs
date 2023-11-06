<template>
    <div class="page bg-white p-8 rounded-[8px]">
        <div class="head mb-12">
            <Back
                :backPrevUrl="false"
                :show-modal="form.isDirty"
                :target="route('companies.index')"
            />
            <h1 class="title font-bold text-20 text-[#7059E2]">{{ $t('Add Company') }}</h1>
        </div>

        <form @submit.prevent="submitForm">
            <div class="content mb-10">
                <div class="form__section">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field flex gap-3 flex-col w-[285px]">
                            <label class="text-base text-16 font-bold text-[#5D5D60] ">{{ $t('Company ID') }}</label>
                            <p class="p-0 text-[#5D5D60]">{{ prefix_id }}</p>
                        </div>
                    </div>
                </div>
                <div class="form__section mt-14">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <div class="flex">
                                <div class="image__preview w-[100px] h-[100px] bg-[#7059E2] mr-5 flex items-center justify-center" >
                                    <img :src="form.company_image_url" v-if="form.company_image_url"  alt="">
                                </div>
                                <div>
                                    <label class="form-label block mb-3 text-16 text-[#5D5D60] font-bold" for="text-input-ce7de8d4-8947-4009-ad04-9b42c775a538">{{ $t("Company Logo") }}</label>
                                    <label for="company_image" class="mt-5 block">
                                        <p class="flex items-center form-label text-16 text-[#5D5D60] font-bold gap-2.5 cursor-pointer">
                                            <UploadIcon /> {{ $t("Select Photo") }}
                                        </p>
                                    </label>
                                    <p
                                        v-if="form.logo"
                                            class="flex items-center clear-image form-label text-16 text-[#5D5D60] font-bold gap-2.5 cursor-pointer mt-5"
                                            @click="clearImage"
                                        >
                                        <CloseIcon fillColor="#5D5D60" height="12" width="12" />
                                        {{ $t("Clear Photo") }}
                                    </p>
                                    <input
                                        ref="companyFile"
                                        type="file"
                                        id="company_image"
                                        class="hidden"
                                        accept="image/png, image/jpeg, image/jpg"
                                        @change="onImageChange"
                                    />
                                    <div v-if="form.errors.logo" class="form-error error">
                                        {{ form.errors.logo }}
                                    </div>
                                </div>
                            </div>
                            <span class="helper-text pt-1 block text-[14px] text-[#5D5D60]">{{ $t('Max :mb MB | JPG or PNG only', {mb: 5}) }}</span>
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Company Name')}*`"
                                placeholder="Company Name"
                                maxLength="41"
                                v-model="form.name"
                                :error="v$.name.$errors[0]?.$message || form.errors.name"
                                @input="v$.name.$touch()"
                            />
                        </div>
                    </div>
                </div>
                <div class="form__section mt-14">
                    <div class="form__section--header">
                        <h3 class="title font-bold text-18 text-[#7059E2] mb-5">{{ $t('Company Address') }}</h3>
                    </div>
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Street Name')}*`"
                                placeholder="Street Name"
                                maxLength="21"
                                v-model="form.street"
                                :error="v$.street.$errors[0]?.$message || form.errors.street"
                                @input="v$.street.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Street Number')}*`"
                                placeholder="Street Number"
                                maxLength="21"
                                v-model="form.house_number"
                                :error="v$.house_number.$errors[0]?.$message || form.errors.house_number"
                                @input="v$.house_number.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Zip Code')}*`"
                                placeholder="0000"
                                maxLength="5"
                                v-model="form.postal_code"
                                :error="v$.postal_code.$errors[0]?.$message || form.errors.postal_code"
                                @input="v$.postal_code.$touch()"
                            />
                        </div>
                    </div>
                    <div class="wrapper flex gap-[30px] mt-6">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('City')}*`"
                                placeholder="City"
                                maxLength="21"
                                v-model="form.city"
                                :error="v$.city.$errors[0]?.$message || form.errors.city"
                                @input="v$.city.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <CountrySelect
                                v-model="form.country_code"
                                :label="`${$t('Country')}*`"
                                :placeholder="`${$t('Country')}`"
                                :error="form.errors.country_code"
                                @changeCountry="(code)=> form.country_iso_code = code"
                            ></CountrySelect>
                        </div>
                    </div>
                </div>
                <div class="form__section mt-14">
                    <div class="form__section--header">
                        <h3 class="title font-bold text-18 text-[#7059E2] mb-5">{{ $t('Contact Person') }}</h3>
                    </div>
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('First Name')}*`"
                                placeholder="First Name"
                                maxLength="41"
                                v-model="form.contact_persion_first_name"
                                :error="v$.contact_persion_first_name.$errors[0]?.$message || form.errors.contact_persion_first_name"
                                @input="v$.contact_persion_first_name.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Last Name')}*`"
                                placeholder="Last Name"
                                maxLength="41"
                                v-model="form.contact_persion_last_name"
                                :error="v$.contact_persion_last_name.$errors[0]?.$message || form.errors.contact_persion_last_name"
                                @input="v$.contact_persion_last_name.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('E-Mail')}*`"
                                placeholder="eg. john@gmail.com"
                                maxLength="41"
                                v-model="form.contact_persion_email"
                                :error="v$.contact_persion_email.$errors[0]?.$message || form.errors.contact_persion_email"
                                @input="v$.contact_persion_email.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <PhoneInputWithCountryCode
                                :label="`${$t('Phone Number')}*`"
                                labelClass="text-[#5D5D60]"
                                class=""
                                :error="form.errors.phone_number"
                                v-model:phone_number="form.phone_number"
                                v-model:country_code="form.country_iso_code"
                                @updated="form.clearErrors('phone_number', 'country_iso_code')"
                                :lang="lang"
                            />
                        </div>
                    </div>
                </div>
                <div class="form__section">
                    <div class="wrapper flex mt-10 gap-[30px]">
                        <div class="input-field w-[285px]">
                            <PrimaryButton
                                class="text-white font-bold text-18 px-[21px] py-[18px] bg-[#7059E2] text-center rounded-[8px] "
                                :disabled="hasEmptyRequiredField"
                            >
                                {{ $t('Save') }}
                            </PrimaryButton>
                        </div>
                        <div class="input-field w-[285px]">
                            <Cancel
                                target="#"
                                :backPrevUrl="true"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import Back from '../../Components/Form/Back.vue';
import TextInput from "../../Components/Form/TextInput"
import PrimaryButton from "../../Components/PrimaryButton"
import Cancel from "../../Components/Form/Cancel.vue"
import { useForm } from '@inertiajs/inertia-vue3';
import { useVuelidate } from '@vuelidate/core'
import { email, maxLength, helpers, required } from "@vuelidate/validators"
import { computed } from '@vue/reactivity';
import { trans } from "laravel-vue-i18n"
import CountrySelect from '../../Components/Form/CountrySelect.vue'
import PhoneInputWithCountryCode from '../../Components/PhoneInputWithCountryCode.vue'

import CloseIcon from '../../Components/Icons/CloseIcon.vue'
import UploadIcon from '../../Components/Icons/Upload.vue'
import { usePage } from "@inertiajs/inertia-vue3";
import { ref } from 'vue'

const props = defineProps({
    prefix_id: {
        type: String,
        required: true,
    }
});

const form = useForm({
    name: "",
    street: "",
    house_number: "",
    postal_code: "",
    city: "",
    country_code: "ch",
    contact_persion_first_name: "",
    contact_persion_last_name: "",
    contact_persion_email: "",
    phone_number: "",
    country_iso_code: "ch",
    company_image_url: null,
    logo: null
})

const code = usePage().props.value.language_code ?? localStorage.getItem('lang') ?? 'de';
const lang = ref(code)

const rules = {
    name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    street: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 20}), maxLength(20)),
        required: helpers.withMessage("", required)
    },
    house_number: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 20}), maxLength(20)),
        required: helpers.withMessage("", required)
    },
    postal_code: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 4}), maxLength(4)),
        required: helpers.withMessage("", required)
    },
    city: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 20}), maxLength(20)),
        required: helpers.withMessage("", required)
    },
    country_code: {
        // maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    contact_persion_first_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    contact_persion_last_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    contact_persion_email: {
        email: helpers.withMessage(trans('Invalid email, please add a valid email address'), email),
        required: helpers.withMessage("", required)
    },
}
const v$ = useVuelidate(rules, form)

const hasEmptyRequiredField = computed(() => {
    if(form.contact_persion_email && v$.value['contact_persion_email'].email.$invalid){
        return true;
    }
    if(form.country_iso_code == null || form.country_iso_code == '' || form.phone_number == '' || form.phone_number == null){
        return true;
    }

    for (const key in rules) {
        if (Object.hasOwnProperty.call(rules[key], 'required') && v$.value[key].required.$invalid)
            return true;
    }

})

const onImageChange = (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        form.company_image_url = reader.result;
        form.logo = file;
    };
    reader.readAsDataURL(file);
};

const clearImage = () => {
    form.logo = null;
    form.company_image_url = "";
};

const submitForm = () => {
    form.post(route('companies.store'), {
        onSuccess: () => console.log('form submited'),
    })
}
</script>
