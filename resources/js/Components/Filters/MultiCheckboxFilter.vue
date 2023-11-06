<template>
    <div class="select-fitler text-black-3">
        <h2 class="label text-base font-bold text-18 mb-2">{{ $t(label) }}</h2>
        <div class="border-black-1 border-2 rounded-[8px] divide-y-2 divide-black-1">
            <div
                class="toggler p-2 flex justify-between items-center cursor-pointer"
                @click="toggle"
            >
                <span>{{ $attrs.placeholder ?? $t('Select Option') }}</span>
                <FilterDownArrowIcon />
            </div>
            <div
                class="options divide-y-2 divide-black-1 max-h-[300px] overflow-y-auto"
                v-click-away="hide"
                v-if="active && options.length"
            >
                <label
                    v-for="option in options"
                    :key="option[valueKey]"
                    class="cursor-pointer px-[15px] py-2 flex gap-2"
                    :class="attrs.optionClass"
                >
                    <input
                        class="mr-1"
                        type="checkbox"
                        :value="option[valueKey]"
                        v-model="form"
                    />
                    {{ $t(option[labelKey]) }}
                </label>
            </div>
        </div>
    </div>

</template>

<script setup>
import { onMounted, useAttrs, watch } from "vue";
import { ref } from "@vue/reactivity"
import { debounce as _debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import FilterDownArrowIcon from "../Icons/FilterDownArrowIcon.vue"


const props = defineProps({
    label: {
        type: String,
        required: true,
    },

    options: {
        type: [Array, Object],
        require: true,
    },
    valueKey: {
        type: String,
        default: 'value'
    },
    labelKey: {
        type: String,
        default: 'label'
    },
    routeName: {
        type: String,
        required: true,
    },
    column: {
        type: String,
        required: true,
    }
})

const emit = defineEmits(['updateFilterData'])
const attrs = useAttrs()

const active = ref(attrs.active ?? false)
const form = ref([])


const hide = () => active.value = false
const toggle = () => active.value = !active.value

watch(form, _debounce(function (cur, prev) {
    Inertia.visit(
        route(props.routeName, {
            ...buildQueryParams(),
        }),
        {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                if (cur.length < prev.length) {
                    emit('updateFilterData', props.column)
                }
            }
        }
    );
}, 500)
);

watch(active, () => emit('updateFilterData', props.column))

const buildQueryParams = () => {
    let searchParams = Object.fromEntries(
        new URLSearchParams(location.search)
    );

    if (form.value.length) {
        searchParams[props.column] = form.value.join(",");
    } else {
        delete searchParams[props.column];
    }

    if (searchParams.hasOwnProperty("page")) {
        delete searchParams["page"];
    }

    return searchParams;
};

onMounted(() => {
    let searchParams = Object.fromEntries(new URLSearchParams(location.search));
    if (searchParams.hasOwnProperty(props.column)) {
        form.value = searchParams[props.column].toString().split(",");
    }
})
</script>
