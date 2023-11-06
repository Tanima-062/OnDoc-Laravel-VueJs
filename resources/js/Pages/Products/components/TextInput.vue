<template>
    <div :class="$attrs.class">
        <label v-if="label" class="form-label block mb-[8px] text-base" :class="this.$attrs.labelClass" :for="id">{{ $t(label) }}</label>
        <input :id="id" ref="input" v-bind="{ ...$attrs }" class="text__input"
            :class="[{ 'border-[#FF0000]': error }, classLists]" :type="type" :value="value"
            :placeholder="placeholder" @input="changeInput" :style="$attrs.inputStyle" :required="required" />
        <div v-if="(show_error && error && typeof error == 'string')" class="text-[#FF0000] text-12 mt-2">{{ $t(error) }}</div>
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
        show_error: {
            type: Boolean,
            default: false,
        },
        required: {
            type: Boolean,
            default: false
        },
        error: String,
        label: String,
        value: [String, Number],
        placeholder: String,
        classLists: {
            type: String,
            default: "",
        },
        hasError: {
            type: Boolean,
            default: false,
        }
    },
    emits: ["update", "clearError"],
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
            this.$emit('update', e.target.value)
            this.$emit('clearError')
        }
    },
};
</script>


<style lang="scss" scoped>

</style>
