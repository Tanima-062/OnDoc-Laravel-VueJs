<template>
    <div class="wrapper">

        <div class="label mb-3 flex gap-[8px]">
            <label
                v-if="label"
                class="text-base font-bold text-16"
                :class="$attrs.labelClass"
                :for="id"
            >{{ $t(label) }}</label>
            <PasswordTooltip v-if="$attrs.showTooltip" />
        </div>
        <div class="password-input toggleable relative">
            <input
                :id="id"
                ref="input"
                v-bind="$attrs"
                class="text__input"
                :class="[error ? 'border-[#FF0000] border' : '', $attrs.inputClass]"
                :value="$attrs.modelValue"
                :placeholder="$t(placeholder)"
                @input="changeInput"
                :type="type"
            />

            <div
                v-show="toggleable"
                class=" absolute top-[50%] right-[3%] translate-y-[-50%] cursor-pointer"
                @click="type == 'password' ? type = 'text' : type = 'password'"
            >
                <eye-close v-show="type != 'password'" />
                <eye-open v-show="type == 'password'" />
            </div>
        </div>

        <div
            v-if="(typeof error == 'string' && error)"
            class="text-[#FF0000] text-12 mt-2"
        >{{ $t(error) }}</div>
    </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import EyeClose from "../Icons/EyeClose.vue";
import EyeOpen from "../Icons/EyeOpen.vue";
import PasswordTooltip from "./PasswordTooltip.vue";

const emit = defineEmits(["update:modelValue", "clearError"]);

const props = defineProps({
    label: {
        type: String,
        requried: false,
    },

    id: {
        type: String,
        required: false,
    },

    placeholder: {
        type: String,
        default: "Enter password",
    },

    toggleable: {
        type: Boolean,
        default: true,
    },

    error: {
        type: [String, Boolean],
        required: false,
    },
});
const type = ref("password");

const changeInput = (e) => {
    emit('update:modelValue', e.target.value)
    emit('clearError')
}

</script>

<script>
export default {
    inheritAttrs: false,
    components: { PasswordTooltip }
}
</script>
