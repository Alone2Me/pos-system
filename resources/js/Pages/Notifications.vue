<template>
    <div>
        <h2>Notifications</h2>
        {{ notifications }}
        <ul>
            <li v-for="notification in notifications" :key="notification.id">
                <div>
                    <strong>{{ notification.data.message }}</strong>
                    <br />
                    <small>Product: {{ notification.data.product_name }}</small>
                    <br />
                    <small>Current Quantity: {{ notification.data.current_quantity }}</small>
                    <br />
                    <small>Priority: {{ notification.data.priority }}</small>
                    <br />
                    <small>{{ formatDate(notification.created_at) }}</small>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from "vue";

// Define props
const props = defineProps({
    notifications: {
        type: Array,
        required: true,
    },
});

// Function to format the date
const formatDate = (date) => {
    return new Date(date).toLocaleString(); // Format the date as needed
};
</script>

<style scoped>
/* Add your styles here */
</style>
