<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    customers: Object,
});

console.table(props.customers);
</script>
<template>

    <app-layout>
        <!-- <ul> -->
            <li v-for="customer in customers.data" :key="customer.id">{{ `${customer.name} - ${customer.email} - ${customer.phone}` }}</li>
        <!-- </ul> -->
    </app-layout>
</template>
