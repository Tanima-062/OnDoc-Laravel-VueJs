<template>
    <div class="head mb-6">
        <h3 class="title font-bold text-base text-20 mb-4">{{ $t('Company Admin') }}</h3>
        <div class="wrapper flex justify-between">
            <div class="filters-wrapper flex relative">
                <FilterButton @toggleShowFilter="(value) => showFilter = value" />
                <Filterbox
                    v-if="showFilter"
                    v-click-away="() => showFilter = false"
                >
                    <DateRangeFilter columnKey="created_at" routeName="company-admins.index"/>
                    <MultiCheckboxFilter
                        :options="filters.company"
                        class="mb-6"
                        label="Company"
                        placeholder="Select Company"
                        column="company"
                        route-name="company-admins.index"
                        @updateFilterData="updateFilters"
                    />
                    <MultiCheckboxFilter
                        :options="filters.user_type"
                        class="mb-6"
                        label="User Type"
                        placeholder="Select Type"
                        column="user_type"
                        route-name="company-admins.index"
                        @updateFilterData="updateFilters"
                    />
                    <MultiCheckboxFilter
                        :options="filters.status"
                        class="mb-6"
                        label="Status"
                        placeholder="Select Status"
                        column="status"
                        route-name="company-admins.index"
                        @updateFilterData="updateFilters"
                    />
                </Filterbox>
            </div>
            <PrimaryButton
                class="text-white font-montserrat font-bold text-18 ml-auto"
                @click="Inertia.visit(route('company-admins.create'))"
                v-if="hasPermission('company_admin.edit')"
            >{{ $t('Add Admin User') }}</PrimaryButton>
        </div>
    </div>

    <div class="content mb-6">
        <Table>
            <template #head>
                <TableColumn
                    class="w-[15%]"
                    routeName="company-admins.index"
                    columnName="created_at"
                >
                    {{ $t('Created Date') }}
                </TableColumn>
                <TableColumn
                    class="w-[15%]"
                    routeName="company-admins.index"
                    columnName="prefix_id"
                >
                    {{ $t('Admin ID') }}
                </TableColumn>

                <TableColumn
                    class="w-[15%]"
                    routeName="company-admins.index"
                    columnName="company"
                >
                {{ $t('Company') }}
            </TableColumn>
                <TableColumn
                    class="w-[15%]"
                    routeName="company-admins.index"
                    columnName="first_name"
                >
                    {{ $t('Full Name') }}
                </TableColumn>
                <TableColumn
                    class="w-[12%]"
                    routeName="company-admins.index"
                    columnName="documents_count"
                >
                    {{ $t('Total PDFs') }}
                </TableColumn>
                <TableColumn
                    class="w-[17%]"
                    routeName="company-admins.index"
                    columnName="type"
                >
                    {{ $t('Admin Type') }}
                </TableColumn>

                <TableColumn
                    class="w-[8%]"
                    routeName="company-admins.index"
                    columnName="status"
                >
                    {{ $t('Status') }}
                </TableColumn>

                <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow
                    v-for="company_admin in company_admins.data"
                    :key="company_admin.id"
                    :company_admin="company_admin"
                />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'company-admins.index'" />
        <Pagination :paginationData="company_admins" />
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
import DateRangeFilter from "../../Components/Filters/DateRangeFilter.vue"
import axios from "axios"

const props = defineProps({
    company_admins: {
        type: Object,
        required: true,
    }
})
const showFilter = ref(false)
const filters = reactive({
    status: [],
    company: [],
    user_type: []
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('company-admins.filter-data', params))
    filters[column] = data
}

</script>
