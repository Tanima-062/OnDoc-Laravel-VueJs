
import { usePage } from '@inertiajs/inertia-vue3'
import dayjs from "dayjs";
import countries from 'i18n-iso-countries'
// Support french & english languages.
countries.registerLocale(require("i18n-iso-countries/langs/en.json"));
countries.registerLocale(require("i18n-iso-countries/langs/fr.json"));
countries.registerLocale(require("i18n-iso-countries/langs/de.json"));
countries.registerLocale(require("i18n-iso-countries/langs/it.json"));

export default {
    computed: {
        permissions() {
            return usePage().props.value.permissions;
        },
        auth_user() {
            return usePage().props.value.auth_user;
        }
    },
    methods: {
        hasPermission(permision) {
            return this.permissions.includes(permision)
        },
        hasAnyPermissions(permisions) {
            let find = false;
            for (let i = 0; i < permisions.length; i++) {
                if (this.permissions.includes(permisions[i])) {
                    find = true;
                    break;
                }
            }

            return find;
        },
        formateDate(date, formate = 'DD.MM.YYYY') {
            return dayjs(date).format(formate).toString()
        },
        getCountryName(countryCode, locale = null) {
            let localeCode = locale ? locale : this.auth_user ? this.auth_user.language.code : 'de';

            return countries.getName(countryCode.toString().toUpperCase(), localeCode.toString().toLowerCase())
        },
        getCountryCode(countryName, locale = null) {
            // let localeCode = locale ? locale : usePage().props.value.auth_user.language.code;
            let localeCode = locale ? locale : this.auth_user ? this.auth_user.language.code : 'de';

            return countries.getAlpha2Code(countryName.toString(), localeCode.toString().toLowerCase())
        },

        getColumnWidth(user, normalWidth, systemAdminWidth) {
            const width = user.type == 'system_admin' ? systemAdminWidth : normalWidth;

            return `width: ${width}%`;
        },

    },

}

