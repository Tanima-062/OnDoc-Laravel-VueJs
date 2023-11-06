<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column w-[15%] text-base text-18" >
            {{ formateDate(company_admin.created_at) }}
        </div>
        <div class="column w-[15%] text-base text-18">
            {{ company_admin.prefix_id }}
        </div>
        <div class="column w-[15%] text-base text-18">
            {{ company_admin.company.name }}
        </div>
        <div class="column w-[15%] text-base text-18">
            {{ company_admin.name }}
        </div>
        <div class="column w-[12%] text-base text-18" >
            {{ company_admin.documents_count }}
        </div>
        <div class="column w-[17%] text-base text-18">
            {{ $t(company_admin.user_type) }}
        </div>
        <div class="column w-[8%] text-base text-18 capitalize flex items-center gap-4">
            <StatusIcon :status="company_admin.status" /> {{ $t(company_admin.status) }}
        </div>
        <div class="column w-[5%]">
            <MenuBox  v-if="hasPermission('company_admin.edit')">
                <button
                    class="option p-4 text-left"
                    @click="updateStatus(company_admin.status == 'inactive' ? 'active' : 'inactive')"
                >
                    <template v-if="company_admin.status == 'inactive'">
                        {{ $t('Activate') }}
                    </template>
                    <template v-else>
                        {{ $t('Deactivate') }}
                    </template>
                </button>
                <Link
                    class="option p-4"
                    :href="route('company-admins.edit', { company_admin: company_admin.id })"
                >
                {{ $t('Edit') }}
                </Link>
            </MenuBox>
        </div>
    </div>
</template>

<script setup>
//componetns
import StatusIcon from '../../../Components/Icons/StatusIcon.vue';
import MenuBox from '../../../Components/Table/MenuBox.vue';
import { Link } from "@inertiajs/inertia-vue3"
import Confirmation from '../../../Components/Modal/Content/Confirmation.vue';

//libs
import { inject } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { trans } from "laravel-vue-i18n"


const props = defineProps({
    company_admin: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const updateStatus = (status) => {
    const statusText = status == 'inactive' ? trans('Deactivate') : trans('Activate');
    const title = trans(':status Admin User?', { status: statusText})

    const description = trans('Are you sure you want to :status the user “:user”?', { status: statusText, user: `${props.company_admin.name}` });
    modal.show(Confirmation, {
        config: {
            staticBackdrop: true,
        },
        props: {
            title: title,
            description: description,
        },
        events: {
            yesClick: () => {
                Inertia.put(route('company-admins.toggle-status', { company_admin: props.company_admin.id }), { status }, {
                    preserveScroll: true,
                })
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
