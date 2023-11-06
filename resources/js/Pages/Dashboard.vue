<template>
  <div>Welcome Dashboard</div>
  <div class="challo__card challo__card--transparent">
    <!-- <template> -->
        <Table>
            <template #head>
                <div class="th font-montserrat" style="width: 20%;">
                    {{ $t("Product ID") }}
                    <Sort routeName="" keyName="designation" />
                </div>
                <div class="th font-montserrat" style="width: 20%">
                    {{ $t("Product") }}
                    <Sort routeName="" keyName="marketing_fee" />
                </div>
                <div class="th font-montserrat" style="width: 20%">
                    {{ $t("Supplier") }}
                    <Sort routeName="" keyName="direct_consumers_senior_partner_share" width="22"/>
                </div>
                <div class="th font-montserrat" style="width: 20%">
                    {{ $t("Category") }}
                    <Sort routeName="" keyName="direct_consumers_share_jackpot" />
                </div>
                <div class="th" style="width: 15%">
                    {{ $t("Status") }}
                    <Sort routeName="" keyName="status" />
                </div>
                <div class="th" style="width: 5%"></div>
            </template>
            <template #body>
                <!-- <TableBodyRow v-for="fee in marketing_fees.data" :key="fee.id" :fee="fee" /> -->
            </template>
        </Table>
    <!-- </template> -->
  </div>
</template>

<script setup>
import Table from '../Components/Table/Table.vue';
import Sort from '../Components/Sort.vue';

</script>

<style lang="scss" scoped>
    .tr .content .th {
        color:#5D5D60;
        display: flex;
        align-items: flex-start;
        svg {
            margin-top: 5px;
        }
    }
</style>
