<template>

    <div style="width: 100%">
        <label
            v-if="label"
            class="form-label mb-3 block text-base text-16"
            :class="$attrs.labelClass"
            :for="id"
        >{{ $t(label) }}</label>
        <div
            class="flex h-[48px] w-full bg-white rounded-[8px] gap-4 items-center px-4 border border-black-1"
            :class="[(is_valid === false || error)? '!border !border-[#FF0000]' : '', $attrs.class]"
        >
            <CountryCode
                v-model="code"
                :class="$attrs.countryCodeClass"
                :lang="lang"
            />
            <div class="borders text-base text-16">
                |
            </div>
            <input
                id="phone_number"
                class="w-full bg-transparent outline-none text-base text-16"
                :class="$attrs.phoneNumberClass"
                type="text"
                v-model="number"
                placeholder="11 111 11 11"
                :disabled="!code"
            />
        </div>
    </div>
</template>


<script>
import { v4 as uuid } from "uuid";
import CountryCode from './CountryCode.vue'
import parsePhoneNumber from 'libphonenumber-js'

export default {
    inheritAttrs: false,
    components: {
        CountryCode
    },
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${uuid()}`;
            },
        },
        error: [String, Boolean],
        label: String,
        lang: {
            type: String,
            required: false
        }
    },

    computed: {
        is_valid() {
            if (!this.$attrs.country_code || !this.$attrs.phone_number)
                return undefined;
            const phoneNumber = parsePhoneNumber(this.$attrs.phone_number, this.$attrs.country_code.toUpperCase())
            if (phoneNumber && phoneNumber.isValid()) {
                return true;
            }
            return false;
        },

        code: {
            get: function () { return this.$attrs.country_code },
            set: function (value) {
                this.$emit('update:country_code', value)
                this.$emit('updated', value);
            }
        },
        number: {
            get: function () { return this.$attrs.phone_number },
            set: function (value) {
                this.$emit('update:phone_number', value.replace(/[^0-9]/g, ''))
                this.$emit('updated', value);
            }
        }
    },
};
</script>
