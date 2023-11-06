<template>
    <div
        class="relative w-max h-full flex items-center"
        ref="selectParent"
        v-click-away="() => closeDropdown()"
    >
        <div
            class="bg-transparent"
            value="select"
            ref="select"
        >
            <div
                v-if="!openDropdown"
                ref="selectLabel"
                class="flex items-center text-base text-16"
                v-html="currentItem"
                @click="toggleDropdown"
            ></div>
            <input
                class="w-[60px] outline-none text-base text-16"
                placeholder="Search"
                type="text"
                autofocus
                ref="searchInput"
                v-model="search"
                v-if="openDropdown"
            />
        </div>
        <ul
            class="select-dropdown active"
            ref="selectDropdown"
            id="selectDropdown"
            v-show="openDropdown"
        >
            <li
                class="option"
                :class="{ selected: isSelected(country) }"
                :data-value="country.name_translate"
                v-for="country in filterdCountry"
                :key="country.tld"
                :id="`item-${country.iso}-${country.dialCode}`"
                @click="selectItem(country)"
            >
                <div
                    class="iti-flag"
                    :class="`${country.iso}`"
                ></div>
                <div class="country">
                    <span class="dial-code"> +{{ country.dialCode }} </span>
                    <span class="country-name"> {{ country.name_translate }}</span>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { reactive, ref, useAttrs, computed, onMounted, nextTick, } from "vue";
import "../../css/flags.css";
import mixin from './../mixin'
const countrylist = require("../countries.json");


const attrs = useAttrs();

const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    label: {
        type: [String, Number],
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    placeholder: {
        type: String,
        default: "Search",
    },
    lang: {
        type: String,
        required: false
    }
});

let countries = ref([]);
const openDropdown = ref(false);
const search = ref("");
const searchInput = ref(null);
const selectDropdown = ref(null);

const filterdCountry = computed(() => {
    return countries.value.filter((item) => {
        return item.name.toLowerCase().startsWith(search.value.toLowerCase()) || item.name_translate
            .toLowerCase()
            .startsWith(search.value.toLowerCase());
    });
});

const currentItem = computed(() => {
    const country = countries.value.find((item) => {
        return item.iso.toLowerCase() == attrs.modelValue.toLowerCase();
    });
    if (country) {
        return `<div class="default-flat iti-flag ${attrs.modelValue.toLowerCase()}">

            </div>
            <div class="default-item">
                <span style="margin-left:10px;" class="flex items-center">+${country.dialCode}
                    <svg style="margin-left:10px;"  width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L1.53033 0.46967ZM6 6L5.46967 6.53033C5.76256 6.82322 6.23744 6.82322 6.53033 6.53033L6 6ZM11.5303 1.53033C11.8232 1.23744 11.8232 0.762563 11.5303 0.46967C11.2374 0.176777 10.7626 0.176777 10.4697 0.46967L11.5303 1.53033ZM0.46967 1.53033L5.46967 6.53033L6.53033 5.46967L1.53033 0.46967L0.46967 1.53033ZM6.53033 6.53033L11.5303 1.53033L10.4697 0.46967L5.46967 5.46967L6.53033 6.53033Z" fill="#787878"/>
                    </svg>
                </span>
            </div>`;
    }
    return `<span>+00000</span>`;
});

const isSelected = (country) => {
    return attrs.modelValue == country.iso;
};

const selectItem = (country) => {
    emit("update:modelValue", country.iso);
    openDropdown.value = false;
};

const toggleDropdown = () => {
    openDropdown.value = !openDropdown.value
    nextTick(() => {
        if (openDropdown.value) {
            searchInput.value.focus();
            const country = countries.value.find((item) => item.iso == attrs.modelValue);
            const offset = country ? document.getElementById(`item-${country.iso}-${country.dialCode}`)?.offsetTop : 0;
            selectDropdown.value.scrollTop = offset - 10;
        }
    })
};

const closeDropdown = () => {
    openDropdown.value = false;
};

onMounted(() => {
    countries.value = countrylist.map(country => {
        if(props.lang){
            country.name_translate = mixin.methods.getCountryName(country.iso, props.lang)
        }else {
            country.name_translate = mixin.methods.getCountryName(country.iso)
        }

        return country;
    })
})
</script>

<style lang="scss" scoped>
.select-dropdown.active {
    display: block;
}

.select {
    background: #ffffff;
    // border: 1px solid #c8c8c8;
    box-sizing: border-box;
    justify-content: space-between;
    align-items: center;
    // cursor: pointer;

    border-right: none;
    border-radius: 48px;
    display: block;
    text-align: left;
    // padding: 7px 20px;
}

.select-dropdown {
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    top: 33px;
    left: 0;
    display: none;
    background: #ffffff;
    border: 1px solid #c8c8c8;
    margin: 0;
    padding: 0;
    z-index: 9999;
    width: 400px;

    &::-webkit-scrollbar {
        width: 20px;
        background-color: #eff3f6;
    }

    &::-webkit-scrollbar-thumb {
        background: #c8c8c8ed;
        border-radius: 2px;
        // height: 50px;
        cursor: pointer;
        min-height: 50px;
    }
}

.select-dropdown .option {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #c8c8c8;
    cursor: pointer;
    padding: 6px 15px;

    //   font-family: "Lato";
    font-family: 'Ropa Sans', serif;

    font-style: normal;
    //   font-weight: 400;
    font-size: 16px;
    line-height: 24px;
}

.select-dropdown .option:last-child {
    border-bottom: none;
}

.select-dropdown .option.selected {
    background-color: #c8c8c8ed;
}

.country {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .dial-code {
        margin-left: 10px;
    }
}
</style>
