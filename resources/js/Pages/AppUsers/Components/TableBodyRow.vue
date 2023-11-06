<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column w-[19%] text-base text-18">
            {{ user.prefix_id }}
        </div>
        <div class="column w-[19%] text-base text-18">
            {{ user.first_name }}
        </div>
        <div class="column w-[19%] text-base text-18">
            {{ user.last_name }}
        </div>
        <div class="column w-[25%] text-base text-18" v-if="auth_user.type !== 'system_admin'">
            {{ user.email }}
        </div>
        <div class="column w-[25%] text-base text-18" v-else>
            {{ user.company.name }}
        </div>
        <div class="column w-[13%] text-base text-18 capitalize flex items-center gap-4">
            <StatusIcon :status="user.status" /> {{ $t(user.status) }}
        </div>
        <div class="column w-[5%]">
            <MenuBox v-if="hasPermission('mobile_app_users.edit')">
                <button
                    class="option p-4 text-left"
                    v-if="hasPermission('mobile_app_users.edit')"
                    @click="updateStatus(user.status == 'inactive' ? 'active' : 'inactive')"
                >
                    <template v-if="user.status == 'inactive'">
                        {{ $t('Activate') }}
                    </template>
                    <template v-else>
                        {{ $t('Deactivate') }}
                    </template>
                </button>
                <button
                    class="option p-4 text-left"
                    v-if="hasPermission('mobile_app_users.edit')"
                    @click="deleteUser"
                >
                    {{ $t('Delete') }}
                </button>
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
    user: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const updateStatus = (status) => {
    const statusText = status == 'inactive' ? 'Deactivate' : 'Activate';
    const title = trans(':status Mobile App User?', { status: statusText })
    const description = trans('Are you sure you want to :status the user “:user”?', { status: statusText, user: `${props.user.first_name} ${props.user.last_name}` });
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
                Inertia.put(route('appusers.update-status', { appuser: props.user.id }), { status }, {
                    preserveScroll: true,
                })
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
const deleteUser = () => {
    modal.show(Confirmation, {
        config: {
            staticBackdrop: true,
        },
        props: {
            title: trans("Delete Mobile App User?"),
            description: trans("Are you sure to delete this account and remove access to all company documents?"),
        },
        events: {
            yesClick: () => {
                Inertia.delete(route('appusers.destroy', { appuser: props.user.id }))
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
