<template>
    <div class="page bg-white p-8 rounded-[8px]">
        <div class="head mb-12">
            <Back
                :backPrevUrl="true"
                :show-modal="form.isDirty"
            />
            <h1 class="title font-bold text-20 text-[#7059E2]">{{ $t('Add App User') }}</h1>
        </div>

        <form @submit.prevent="submitForm">
            <div class="content mb-10">
                <div class="form">
                    <div class="wrapper grid grid-cols-5 gap-[30px]">
                        <TextInput
                            label="First Name*"
                            placeholder="First Name"
                            maxLength="41"
                            v-model="form.first_name"
                            :error="v$.first_name.$errors[0]?.$message || form.errors.first_name"
                            @input="v$.first_name.$touch()"
                        />

                        <TextInput
                            label="Last Name*"
                            placeholder="Last Name"
                            maxLength="41"
                            v-model="form.last_name"
                            :error="v$.last_name.$errors[0]?.$message || form.errors.last_name"
                            @input="v$.last_name.$touch()"
                        />

                        <TextInput
                            label="Email*"
                            placeholder="Email"
                            v-model="form.email"
                            :error="v$.email.$errors[0]?.$message || form.errors.email"
                            @input="form.clearErrors('email')"
                            @focusout="v$.email.$touch()"
                        />
                        <SelectOption
                            :options="languages"
                            :label="`${$t('Preferred Language')}*`"
                            placeholder="Select Language"
                            v-model="form.language_id"
                            :error="form.errors.language_id"
                        />
                    </div>
                </div>
            </div>

            <div class="footer grid grid-cols-5 gap-[30px]">
                <PrimaryButton
                    class="text-white font-bold text-18 w-full bg-primary-1-1"
                    :disabled="v$.$invalid || form.processing"
                >{{ $t('Send Invitation') }}</PrimaryButton>
                <Cancel
                    target="#"
                    class="w-full"
                    :backPrevUrl="true"
                />
            </div>
        </form>
    </div>
</template>
<script setup>
import Back from '../../Components/Form/Back.vue';
import TextInput from "../../Components/Form/TextInput"
import SelectOption from "../../Components/Form/SelectOption"
import PrimaryButton from "../../Components/PrimaryButton"
import Cancel from "../../Components/Form/Cancel.vue"
import { useForm } from '@inertiajs/inertia-vue3';
import { useVuelidate } from '@vuelidate/core'
import { email, maxLength, helpers, required } from "@vuelidate/validators"
import { computed } from '@vue/reactivity';
import { trans } from "laravel-vue-i18n"

defineProps({
    languages: {
        type: Array,
        required: true,
    }
})

const form = useForm({
    first_name: "",
    last_name: "",
    email: "",
    language_id: 1
})

const rules = {
    first_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", { length: 40 }), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    last_name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", { length: 40 }), maxLength(40)),
        required: helpers.withMessage("", required)
    },
    email: {
        email: helpers.withMessage(trans('Invalid email, please add a valid email address'), email),
        required: helpers.withMessage("", required)
    }
}
const v$ = useVuelidate(rules, form)

const submitForm = () => {
    form.post(route('appusers.store'), {
        onSuccess: () => console.log('form submited'),
    })
}
</script>
