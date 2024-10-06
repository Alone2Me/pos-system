<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    products: Object,
});

console.table(props.products.data);
</script>

<template>
    <app-layout>
        <li v-for="product in products.data" :key="product.id">
            {{
                `${product.id} - ${product.name} -${product.category} - ${product.inventory.quantity} - ${product.price} - ${product.inventory.status} -`
            }}
        </li>
    </app-layout>
</template>
