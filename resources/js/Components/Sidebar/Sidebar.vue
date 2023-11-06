<template>
    <!-- Sidebar  -->
    <nav
        id="sidebar"
        class="h-auto ease-in-out duration-300 shadow-[4px_0px_4px_rgba(222,_236,_250,_0.5)]"
        :class="{ 'w-[315px]': sidebarFullView, 'w-[100px]': !sidebarFullView }"
    >
        <div
            class="ml-8 relative min-h-content h-screen"
            :class="{ 'collapse-nav': !sidebarFullView }"
        >
            <div class="flex items-center mt-5">
                <div class="">
                    <ManIcon class="icon" />
                </div>
                <div class="flex flex-col mr-6 ml-2 cursor-pointer hide-on-collapse ease-in-out duration-300">
                    <span class="full__name text-18 Montserrat font-bold text-base whitespace-nowrap">{{
                            auth_user.name
                    }}</span>
                    <span class="user__type text-16 Montserrat font-normal text-base whitespace-nowrap">{{
                            $t(auth_user.user_type)
                    }}</span>
                </div>
            </div>
            <div>
                <!-- <left-arrow-icon
                    v-if="sidebarFullView"
                    class="mt-[5rem] cursor-pointer"
                    @click="collapseSidebar"
                />
                <RightArrowIcon
                class="mt-[5rem] cursor-pointer"
                @click="expandSidebar"
                v-else
                /> -->
                <left-collapse-icon
                    v-if="sidebarFullView"
                    class="mt-[5rem] cursor-pointer"
                    @click="collapseSidebar"
                />
                <right-collapse-icon
                    class="mt-[5rem] cursor-pointer"
                    @click="expandSidebar"
                    v-else
                />
            </div>
            <hr class="mt-8 ml-[-15px] calc(100%_-5px) mb-5" />
            <SidebarMenuItem
                routeName="companies.index"
                activeText="Companies"
                v-if="hasAnyPermissions(['companies.view', 'companies.edit'])"
            >
                <ProductIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("Companies") }}</span>
            </SidebarMenuItem>
            <SidebarMenuItem
                routeName="company-admins.index"
                activeText="CompanyAdmins"
                v-if="hasAnyPermissions(['company_admin.view', 'company_admin.edit'])"
            >
                <ProductIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("Company Admin") }}</span>
            </SidebarMenuItem>

            <SidebarMenuItem
                routeName="products.index"
                activeText="Products"
                v-if="hasAnyPermissions(['products.view', 'products.edit'])"
            >
                <ProductIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("Product Documents") }}</span>
            </SidebarMenuItem>
            <SidebarMenuItem
                routeName="appusers.index"
                activeText="AppUsers"
                v-if="hasAnyPermissions(['mobile_app_users.view', 'mobile_app_users.edit'])"
            >
                <AppUserIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("App Users") }}</span>
            </SidebarMenuItem>
            <SidebarMenuItem
                routeName="company-sub-admins.index"
                activeText="CompanySubAdmins"
                v-if="hasAnyPermissions(['sub_admins.view', 'sub_admins.edit'])"
            >
                <SubAdminIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("Sub Admin Users") }}</span>
            </SidebarMenuItem>
            <SidebarMenuItem
                routeName="suppliers.index"
                activeText="Supplier"
                v-if="hasAnyPermissions(['suppliers.view', 'suppliers.edit'])"
            >
                <SupplierIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("Supplier") }}</span>
            </SidebarMenuItem>
            <SidebarMenuItem
                routeName="categories.index"
                activeText="Categories"
                v-if="hasAnyPermissions(['categories.view', 'categories.edit'])"
            >
                <CategoryIcon />
                <span class="hide-on-collapse whitespace-nowrap" style="word-wrap:break-word;white-space: normal;">{{ $t("Categories") }}</span>
            </SidebarMenuItem>

            <SettingBox :sidebarFullView="sidebarFullView" />
        </div>
    </nav>
</template>

<script setup>
// import LeftArrowIcon from "../Icons/LeftArrow.vue";
// import RightArrowIcon from "../Icons/RightArrow.vue";
import LeftCollapseIcon from "../Icons/LeftCollapseIcon.vue";
import RightCollapseIcon from "../Icons/RightCollapseIcon.vue";
import ManIcon from "../Icons/Man.vue";
import ProductIcon from "../Icons/ProductIcon.vue";
import { ref } from "@vue/reactivity"

import SidebarMenuItem from "./SidebarMenuItem.vue";
import AppUserIcon from "../Icons/AppUserIcon.vue";
import SubAdminIcon from "../Icons/SubAdminIcon.vue";
import SupplierIcon from "../Icons/SupplierIcon.vue";
import CategoryIcon from "../Icons/CategoryIcon.vue";
import SettingBox from "./Setting/SettingBox.vue";

const sidebarFullView = ref(true);
const collapseSidebar = () => sidebarFullView.value = false
const expandSidebar = () => sidebarFullView.value = true

</script>

<style lang="scss">
.collapse-nav {
    .hide-on-collapse {
        display: none;
    }
}
</style>
