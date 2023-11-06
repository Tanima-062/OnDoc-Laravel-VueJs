<template>
    <div class="table-body-row flex items-center py-4 px-1">
        <div class="column w-[40%] text-base text-18" :style="getColumnWidth(auth_user, 40, 30)">
            {{ category.prefix_id }}
        </div>
        <div class="column w-[35%] text-base text-18" :style="getColumnWidth(auth_user, 35, 25)">
            {{ category.name }}
        </div>
        <div class="column w-[20%] text-base text-18" :style="getColumnWidth(auth_user, 20, 20)" v-if="auth_user.type == 'system_admin'">
            {{ category.company.name }}
        </div>
        <div class="column w-[20%] text-base text-18">
            {{ category.products_count }}
        </div>
        <div class="column w-[5%]">
            <MenuBox v-if="hasPermission('categories.edit')">
                <Link
                    class="option p-4"
                    :href="route('categories.edit', { category: category.id })"
                >
                {{ $t('Edit') }}
                </Link>
                <!-- <Link
                    class="option p-4"
                    :href="route('categories.show', { category: category.id })"
                >
                    {{ $t('View Details') }}
                </Link> -->
                <button
                    class="option p-4 text-left"
                    @click="deleteCategory"
                    v-if="category.products_count == 0"
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
    category: {
        type: Object,
        required: true,
    }
})
const modal = inject('modal')

const deleteCategory = () => {
    modal.show(Confirmation, {
        config: {
            staticBackdrop: true,
        },
        props: {
            title: "Delete Category?",
            description: trans("Are you sure you want to delete the category “:name”?", {name: props.category.name}),
        },
        events: {
            yesClick: () => {
                Inertia.delete(route('categories.destroy', { category: props.category.id }))
                modal.hide()
            },
            noClick: modal.hide
        }
    })
}
</script>
