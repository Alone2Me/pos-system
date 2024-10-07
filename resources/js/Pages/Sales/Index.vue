<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    sales: Object,
});
console.table(props.sales.data);
</script>

<template>
    <app-layout>
        <li v-for="sale in sales.data" :key="sale.id">{{ `  ${sale.sale_date} -${sale.customer.name}  -  ${sale.total}` }}</li>
    </app-layout>
</template>
