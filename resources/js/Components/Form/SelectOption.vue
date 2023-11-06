<template>
    <div
        class="select w-full relative cursor-pointer"
        v-click-away="() => (showOptions = false)"
    >
        <label
            v-if="label"
            class="form-label block mb-3 text-16 text-[#5D5D60] font-bold"
            :class="attrs.labelClass"
        >{{ $t(label) }}</label>
        <div
            class="select-box selected bg-white flex h-12 w-full items-center justify-between px-5 py-3"
            :id=id
            :class="[
                attrs.error
                    ? 'border-[1px] border-error'
                    : 'border-gray-corner',
            ]"
            @click="showOptions = !showOptions"
            :tabindex="tabindex"
            :style="selectBoxBorder"
        >
            <p
                class="label text-16 font-ropa"
                :class="[
                    attrs.labelClass,
                    attrs.modelValue ? 'text-base' : 'text-black-3',
                ]"
            >
                {{ selected || $t(placeholder) }}
            </p>
            <span class="toggle-icons">
                <svg
                    width="10"
                    height="5"
                    viewBox="0 0 10 5"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M5 5L0 0H10L5 5Z"
                        fill="#5D5D60"
                    />
                </svg>

            </span>
        </div>
        <ul
            class="options bg-white w-full absolute top-[100%] divide-y divide-gray-corner z-[1] max-h-[250px] overflow-y-auto shadow-form rounded-[8px] divide-y divide-black-1 rounded-t-none"
            v-show="showOptions"
        >
            <li
                v-for="option in options"
                class="option text-base text-16 px-5 py-3 cursor-pointer hover:bg-sky-2"
                :class="isSelected(option) ? 'bg-sky-2' : ''"
                :key="option[value_name]"
                @click.stop="(e) => setSelected(e, option)"
            >
                {{ $t(option[label_name]) }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { defaults } from "lodash";
import { v4 as uuid } from "uuid";
import { computed, ref, useAttrs } from "vue";

import {trans} from 'laravel-vue-i18n'
const attrs = useAttrs();
const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    name: {
        type: String,
        required: false,
    },

    label: String,

    id: {
        type: String,
        default: `select-input-${uuid()}`,
    },

    placeholder: {
        type: String,
        default: "Select Options",
    },

    options: {
        type: [Array, Object],
        required: true,
    },

    value_name: {
        type: String,
        default: "value",
    },

    label_name: {
        type: String,
        default: "label",
    },
    tabindex: {
        type: [Number, String, null],
        default: null
    }
});

const showOptions = ref(false);

// const selected = ref(attrs.modelValue)

const selected = computed(()=> {
    const value = props.options.find(item=>item[props.value_name] == attrs.modelValue);
    if(value){
        return trans(value[props.label_name])
    }

    return null;
})

const setSelected = (e, option) => {
    emit("update:modelValue", option[props.value_name]);
    e.target.classList.add("bg-gray-corner");
    showOptions.value = false;
};

const isSelected = (option) => {
    return attrs.modelValue == option[props.value_name];
};

const selectBoxBorder = computed(()=> {
    return  showOptions.value ? `border-bottom-right-radius: 0;border-bottom-left-radius: 0;` : ``
})

</script>


<style lang="scss" scoped>
    .options {
        border: 1px solid #efefff;
    }
.select-box {
    white-space: nowrap;
    overflow: hidden;
    position: relative;

    .toggle-icons {
        width: 35px;
        height: 30px;
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        background: white;
        padding-left: 5px;
    }
}
</style>

