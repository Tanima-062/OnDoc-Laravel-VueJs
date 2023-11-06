<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column text-base text-18" :style="getColumnWidth(auth_user, 12, 12)">
            {{ product.prefix_id }}
        </div>
        <div class="column text-base text-18 pl-2" :style="getColumnWidth(auth_user, 18, 17)">
            {{ product.serial_number }}
        </div>
        <div class="column text-base text-18 pl-2" :style="getColumnWidth(auth_user, 18, 15)">
            {{ product.name }}
        </div>
        <div class="column text-base text-18 pl-2" :style="getColumnWidth(auth_user, 18, 13)">
            {{ product?.supplier?.name || '' }}
        </div>
        <div class="column text-base text-18 pl-2" :style="getColumnWidth(auth_user, 18, 13)">
            {{ product?.category?.name }}
        </div>
        <div class="column w-[25%] text-base text-18 pl-2" :style="getColumnWidth(auth_user, 15, 15)" v-if="auth_user.type == 'system_admin'">
            {{ $t(product.company.name) }}
        </div>
        <div class="column text-base text-18 capitalize flex items-center gap-4" :style="getColumnWidth(auth_user, 10, 7)">
            <StatusIcon :status="product.status" /> {{ $t(product.status) }}
        </div>
        <div class="column w-[5%]">
            <MenuBox>
                <button
                    v-if="hasPermission('products.edit')"
                    class="option p-4 text-left"
                    @click="updateStatus(product.status == 'inactive' ? 'active' : 'inactive')"
                >
                    <template v-if="product.status == 'inactive'">
                        {{ $t('Activate') }}
                    </template>
                    <template v-else>
                        {{ $t('Deactivate') }}
                    </template>
                </button>
                <Link
                    v-if="hasPermission('products.edit')"
                    class="option p-4"
                    :href="route('products.edit', { product: product.id })"
                >
                {{ $t('Edit') }}
                </Link>
                <button
                    v-if="hasPermission('products.edit')"
                    class="option p-4 text-left"
                    @click="deleteItem"
                >{{ $t('Delete') }}
                </button>
                <Link
                    v-if="hasPermission('products.view')"
                    class="option p-4"
                    :href="route('products.show', { product: product.id })"
                >
                {{ $t('View Details') }}
                </Link>
                <!-- <button
                    v-if="hasPermission('products.edit')"
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
    product: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const updateStatus = (status) => {
    const statusText = status == 'inactive' ? 'Deactivate' : 'Activate';
    const title = trans(':status Product?', { status: statusText })
    const description = trans('Are you sure you want to :status the product “:product”?', { status: statusText, product: `${props.product.name}` });
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
                Inertia.put(route('products.update-status', { product: props.product.id }), { status }, {
                    preserveScroll: true,
                })
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
const deleteItem = () => {
    modal.show(Confirmation, {
        config: {
            staticBackdrop: true,
        },
        props: {
            title: trans("Delete Product?"),
            description: trans("Are you sure you want to delete :product_name?", {product_name: props.product.name}),
        },
        events: {
            yesClick: () => {
                Inertia.delete(route('products.destroy', { product: props.product.id }))
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
