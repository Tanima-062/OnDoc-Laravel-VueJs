<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column w-[19%] text-base text-18">
            {{ formateDate(company.created_at) }}
        </div>
        <div class="column w-[19%] text-base text-18">
            {{ company.prefix_id }}
        </div>
        <div class="column w-[19%] text-base text-18">
            {{ company.name }}
        </div>
        <div class="column w-[19%] text-base text-18">
            {{ company.mobile_app_users_count }}
        </div>
        <div class="column w-[19%] text-base text-18">
            {{ company.documents_count }}
        </div>
        <div class="column w-[19%] text-base text-18 capitalize flex items-center gap-4">
            <StatusIcon :status="company.status" /> {{ $t(company.status) }}
        </div>
        <div class="column w-[5%]">
            <MenuBox>
                <button
                    v-if="hasPermission('companies.edit')"
                    class="option p-4 text-left"
                    @click="updateStatus(company.status == 'inactive' ? 'active' : 'inactive')"
                >
                    <template v-if="company.status == 'inactive'">
                        {{ $t('Activate') }}
                    </template>
                    <template v-else>
                        {{ $t('Deactivate') }}
                    </template>
                </button>
                <Link
                    v-if="hasPermission('companies.edit')"
                    class="option p-4"
                    :href="route('companies.edit', { company: company.id })"
                >
                {{ $t('Edit') }}
                </Link>
                <!-- <Link
                    v-if="hasPermission('companies.view')"
                    class="option p-4"
                    :href="route('companies.show', { company: company.id })"
                >
                {{ $t('View Details') }}
                </Link> -->
                <!-- <button
                    v-if="hasPermission('companies.edit')"
                    class="option p-4 text-left"
                    @click="deleteUser"
                >
                    {{ $t('Delete') }}
                </button> -->
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
    company: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const updateStatus = (status) => {
    const statusText = status == 'inactive' ? 'Deactivate' : 'Activate';
    const title = trans(':status Company?', { status: statusText })
    const description = trans('Are you sure you want to :status the company “:company”?', { status: statusText, company: `${props.company.name}` });
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
                Inertia.put(route('companies.update-status', { company: props.company.id }), { status }, {
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
            title: trans("Delete Product?"),
            description: trans("Are you sure to delete company?"),
        },
        events: {
            yesClick: () => {
                Inertia.delete(route('companies.destroy', { company: props.company.id }))
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
