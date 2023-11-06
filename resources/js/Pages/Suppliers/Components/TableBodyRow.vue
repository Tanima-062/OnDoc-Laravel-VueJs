<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column w-[40%] text-base text-18" :style="getColumnWidth(auth_user, 40, 30)">
            {{ supplier.prefix_id }}
        </div>
        <div class="column w-[35%] text-base text-18" :style="getColumnWidth(auth_user, 35, 25)">
            {{ supplier.name }}
        </div>
        <div class="column w-[20%] text-base text-18" :style="getColumnWidth(auth_user, 20, 20)" v-if="auth_user.type == 'system_admin'">
            {{ supplier.company.name }}
        </div>
        <div class="column w-[20%] text-base text-18">
            {{ supplier.products_count }}
        </div>
        <div class="column w-[5%]">
            <MenuBox v-if="hasPermission('suppliers.edit')">
                <Link
                    class="option p-4"
                    :href="route('suppliers.edit', { supplier: supplier.id })"
                >
                {{ $t('Edit') }}
                </Link>
                <!-- <Link
                    class="option p-4"
                    :href="route('suppliers.show', { supplier: supplier.id })"
                >
                    {{ $t('View Details') }}
                </Link> -->
                <button
                    class="option p-4 text-left"
                    @click="deleteItem"
                    v-if="supplier.products_count == 0"
                >
                    {{ $t('Delete') }}
                </button>
            </MenuBox>
        </div>
    </div>
</template>

<script setup>
//componetns
import MenuBox from '../../../Components/Table/MenuBox.vue';
import { Link } from "@inertiajs/inertia-vue3"
import Confirmation from '../../../Components/Modal/Content/Confirmation.vue';
import {trans} from 'laravel-vue-i18n'

//libs
import { inject } from 'vue';
import { Inertia } from '@inertiajs/inertia';
const props = defineProps({
    supplier: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const deleteItem = () => {
    modal.show(Confirmation, {
        config: {
            staticBackdrop: true,
        },
        props: {
            title: "Delete Supplier?",
            description: trans("Are you sure to delete supplier “:name”?", {name: props.supplier.name}),
        },
        events: {
            yesClick: () => {
                Inertia.delete(route('suppliers.destroy', { supplier: props.supplier.id }))
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
