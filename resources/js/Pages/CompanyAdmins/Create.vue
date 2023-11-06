<template>
    <div class="page bg-white p-8 rounded-[8px]">
        <div class="head mb-12">
            <Back
                :backPrevUrl="false"
                :show-modal="form.isDirty"
                :target="route('company-admins.index')"
            />
            <h1 class="title font-bold text-20 text-[#7059E2]">{{ $t('Add Admin User') }}</h1>
        </div>

        <form @submit.prevent="submitForm">
            <div class="content mb-10">
                <div class="form__section">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field flex gap-3 flex-col w-[285px]">
                            <label class="text-base text-16 font-bold text-[#5D5D60] ">{{ $t('Admin ID') }}</label>
                            <p class="p-0 text-[#5D5D60]">{{ prefix_id }}</p>
                        </div>
                        <div class="input-field w-[285px]">
                            <SelectOption
                                :options="companies"
                                :label="`${$t('Company')}*`"
                                placeholder="Choose Company"
                                v-model="form.company_id"
                                :error="v$.company_id.$errors[0]?.$message || form.errors.company_id"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <SelectOption
                                :options="languages"
                                label="Preferred Language"
                                placeholder="Select Language"
                                v-model="form.language_id"
                                :error="form.errors.language_id"
                            />
                        </div>
                    </div>
                </div>
                <div class="form__section mt-14">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('First Name')}*`"
                                placeholder="First Name"
                                maxLength="41"
                                v-model="form.first_name"
                                :error="v$.first_name.$errors[0]?.$message || form.errors.first_name"
                                @input="v$.first_name.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Last Name')}*`"
                                placeholder="Last Name"
                                maxLength="41"
                                v-model="form.last_name"
                                :error="v$.last_name.$errors[0]?.$message || form.errors.last_name"
                                @input="v$.last_name.$touch()"
                            />
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                :label="`${$t('Email')}*`"
                                placeholder="Email"
                                maxLength="41"
                                v-model="form.email"
                                :error="v$.email.$errors[0]?.$message || form.errors.email"
                                @input="v$.email.$touch()"
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
                                {{ $t('Send Invitation') }}
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
import SelectOption from "../../Components/Form/SelectOption"

const props = defineProps({
    prefix_id: {
        type: String,
        required: true,
    },
    companies: {
        type: Array,
        required: true
    },
    languages: {
        type: Array,
        required: true,
    }
});

const form = useForm({
    first_name: "",
    last_name: "",
    email: "",
    company_id: '',
    language_id: 1,
})


const rules = {
    first_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    last_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    email: {
        required: helpers.withMessage("", required),
        email: helpers.withMessage(trans('Invalid email, please add a valid email address'), email),
    },
    company_id: {
        required: helpers.withMessage("", required),
    },
}
const v$ = useVuelidate(rules, form)

const hasEmptyRequiredField = computed(() => {
    if(form.email && v$.value['email'].email.$invalid){
        return true;
    }
    if(form.email && v$.value['email'].required.$invalid){
        return true;
    }

    for (const key in rules) {
        if (Object.hasOwnProperty.call(rules[key], 'required') && v$.value[key].required.$invalid)
            return true;
    }

})

const submitForm = () => {
    form.post(route('company-admins.store'), {
        // onSuccess: () => console.log('form submited'),
    })
}
</script>
