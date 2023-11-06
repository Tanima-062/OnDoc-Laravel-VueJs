<template>
    <div class="head mb-6">
        <h3 class="title font-bold text-base text-20 mb-4">{{ $t('Supplier') }}</h3>
        <div class="wrapper flex justify-between">
            <div class="filters-wrapper flex relative">
                <FilterButton @toggleShowFilter="(value) => showFilter = value" />
                <Filterbox
                    v-if="showFilter"
                    v-click-away="() => showFilter = false"
                >
                    <MultiCheckboxFilter
                        :options="filters.supplier"
                        class="mb-6"
                        label="Supplier"
                        placeholder="Select Supplier"
                        column="supplier"
                        route-name="suppliers.index"
                        @updateFilterData="updateFilters"
                    />

                    <RangeFilter :maxValue="maxValue" columnKey="products_count" :minValue = "minValue" title="Total Products"  route-name="suppliers.index"/>
                </Filterbox>
            </div>
            <PrimaryButton
                class="text-white font-montserrat font-bold text-18 ml-auto"
                @click="Inertia.visit(route('suppliers.create'))"
                v-if="hasPermission('suppliers.edit')"
            >{{ $t('Add Supplier') }}</PrimaryButton>
        </div>
    </div>

    <div class="content mb-6">
        <Table>
            <template #head>
                <TableColumn
                    class="w-[40%]"
                    routeName="suppliers.index"
                    columnName="prefix_id"
                    :style="getColumnWidth(auth_user, 40, 30)"
                >
                    {{ $t('Supplier ID') }}
                </TableColumn>
                <TableColumn
                    class="w-[35%]"
                    routeName="suppliers.index"
                    columnName="name"
                    :style="getColumnWidth(auth_user, 35, 25)"
                >
                    {{ $t('Supplier Name') }}
                </TableColumn>
                <TableColumn
                    class="w-[20%]"
                    routeName="suppliers.index"
                    columnName="company"
                    :style="getColumnWidth(auth_user, 20, 20)"
                    v-if="auth_user.type == 'system_admin'"
                >
                    {{ $t('Company') }}
                </TableColumn>
                <TableColumn
                    class="w-[20%]"
                    routeName="suppliers.index"
                    columnName="products_count"
                >
                    {{ $t('Total Products') }}
                </TableColumn>

                <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow
                    v-for="supplier in suppliers.data"
                    :key="supplier.id"
                    :supplier="supplier"
                />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'suppliers.index'" />
        <Pagination :paginationData="suppliers" />
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
import RangeFilter from "../../Components/Filters/RangeFilter.vue"
import axios from "axios"

const props = defineProps({
    suppliers: {
        type: Object,
        required: true,
    },
    minValue:{
        type: Number,
        required: false,
    },
    maxValue:{
        type: Number,
        required: false,
    }
})
const showFilter = ref(false)
const filters = reactive({
    status: [],
    supplier: [],
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('suppliers.filter-data', params))
    filters[column] = data
}

</script>
