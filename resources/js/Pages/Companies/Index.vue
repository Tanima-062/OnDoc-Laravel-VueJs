<template>
    <div class="head mb-6">
        <h3 class="title font-bold text-base text-20 mb-4">Companies</h3>
        <div class="wrapper flex justify-between">
            <div class="filters-wrapper flex relative">
                <FilterButton @toggleShowFilter="(value) => showFilter = value" />
                <Filterbox
                    v-if="showFilter"
                    v-click-away="() => showFilter = false"
                >
                    <DateRangeFilter columnKey="created_at" routeName="companies.index"/>
                    <RangeFilter :maxValue="mobile_app_users_max_value" columnKey="mobileAppUsers_count" keyPrefix="mobile_app_user" :minValue = "mobile_app_users_min_value" title="Total Mobile App Users" routeName="companies.index"/>
                    <RangeFilter :maxValue="documents_max_value" columnKey="documents_count" keyPrefix="document" :minValue = "documents_min_value" title="Total PDFs" routeName="companies.index"/>
                    <MultiCheckboxFilter
                        :options="filters.status"
                        class="mb-6"
                        label="Status"
                        placeholder="Select Status"
                        column="status"
                        route-name="companies.index"
                        @updateFilterData="updateFilters"
                    />
                </Filterbox>
            </div>
            <PrimaryButton
                v-if="hasPermission('companies.edit')"
                class="text-white font-montserrat font-bold text-18"
                @click="Inertia.visit(route('companies.create'))"
            >{{ $t('Add Company') }}</PrimaryButton>
        </div>
    </div>

    <div class="content mb-6">
        <Table>
            <template #head>
                <TableColumn
                    class="w-[19%]"
                    routeName="companies.index"
                    columnName="prefix_id"
                >
                    {{ $t('Created Date') }}
                </TableColumn>
                <TableColumn
                    class="w-[19%]"
                    routeName="companies.index"
                    columnName="prefix_id"
                >
                    {{ $t('Company ID') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="companies.index"
                    columnName="name"
                >
                    {{ $t('Company') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="companies.index"
                    columnName="mobile_app_users_count"
                >
                    {{ $t('Mobile App Users') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="companies.index"
                    columnName="documents_count"
                >
                    {{ $t('Total PDFs') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="companies.index"
                    columnName="status"
                >
                    {{ $t('Status') }}
                </TableColumn>

                <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow
                    v-for="company in companies.data"
                    :key="company.id"
                    :company="company"
                />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'companies.index'" />
        <Pagination :paginationData="companies" />
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
import TableBodyRow from "./components/TableBodyRow.vue"
import PerPage from "../../Components/Table/PerPage.vue"
import Pagination from "../../Components/Pagination.vue"
import Filterbox from "../../Components/Filters/Filterbox.vue"
import MultiCheckboxFilter from "../../Components/Filters/MultiCheckboxFilter.vue"
import DateRangeFilter from "../../Components/Filters/DateRangeFilter.vue"
import RangeFilter from "../../Components/Filters/RangeFilter.vue"
import axios from "axios"


const props = defineProps({
    companies: {
        type: Object,
        required: true,
    },
    documents_min_value:{
        type: [Number, String]
    },
    documents_max_value:{
        type: [Number, String]
    },
    mobile_app_users_min_value:{
        type: [Number, String]
    },
    mobile_app_users_max_value:{
        type: [Number, String]
    }
})
const showFilter = ref(false)
const filters = reactive({
    status: [],
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('companies.filter-data', params))
    filters[column] = data
}

</script>
