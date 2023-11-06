<template>
    <div class="head mb-6">
        <h3 class="title font-bold text-base text-20 mb-4">{{ $t('Categories') }}</h3>
        <div class="wrapper flex justify-between">
            <div class="filters-wrapper flex relative">
                <FilterButton @toggleShowFilter="(value) => showFilter = value" />
                <Filterbox
                    v-if="showFilter"
                    v-click-away="() => showFilter = false"
                >
                    <MultiCheckboxFilter
                        :options="filters.category"
                        class="mb-6"
                        label="Category"
                        placeholder="Select Category"
                        column="category"
                        route-name="categories.index"
                        @updateFilterData="updateFilters"
                    />
                    <RangeFilter :maxValue="maxValue" columnKey="products_count" :minValue = "minValue" title="Total Products"  route-name="categories.index"/>
                </Filterbox>
            </div>
            <PrimaryButton
                class="text-white font-montserrat font-bold text-18 ml-auto"
                @click="Inertia.visit(route('categories.create'))"
                v-if="hasPermission('categories.edit')"
            >{{ $t('Add Category') }}</PrimaryButton>
        </div>
    </div>

    <div class="content mb-6">
        <Table>
            <template #head>
                <TableColumn
                    class="w-[40%]"
                    routeName="categories.index"
                    columnName="prefix_id"
                    :style="getColumnWidth(auth_user, 40, 30)"
                >
                    {{ $t('Category ID') }}
                </TableColumn>
                <TableColumn
                    class="w-[35%]"
                    routeName="categories.index"
                    columnName="name"
                    :style="getColumnWidth(auth_user, 35, 25)"
                >
                    {{ $t('Category Name') }}
                </TableColumn>
                <TableColumn
                    class="w-[20%]"
                    routeName="categories.index"
                    columnName="company"
                    :style="getColumnWidth(auth_user, 20, 20)"
                    v-if="auth_user.type == 'system_admin'"
                >
                    {{ $t('Company') }}
                </TableColumn>
                <TableColumn
                    class="w-[20%]"
                    routeName="categories.index"
                    columnName="products_count"
                >
                    {{ $t('Total Products') }}
                </TableColumn>

                <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow
                    v-for="category in categories.data"
                    :key="category.id"
                    :category="category"
                />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'categories.index'" />
        <Pagination :paginationData="categories" />
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
    categories: {
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
    category: [],
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('categories.filter-data', params))
    filters[column] = data
}

</script>
