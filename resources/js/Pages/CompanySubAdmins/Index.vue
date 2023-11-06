<template>
    <div class="head mb-6">

        <h3 class="title font-bold text-base text-20 mb-4">{{ $t('Sub Admin Users') }}</h3>

        <div class="wrapper flex justify-between">

            <div class="filters-wrapper flex relative">
                <FilterButton @toggleShowFilter="(value) => showFilter = value" />
                <Filterbox
                    v-if="showFilter"
                    v-click-away="() => showFilter = false"
                >
                    <MultiCheckboxFilter
                        :options="filters.status"
                        class="mb-6"
                        label="Status"
                        placeholder="Select Status"
                        column="status"
                        route-name="company-sub-admins.index"
                        @updateFilterData="updateFilters"
                    />
                    <MultiCheckboxFilter
                        :options="filters.permission"
                        class="mb-6"
                        label="Permission"
                        placeholder="Select Permission"
                        column="permission"
                        route-name="company-sub-admins.index"
                        @updateFilterData="updateFilters"
                    />
                </Filterbox>
            </div>
            <PrimaryButton
                class="text-white font-montserrat font-bold text-18 ml-auto"
                @click="Inertia.visit(route('company-sub-admins.create'))"
                v-if="hasPermission('sub_admins.edit')"
            >{{ $t('Add Sub Admin User') }}</PrimaryButton>
        </div>

    </div>



    <div class="content mb-6">

        <Table>

            <template #head>

                    <TableColumn

                        class="w-[20%]"

                        routeName="company-sub-admins.index"

                        columnName="prefix_id"

                        :style="getColumnWidth(auth_user, 20, 15)"

                    >

                        {{ $t('Admin ID') }}

                    </TableColumn>



                    <TableColumn

                        class="w-[20%]"

                        routeName="company-sub-admins.index"

                        columnName="first_name"

                        :style="getColumnWidth(auth_user, 20, 20)"

                    >

                        {{ $t('First Name') }}

                    </TableColumn>



                    <TableColumn

                        class="w-[20%]"

                        routeName="company-sub-admins.index"

                        columnName="last_name"

                        :style="getColumnWidth(auth_user, 20, 20)"

                    >

                        {{ $t('Last Name') }}

                    </TableColumn>



                    <TableColumn

                        class="w-[25%]"

                        routeName="company-sub-admins.index"

                        columnName="company"

                        :style="getColumnWidth(auth_user, 15, 15)"

                        v-if="auth_user.type == 'system_admin'"

                    >

                        {{ $t('Company') }}

                    </TableColumn>

                    <TableColumn

                        class="w-[25%]"

                        routeName="company-sub-admins.index"

                        columnName="permission"

                        :style="getColumnWidth(auth_user, 25, 15)"

                    >

                        {{ $t('Permission') }}

                    </TableColumn>



                    <TableColumn

                        class="w-[10%]"

                        routeName="company-sub-admins.index"

                        columnName="status"

                        :style="getColumnWidth(auth_user, 10, 10)"

                    >

                        {{ $t('Status') }}

                    </TableColumn>

                    <div class="w-[5%] spacer"></div>
            </template>
            <template #body>
                <TableBodyRow v-for="company_sub_admin in company_sub_admins.data" :key="company_sub_admin.id" :company_sub_admin="company_sub_admin" />
            </template>
        </Table>
    </div>

    <div class="footer flex gap-[163px]">
        <PerPage :route-name="'company-sub-admins.index'" />
        <Pagination :paginationData="company_sub_admins" />
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
    company_sub_admins: {
        type: Object,
        required: true,
    }
})
const showFilter = ref(false)
const filters = reactive({
    status: [],
    permission: [],
})

const updateFilters = async (column) => {
    const params = Object.fromEntries(new URLSearchParams(location.search))
    params.column = column
    const { data } = await axios.get(route('company-sub-admins.filter-data', params))
    filters[column] = data
}
</script>
