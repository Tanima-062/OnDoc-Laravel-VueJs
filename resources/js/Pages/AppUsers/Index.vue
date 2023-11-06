<template>
    <div class="head mb-6">
        <h3 class="title font-bold text-base text-20 mb-4">{{ $t('App Users') }}</h3>
        <div class="wrapper flex justify-between">
            <div class="filters-wrapper flex relative">
                <FilterButton @toggleShowFilter="(value) => showFilter = value" />
                <Filterbox
                    v-if="showFilter"
                    v-click-away="() => showFilter = false"
                >
                    <MultiCheckboxFilter
                        :options="filters.company"
                        class="mb-6"
                        label="Company"
                        v-if="auth_user.type == 'system_admin'"
                        placeholder="Select Company"
                        column="company"
                        route-name="appusers.index"
                        @updateFilterData="updateFilters"
                    />

                    <MultiCheckboxFilter
                        :options="filters.status"
                        class="mb-6"
                        label="Status"
                        placeholder="Select Status"
                        column="status"
                        route-name="appusers.index"
                        @updateFilterData="updateFilters"
                    />
                </Filterbox>
            </div>
            <PrimaryButton
                class="text-white font-montserrat font-bold text-18"
                @click="Inertia.visit(route('appusers.create'))"
                v-if="hasPermission('mobile_app_users.create')"
            >{{ $t('Add User') }}</PrimaryButton>
        </div>
    </div>

    <div class="content mb-6">
        <Table>
            <template #head>
                <TableColumn
                    class="w-[19%]"
                    routeName="appusers.index"
                    columnName="prefix_id"
                >
                    {{ $t('User ID') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="appusers.index"
                    columnName="first_name"
                >
                    {{ $t('First Name') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="appusers.index"
                    columnName="last_name"
                >
                    {{ $t('Last Name') }}
                </TableColumn>

                <TableColumn
                    class="w-[25%]"
                    routeName="appusers.index"
                    columnName="email"
                    v-if="auth_user.type !== 'system_admin'"
                >
                    {{ $t('E-Mail') }}
                </TableColumn>

                <TableColumn
                    class="w-[25%]"
                    routeName="appusers.index"
                    columnName="company"
                    v-else
                >
                    {{ $t('Company') }}
                </TableColumn>

                <TableColumn
                    class="w-[13%]"
                    routeName="appusers.index"
                    columnName="status"
                >
                    {{ $t('Status') }}
                </TableColumn>

                <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow
                    v-for="appuser in appusers.data"
                    :key="appuser.id"
                    :user="appuser"
                />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'appusers.index'" />
        <Pagination :paginationData="appusers" />
    </div>
</template>

<script setup>
//vue reactivity
import { ref, reactive } from "@vue/reactivity"

//compoents
import FilterButton from '../../Components/Filters/FilterButton.vue'
import PrimaryButton from "../../Components/PrimaryButton.vue"
import Table from "../../Components/Table/Table.vue"
import TableColumn from "../../Components/Table/TableColumn.vue"

//libs
import { Inertia } from "@inertiajs/inertia";
import TableBodyRow from "./Components/TableBodyRow.vue"
import PerPage from "../../Components/Table/PerPage.vue"
import Pagination from "../../Components/Pagination.vue"
import Filterbox from "../../Components/Filters/Filterbox.vue"
import MultiCheckboxFilter from "../../Components/Filters/MultiCheckboxFilter.vue"
import axios from "axios"

const props = defineProps({
    appusers: {
        type: Object,
        required: true,
    }
})
const showFilter = ref(false)
const filters = reactive({
    status: [],
    company: [],
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('appusers.filter-data', params))
    filters[column] = data
}

</script>
