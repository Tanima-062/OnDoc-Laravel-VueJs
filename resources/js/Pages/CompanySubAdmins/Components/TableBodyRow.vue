<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column w-[20%] text-base text-18" :style="getColumnWidth(auth_user, 20, 15)">
            {{ company_sub_admin.prefix_id }}
        </div>
        <div class="column w-[20%] text-base text-18" :style="getColumnWidth(auth_user, 20, 20)">
            {{ company_sub_admin.first_name }}
        </div>
        <div class="column w-[20%] text-base text-18" :style="getColumnWidth(auth_user, 20, 20)">
            {{ company_sub_admin.last_name }}
        </div>
        <div class="column w-[25%] text-base text-18" :style="getColumnWidth(auth_user, 15, 15)" v-if="auth_user.type == 'system_admin'">
            {{ $t(company_sub_admin.company.name) }}
        </div>
        <div class="column w-[25%] text-base text-18"  :style="getColumnWidth(auth_user, 25, 15)">
            {{ company_sub_admin.permission == 'view' ? $t('User Management') :   $t('Full Permission') }}
        </div>
        <div class="column w-[10%] text-base text-18 capitalize flex items-center gap-4" :style="getColumnWidth(auth_user, 10, 10)">
            <StatusIcon :status="company_sub_admin.status" /> {{ company_sub_admin.status }}
        </div>
        <div class="column w-[5%]">
            <MenuBox  v-if="hasPermission('sub_admins.edit')">
                <button
                    class="option p-4 text-left"
                    @click="updateStatus(company_sub_admin.status == 'inactive' ? 'active' : 'inactive')"
                >
                    <template v-if="company_sub_admin.status == 'inactive'">
                        {{ $t('Activate') }}
                    </template>
                    <template v-else>
                        {{ $t('Deactivate') }}
                    </template>
                </button>
                <Link
                    class="option p-4"
                    :href="route('company-sub-admins.edit', { company_sub_admin: company_sub_admin.id })"
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
    company_sub_admin: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const updateStatus = (status) => {
    const statusText = status == 'inactive' ? 'Deactivate' : 'Activate';
    const title = trans(':status Sub Admin User?', { status: statusText})

    const description = trans('Are you sure you want to :status the user “:user”?', { status: statusText, user: `${props.company_sub_admin.name}` });
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
                Inertia.put(route('company-sub-admins.toggle-status', { company_sub_admin: props.company_sub_admin.id }), { status }, {
                    preserveScroll: true,
                })
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
