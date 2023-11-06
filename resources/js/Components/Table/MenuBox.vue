<template>
    <div class="menu-box relative ml-auto">
        <div
            class="toggler w-[28px] h-[28px] flex justify-center items-center rounded-[8px] ml-auto hover:cursor-pointer"
            :class="{ 'bg-sky-1': active }"
            @click="toggle"
        >
            <svg
                width="16"
                height="4"
                viewBox="0 0 16 4"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M2 4C1.45 4 0.979333 3.804 0.588 3.412C0.196 3.02067 0 2.55 0 2C0 1.45 0.196 0.979 0.588 0.587C0.979333 0.195667 1.45 0 2 0C2.55 0 3.02067 0.195667 3.412 0.587C3.804 0.979 4 1.45 4 2C4 2.55 3.804 3.02067 3.412 3.412C3.02067 3.804 2.55 4 2 4ZM8 4C7.45 4 6.97933 3.804 6.588 3.412C6.196 3.02067 6 2.55 6 2C6 1.45 6.196 0.979 6.588 0.587C6.97933 0.195667 7.45 0 8 0C8.55 0 9.021 0.195667 9.413 0.587C9.80433 0.979 10 1.45 10 2C10 2.55 9.80433 3.02067 9.413 3.412C9.021 3.804 8.55 4 8 4ZM14 4C13.45 4 12.979 3.804 12.587 3.412C12.1957 3.02067 12 2.55 12 2C12 1.45 12.1957 0.979 12.587 0.587C12.979 0.195667 13.45 0 14 0C14.55 0 15.021 0.195667 15.413 0.587C15.8043 0.979 16 1.45 16 2C16 2.55 15.8043 3.02067 15.413 3.412C15.021 3.804 14.55 4 14 4Z"
                    fill="#5D5D60"
                />
            </svg>
        </div>

        <div class="options bg-sky-1 rounded-[8px] text-18 text-base z-[1] absolute right-0 top-9 w-max divide-y divide-white overflow-hidden flex flex-col [&>.active]:bg-sky-2 [&>*:hover]:bg-sky-2" v-if="active" v-click-away="() => active = false" @click="active = false">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { useAttrs } from 'vue';

const attrs = useAttrs()
const active = ref(attrs.active ?? false)


const toggle = () => active.value = !active.value
</script>
