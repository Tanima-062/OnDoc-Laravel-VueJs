<template>
    <div class="page bg-white p-8 rounded-[8px]">
        <div class="head mb-12">
            <Back
                :backPrevUrl="false"
                :show-modal="form.isDirty"
                :target="route('categories.index')"
            />
            <h1 class="title font-bold text-20 text-[#7059E2]">{{ $t('Add a Category') }}</h1>
        </div>

        <form @submit.prevent="submitForm">
            <div class="content mb-10">
                <div class="form">
                    <div class="wrapper flex gap-[30px]">
                        <div class="input-field flex gap-3 flex-col w-[285px]">
                            <label class="text-base text-16 font-bold text-[#5D5D60] ">{{ $t('Category ID') }}</label>
                            <p class="p-0 text-[#5D5D60]">{{ prefix_id }}</p>
                        </div>
                        <div class="input-field w-[285px]">
                            <TextInput
                                label="Category Name"
                                placeholder="Name"
                                maxLength="41"
                                v-model="form.name"
                                :error="v$.name.$errors[0]?.$message || form.errors.name"
                                @input="v$.name.$touch()"
                            />
                        </div>
                    </div>
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

const props = defineProps({
    prefix_id: {
        type: String,
        required: true,
    }
});

const form = useForm({
    name: "",
})

const rules = {
    name: {
        maxLength: helpers.withMessage(trans("Maximum :length characters allowed", {length: 40}), maxLength(40)),
        required: helpers.withMessage("", required)
    },
}
const v$ = useVuelidate(rules, form)

const hasEmptyRequiredField = computed(() => {
    for (const key in rules) {
        if (Object.hasOwnProperty.call(rules[key], 'required') && v$.value[key].required.$invalid)
            return true;
    }
})

const submitForm = () => {
    form.post(route('categories.store'), {
        onSuccess: () => console.log('form submited'),
    })
}
</script>
