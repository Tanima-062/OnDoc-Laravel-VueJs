<template>
    <div class="page bg-white p-8 rounded-[8px]">
        <div class="head mb-12">
            <Back
                :backPrevUrl="false"
                :show-modal="form.isDirty"
                :target="route('suppliers.index')"
            />
            <h1 class="title font-bold text-20 text-[#7059E2]">{{ $t('Add Supplier') }}</h1>
        </div>

        <form @submit.prevent="submitForm">
            <div class="content mb-10">
                <div class="form__section">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field flex gap-3 flex-col w-[285px]">
                            <label class="text-base text-16 font-bold text-[#5D5D60] ">{{ $t('Supplier ID') }}</label>
                            <p class="p-0 text-[#5D5D60]">{{ prefix_id }}</p>
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Supplier Name')}*`"
                                placeholder="Name"
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
                        <h3 class="title font-bold text-18 text-[#7059E2] mb-5">{{ $t('Address') }}</h3>
                    </div>
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Street')}*`"
                                placeholder="Street"
                                maxLength="41"
                                v-model="form.street"
                                :error="v$.street.$errors[0]?.$message || form.errors.street"
                                @input="v$.street.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('House number')}*`"
                                placeholder="00"
                                maxLength="41"
                                v-model="form.house_number"
                                :error="v$.house_number.$errors[0]?.$message || form.errors.house_number"
                                @input="v$.house_number.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Postal code')}*`"
                                placeholder="0000"
                                maxLength="41"
                                v-model="form.postal_code"
                                :error="v$.postal_code.$errors[0]?.$message || form.errors.postal_code"
                                @input="v$.postal_code.$touch()"
                            />
                        </div>

                    </div>
                </div>
                <div class="form__section mt-10">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Location')}*`"
                                placeholder="Location"
                                maxLength="41"
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
                            ></CountrySelect>
                        </div>
                    </div>
                </div>
                <div class="form__section mt-14">
                    <div class="form__section--header">
                        <h3 class="title font-bold text-18 text-[#7059E2] mb-5">{{ $t('Contact Info') }}</h3>
                    </div>
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Contact Person name')}`"
                                placeholder="Name"
                                maxLength="41"
                                v-model="form.contact_persion_name"
                                :error="v$.contact_persion_name.$errors[0]?.$message || form.errors.contact_persion_name"
                                @input="v$.contact_persion_name.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Contact Person Email')}`"
                                placeholder="eg. john@gmail.com"
                                maxLength="41"
                                v-model="form.contact_persion_email"
                                :error="v$.contact_persion_email.$errors[0]?.$message || form.errors.contact_persion_email"
                                @input="v$.contact_persion_email.$touch()"
                            />
                        </div>
                    </div>
                </div>
                <div class="form__section">
                    <div class="wrapper flex mt-10 gap-[30px]">
                        <div class="input-field w-[285px]">
                            <PrimaryButton
                                class="text-white font-bold text-18 px-[21px] py-[18px] bg-[#7059E2] text-center rounded-[8px]"
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
    country_code: "",
    contact_persion_name: "",
    contact_persion_email: ""
})

const rules = {
    name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    street: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    house_number: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    postal_code: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    city: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    country_code: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    contact_persion_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
    },
    contact_persion_email: {
        email: helpers.withMessage(trans('Invalid email, please add a valid email address'), email),
    },
}
const v$ = useVuelidate(rules, form)

const hasEmptyRequiredField = computed(() => {
    if(form.contact_persion_email && v$.value['contact_persion_email'].email.$invalid){
        return true;
    }
    // if(form.contact_persion_name && v$.value['contact_persion_name'].maxLength.$invalid){
    //     return true;
    // }

    for (const key in rules) {
        if (Object.hasOwnProperty.call(rules[key], 'required') && v$.value[key].required.$invalid)
            return true;
        if (Object.hasOwnProperty.call(rules[key], 'maxLength') && v$.value[key].maxLength.$invalid)
            return true;
    }

})

const submitForm = () => {
    form.post(route('suppliers.store'), {
        // onSuccess: () => console.log('form submited'),
    })
}
</script>
