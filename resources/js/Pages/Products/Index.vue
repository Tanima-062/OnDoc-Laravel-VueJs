<template>
    <div class="head mb-6">
        <h3 class="title font-bold text-base text-20 mb-4">{{ $t('Product Documents') }}</h3>
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
                        route-name="products.index"
                        @updateFilterData="updateFilters"
                    />
                    <MultiCheckboxFilter
                        :options="filters.category"
                        class="mb-6"
                        label="Category"
                        placeholder="Select Category"
                        column="category"
                        route-name="products.index"
                        @updateFilterData="updateFilters"
                    />
                    <MultiCheckboxFilter
                        :options="filters.status"
                        class="mb-6"
                        label="Status"
                        placeholder="Select Status"
                        column="status"
                        route-name="products.index"
                        @updateFilterData="updateFilters"
                    />
                </Filterbox>
            </div>

            <PrimaryButton
                class="text-white font-montserrat font-bold text-18 bg-[#7059E2] ml-auto mr-[10px]"
                @click="getPDFLink"
                v-if="auth_user.type != 'system_admin'"
            >{{ $t('Export as PDF') }}</PrimaryButton>
            <PrimaryButton
                class="text-white font-montserrat font-bold text-18 bg-[#7059E2] mr-[10px]"
                @click="exportData"
                v-if="auth_user.type != 'system_admin'"
            >{{ $t('Export to Excel') }}</PrimaryButton>
            <PrimaryButton
                v-if="hasPermission('products.edit')"
                class="text-white font-montserrat font-bold text-18"
                @click="Inertia.visit(route('products.create'))"
                :disabled="is_more_than_1000_product"
            >{{ $t('Add Product Documents') }}</PrimaryButton>
        </div>
    </div>

    <div class="content mb-6">
        <Table>
            <template #head>
                <TableColumn
                    class="w-[19%]"
                    routeName="products.index"
                    columnName="prefix_id"
                    :style="getColumnWidth(auth_user, 12, 12)"
                >
                    {{ $t('Product ID') }}
                </TableColumn>

                 <TableColumn
                    class="w-[19%] pl-2"
                    routeName="products.index"
                    columnName="serial_number"
                    :style="getColumnWidth(auth_user, 18, 17)"
                >
                    {{ $t('Serial Nr.') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%] pl-2"
                    routeName="products.index"
                    columnName="name"
                    :style="getColumnWidth(auth_user, 18, 15)"
                >
                    {{ $t('Product') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%] pl-2"
                    routeName="products.index"
                    columnName="supplier"
                    :style="getColumnWidth(auth_user, 18, 13)"
                >
                    {{ $t('Supplier') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%] pl-2"
                    routeName="products.index"
                    columnName="category"
                    :style="getColumnWidth(auth_user, 18, 13)"
                >
                    {{ $t('Category') }}
                </TableColumn>
                <TableColumn
                    class="w-[25%] pl-2"
                    routeName="products.index"
                    columnName="company"
                    :style="getColumnWidth(auth_user, 15, 15)"
                    v-if="auth_user.type == 'system_admin'"

                >
                    {{ $t('Company') }}
                </TableColumn>

                <TableColumn
                    class="w-[19%]"
                    routeName="products.index"
                    columnName="status"
                    :style="getColumnWidth(auth_user, 10, 7)"
                >
                    {{ $t('Status') }}
                </TableColumn>

                <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow
                    v-for="product in products.data"
                    :key="product.id"
                    :product="product"
                />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'products.index'" />
        <Pagination :paginationData="products" />
    </div>
</template>

<script setup>
import { inject } from "vue";
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
import axios from "axios"
import FlashNotification from "../../Components/Modal/Content/FlashNotification.vue";

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    is_more_than_1000_product: {
        type: Boolean,
        requred: true,
    }
})
const showFilter = ref(false)
const filters = reactive({
    status: [],
    category: [],
    supplier: []
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('products.filter-data', params))
    filters[column] = data
}

const exportData = () => {
    console.log('export data');

    let fileName = 'product-lists.xlsx'

    axios({
        url: route('products.exports'),
        method: 'GET',
        responseType: 'blob', // important
    }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', fileName); //or any other extension
        document.body.appendChild(link);
        link.click();
    })
}

const modal = inject("modal");

const getPDFLink = () => {
    axios({
        url: route('products.getPdf'),
        method: 'GET',
    }).then((response) => {
        console.log(response)
        modal.show(FlashNotification, {
            props: {
                message: response.data,
            },
            config: {
                timeOut: 3000,
            },
        });
    })
}

</script>
