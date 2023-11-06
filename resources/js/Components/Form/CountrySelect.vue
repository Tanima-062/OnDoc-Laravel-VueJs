<template>
    <Label :label="label" for="country" @click="toggleDropdown" />
    <div class="dropdown text-16" ref="selectParent" v-click-away="()=>closeDropdown()" >
        <div class="select" value="select" ref="select" >
            <div v-if="!openDropdown"  ref="selectLabel" class="select__label"  v-html="currentItem" @click="toggleDropdown"></div>
            <input class="search" :placeholder="$t('search')" type="text" autofocus ref="search" v-model="search" v-if="openDropdown" />
        </div>
        <ul class="select-dropdown active" ref="selectDropdown" id="selectDropdown" v-show="openDropdown" >
            <li class="option" :class="{selected: isSelected(country)}" :data-value="country.name" v-for="country in filterdCountry" :key="country.tld" :id="`item-${country.iso}-${country.dialCode}`"
                @click="selectItem(country)">
                <div class="iti-flag" :class="`${country.iso}`">
                </div>
                <div class="country">
                    <span class="country-name"> {{ getCountryName(country.iso)  }} </span>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import Label from "./Label.vue";
const countrylist = require("./../../countries.json");
import './../../../css/flugs.css'

export default {
    props: {
        label: {
            type: [String, Number],
            default: null,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        modelValue: String,
        placeholder: {
            type: String,
            default: 'Search'
        },
         error: String,
    },
    components: {
        Label
    },

    data() {
        return {
            countries: [],
            openDropdown: false,
            search: "",
            translateCountries: []
        };
    },
    emits:['changeCountry', 'update:modelValue'],
    computed: {
        filterdCountry(){
            return this.countries.filter(item=> {
                return item.name.toLowerCase().startsWith(this.search.toLowerCase()) || item.name_translate.toLowerCase().startsWith(this.search.toLowerCase());
            })
        },
        currentItem(){
            const country = this.countries.find(item=> {
              return  item.name.toLowerCase() == this.modelValue.toLowerCase() || item.iso == this.modelValue.toLowerCase();
            })


            if(country){
                return `
                    <div class="default-flat iti-flag ${country.iso.toLowerCase()}"></div>
                    <div class="default-item">
                        <span style="margin-left:5px;">${ this.getCountryName(country.iso) }</span>
                    </div>
                `;
            }
            return `<span style="color: #96959A;">${this.placeholder}</span>`;
        },
    },
    mounted(){
        this.generateCountries()
    },
    methods: {
        isSelected(country){
            return this.modelValue == country.iso
        },
        selectItem(country) {
            this.$emit("update:modelValue", country.iso);
            this.$emit('changeCountry', country.iso)
            this.openDropdown = false;
        },
        toggleDropdown() {
            if(!this.openDropdown){
                this.openDropdown = true;
                setTimeout(() => {
                    this.$refs.search.focus();
                    const country = this.countries.find(item=> item.iso == this.modelValue)
                    if(country){
                        const item = document.getElementById(`item-${country.iso}-${country.dialCode}`)
                        this.$refs.selectDropdown.scrollTop = item.offsetTop - 10;
                    }
                }, 100);
            }else {
                this.openDropdown = false;
            }
        },
        closeDropdown() {
            this.search = '';
            this.openDropdown = false;
        },
        generateCountries(){
            const countries = countrylist.map(country=> {
                country.name_translate = this.getCountryName(country.iso)

                return country;
            })

            this.countries = countries
        },
    },
};
</script>

<style lang="scss" scoped>

.dropdown {
    position: relative;
    animation: fadeIn;
    background: #FFFFFF;
    height: 48px;
    // border: 1px solid #C8C8C8;
    border: 1px solid #E9E9EB;
    box-sizing: border-box;
    border-radius: 5px;
    font-style: normal;
    font-weight: 400;
    // font-size: 1.6rem;
    // line-height: 2.4rem;
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    outline: none;
    color: #323232;
    display: flex;
    align-items: center;
}

.select-dropdown.active {
    display: block;
}

.select {
    background: #ffffff;
    box-sizing: border-box;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-right: none;
    border-radius: 5px 0px 0px 5px;
    display: block;
    text-align: left;
    width: 100%;
}

.select-dropdown {
    max-height: 200px;
    overflow-y: auto;
    position: absolute;
    top: 45px;
    left: 0;
    display: none;
    background: #ffffff;
    border: 1px solid #c8c8c8;
    margin: 0;
    padding: 0;
    z-index: 9999;
    width: 285px;

    &::-webkit-scrollbar {
        width: 20px;
        background-color: #eff3f6;
    }

    &::-webkit-scrollbar-thumb {
        background: #c8c8c8ed;;
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
    font-style: normal;
    font-size: 16px;
    line-height: 24px;
}

.select-dropdown .option:last-child {
    border-bottom: none;
}
.select-dropdown .option.selected {
   background-color: #c8c8c8ed;
}

.search {
    outline: none;
    border: none;
    max-width: 100%;
    margin: 0;
    padding: 0;
    font-style: normal;
    font-size: 16px;
    line-height: 24px;
    padding-left: 5px;

    &:focus,
    &:active,
    &:active,
    &:hover,
    &:focus-within,
    &:focus-visible,
    &:visited,
    &:placeholder-shown {
        font-size: 16px;
        line-height: 24px;
    }
}

.select__label {
    padding-left: 5px;
    cursor: pointer;
    font-style: normal;
    font-size: 16px;
    line-height: 24px;
    display: flex;
    align-items: center;
}

.country {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .dial-code {
        margin-left: 10px;
    }
    .country-name {
        margin-left: 15px;
    }
}
</style>
