<template>
    <div :class="$attrs.class">
        <label v-if="label" class="form-label block mb-3 text-16 text-[#5D5D60] font-bold " :class="this.$attrs.labelClass" :for="id">{{$t(label)}}</label>
        <input :id="id" ref="input" v-bind="{ ...$attrs }" class="text__input"
            :class="[{ 'border border-[#FF0000]': error }, this.$attrs.inputClass]" :type="type" :value="modelValue"
            :placeholder="$t(placeholder)" @input="changeInput" :style="$attrs.inputStyle" :required="required" />
        <div v-if="(error && typeof error == 'string')" class="text-[#FF0000] text-12 mt-2" :class="$attrs.errorClass">{{ $t(error) }}</div>
    </div>
</template>

<script>
import { v4 as uuid } from "uuid";

export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${uuid()}`;
            },
        },
        type: {
            type: String,
            default: "text",
        },

        required: {
            type: Boolean,
            default: false
        },
        show_error: {
            type: Boolean,
            default: true
        },
        error: [String, Boolean],
        label: String,
        modelValue: [String, Number],
        placeholder: String,
    },
    emits: ["update:modelValue", "clearError"],
    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
        changeInput(e) {
            this.$emit('update:modelValue', e.target.value)
            this.$emit('clearError')
        }
    },
};
</script>


<style lang="scss" scoped>

</style>
