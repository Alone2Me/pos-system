<script setup>
import { ref } from "vue";

import { router } from "@inertiajs/vue3";

import AppMenuItem from "./AppMenuItem.vue";

const logout = () => {
    router.post(route("logout"));
};
const model = ref([
    {
        label: "Home",
        items: [
            {
                label: "Dashboard",
                icon: "pi pi-fw pi-home",
                route: "dashboard",
            },
        ], // Use Laravel route name
    },
    {
        label: "UI Components",
        items: [
            {
                label: "Uikit",
                icon: "pi pi-fw pi-bullseye",
                items: [
                    {
                        label: "FormLayout",
                        icon: "pi pi-fw pi-id-card",
                        route: "uikit.formlayout",
                    },
                    {
                        label: "Input",
                        icon: "pi pi-fw pi-check-square",
                        route: "uikit.input",
                    },
                    {
                        label: "Button",
                        icon: "pi pi-fw pi-mobile",
                        route: "uikit.button",
                        class: "rotated-icon",
                    },
                    {
                        label: "Table",
                        icon: "pi pi-fw pi-table",
                        route: "uikit.table",
                    },
                    {
                        label: "List",
                        icon: "pi pi-fw pi-list",
                        route: "uikit.list",
                    },
                    {
                        label: "Tree",
                        icon: "pi pi-fw pi-share-alt",
                        route: "uikit.tree",
                    },
                    {
                        label: "Panel",
                        icon: "pi pi-fw pi-tablet",
                        route: "uikit.panel",
                    },
                    {
                        label: "Overlay",
                        icon: "pi pi-fw pi-clone",
                        route: "uikit.overlay",
                    },
                    {
                        label: "Media",
                        icon: "pi pi-fw pi-image",
                        route: "uikit.media",
                    },
                    {
                        label: "Menu",
                        icon: "pi pi-fw pi-bars",
                        route: "uikit.menu",
                    },
                    {
                        label: "Message",
                        icon: "pi pi-fw pi-comment",
                        route: "uikit.message",
                    },
                    {
                        label: "File",
                        icon: "pi pi-fw pi-file",
                        route: "uikit.file",
                    },
                    {
                        label: "Chart",
                        icon: "pi pi-fw pi-chart-bar",
                        route: "uikit.chart",
                    },
                    {
                        label: "Timeline",
                        icon: "pi pi-fw pi-calendar",
                        route: "uikit.timeline",
                    },
                    {
                        label: "Misc",
                        icon: "pi pi-fw pi-circle",
                        route: "uikit.misc",
                    },
                ],
            },
        ],
    },
    {
        label: "Inventory and Products",
        icon: "pi pi-fw pi-objects-column",
        items: [
            {
                label: "Categories",
                icon: "pi pi-fw pi-sitemap",
                items: [
                    {
                        label: "Index",
                        icon: "pi pi-fw pi-database",
                        route: "categories.index",
                    },
                    {
                        label: "Create",
                        icon: "pi pi-fw pi-plus-circle",
                        route: "categories.create",
                    },
                ],
            },
            {
                label: "Product",
                icon: "pi pi-fw pi-shop",
                items: [
                    {
                        label: "Index",
                        icon: "pi pi-fw pi-database",
                        route: "product.index",
                    },
                    {
                        label: "Create",
                        icon: "pi pi-fw pi-plus-circle",
                        route: "product.create",
                    },
                ],
            },
            {
                label: "Inventory",
                icon: "pi pi-fw pi-box",
                items: [
                    {
                        label: "Index",
                        icon: "pi pi-fw pi-database",
                        // route: "inventory.index",
                    },
                    {
                        label: "Create",
                        icon: "pi pi-fw pi-plus-circle",
                        // route: "inventory.create",
                    },
                ],
            },
        ],
    },
    {
        label: "Customer Management",
        icon: "pi pi-fw pi-address-book",
        items: [
            {
                label: "Customers",
                icon: "pi pi-fw pi-users",
                route: "customers.index",
            },
            {
                label: "Customer Addresses",
                icon: "pi pi-fw pi-map",
                // route: "categories.index",
            },
            {
                label: "Loyalty Points",
                icon: "pi pi-fw pi-plus-circle",
                route: "categories.create",
            },
        ],
    },
    {
        label: "Sales and Transactions",
        items: [
            {
                label: "Sale",
                icon: "pi pi-fw pi-cart-plus",
                route: "sales.index"
            },
        ],
    },
    {
        label: "Pages",
        items: [
            {
                label: "Supplier and Procurement",
                icon: "pi pi-fw pi-user-edit",
            },
            {
                label: "Store and Locations",
                icon: "pi pi-fw pi-shop",
            },

            {
                label: "Auth",
                icon: "pi pi-fw pi-user",
                items: [
                    {
                        label: "Logout",
                        icon: "pi pi-fw pi-sign-out",
                        command: logout,
                    },
                    {
                        label: "Error",
                        icon: "pi pi-fw pi-times-circle",
                        to: "/auth/error",
                    },
                    {
                        label: "Access Denied",
                        icon: "pi pi-fw pi-lock",
                        to: "/auth/access",
                    },
                ],
            },
            {
                label: "Crud",
                icon: "pi pi-fw pi-pencil",
                to: "/pages/crud",
            },
            {
                label: "Not Found",
                icon: "pi pi-fw pi-exclamation-circle",
                to: "/pages/notfound",
            },
            {
                label: "Empty",
                icon: "pi pi-fw pi-circle-off",
                route: "uikit.empty",
            },
        ],
    },
]);
</script>
<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item
                v-if="!item.separator"
                :item="item"
                :index="i"
            ></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>
<style lang="scss" scoped></style>
