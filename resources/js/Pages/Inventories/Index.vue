<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    inventories: Object,
});

console.table(props.inventories.data);
</script>

<template>
    <app-layout>
        <li v-for="inventory in inventories.data" :key="inventory.id">
            {{
                ` ${inventory.location} - ${inventory.product} - ${inventory.quantity} - ${inventory.status}`
            }}
        </li>
    </app-layout>
</template>
