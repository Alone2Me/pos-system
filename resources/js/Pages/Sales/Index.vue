<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    sales: Object,
});
console.table(props.sales.data);
</script>

<template>
    <app-layout>
        <li v-for="sale in sales.data" :key="sale.id">{{ ` ${sale.id} - ${sale.sale_date} - ${sale.customer.id} , ${sale.customer.name} - ${sale.amount} - ${sale.discount} - ${sale.tax} - ${sale.total} ` }}</li>
    </app-layout>
</template>
