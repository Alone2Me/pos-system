<script setup>
import {
    onBeforeMount,
    ref,
} from "vue";

import AppLayout from "@/Layouts/AppLayout.vue";
import { CustomerService } from "@/service/CustomerService";
import { ProductService } from "@/service/ProductService";
import {
    FilterMatchMode,
    FilterOperator,
} from "@primevue/core/api";

defineProps({
    categories: Object,
    product: Object,
});

const customers1 = ref(null);
const customers2 = ref(null);
const customers3 = ref(null);
const filters1 = ref(null);
const loading1 = ref(null);
const products = ref(null);
const expandedRows = ref([]);
function getOrderSeverity(order) {
    switch (order.status) {
        case "DELIVERED":
            return "success";
        case "CANCELLED":
            return "danger";
        case "PENDING":
            return "warn";
        case "RETURNED":
            return "info";
        default:
            return null;
    }
}

function getStockSeverity(product) {
    switch (product.inventoryStatus) {
        case "INSTOCK":
            return "success";
        case "LOWSTOCK":
            return "warn";
        case "OUTOFSTOCK":
            return "danger";
        default:
            return null;
    }
}
onBeforeMount(() => {
    ProductService.getProductsWithOrdersSmall().then(
        (data) => (products.value = data)
    );
    CustomerService.getCustomersLarge().then((data) => {
        customers1.value = data;
        loading1.value = false;
        customers1.value.forEach(
            (customer) => (customer.date = new Date(customer.date))
        );
    });
    CustomerService.getCustomersLarge().then(
        (data) => (customers2.value = data)
    );
    CustomerService.getCustomersMedium().then(
        (data) => (customers3.value = data)
    );
    initFilters1();
});
function initFilters1() {
    filters1.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: {
            operator: FilterOperator.AND,
            constraints: [
                { value: null, matchMode: FilterMatchMode.STARTS_WITH },
            ],
        },
        "country.name": {
            operator: FilterOperator.AND,
            constraints: [
                { value: null, matchMode: FilterMatchMode.STARTS_WITH },
            ],
        },
        representative: { value: null, matchMode: FilterMatchMode.IN },
        date: {
            operator: FilterOperator.AND,
            constraints: [{ value: null, matchMode: FilterMatchMode.DATE_IS }],
        },
        balance: {
            operator: FilterOperator.AND,
            constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }],
        },
        status: {
            operator: FilterOperator.OR,
            constraints: [{ value: null, matchMode: FilterMatchMode.EQUALS }],
        },
        activity: { value: [0, 100], matchMode: FilterMatchMode.BETWEEN },
        verified: { value: null, matchMode: FilterMatchMode.EQUALS },
    };
}
function expandAll() {
    expandedRows.value = products.value.reduce(
        (acc, p) => (acc[p.id] = true) && acc,
        {}
    );
}
function collapseAll() {
    expandedRows.value = null;
}
function formatCurrency(value) {
    return value.toLocaleString("en-US", {
        style: "currency",
        currency: "USD",
    });
}
</script>
<template>
    <AppLayout>
        {{ product }}
        <div class="card">
            <div class="font-semibold text-xl mb-4">Recent Sales</div>
            <DataTable
                :value="product.data"
                :rows="5"
                :paginator="true"
                responsiveLayout="scroll"
            >
                <Column style="width: 15%" header="Image">
                    <template #body="slotProps">
                        <img
                            :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`"
                            :alt="slotProps.image"
                            width="50"
                            class="shadow"
                        />
                    </template>
                </Column>
                <Column
                    field="product"
                    header="Name"
                    :sortable="true"
                    style="width: 35%"
                ></Column>
                <Column
                    field="price"
                    header="Price"
                    :sortable="true"
                    style="width: 35%"
                >
                    <template #body="slotProps">
                        {{ formatCurrency(slotProps.data.price) }}
                    </template>
                </Column>
                <Column
                    field="category"
                    header="Category"
                    :sortable="true"
                    style="width: 35%"
                ></Column>
                <Column
                    field="inventory.quantity"
                    header="Quantity"
                    :sortable="true"
                    style="width: 35%"
                ></Column>
                <Column
                    field="inventory.status"

                    
                    header="Status"
                    :sortable="true"
                    style="width: 35%"
                ></Column>
                <Column style="width: 15%" header="View">
                    <template #body>
                        <Button
                            icon="pi pi-search"
                            type="button"
                            class="p-button-text"
                        ></Button>
                    </template>
                </Column>
            </DataTable>
        </div>
        <div class="card">
            <div class="font-semibold text-xl mb-4">Row Expansion</div>
            <DataTable
                v-model:expandedRows="expandedRows"
                :value="products"
                dataKey="id"
                tableStyle="min-width: 60rem"
            >
                <template #header>
                    <div class="flex flex-wrap justify-end gap-2">
                        <Button
                            text
                            icon="pi pi-plus"
                            label="Expand All"
                            @click="expandAll"
                        />
                        <Button
                            text
                            icon="pi pi-minus"
                            label="Collapse All"
                            @click="collapseAll"
                        />
                    </div>
                </template>
                <Column expander style="width: 5rem" />
                <Column field="name" header="Name"></Column>
                <Column header="Image">
                    <template #body="slotProps">
                        <img
                            :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`"
                            :alt="slotProps.data.image"
                            class="shadow-lg"
                            width="64"
                        />
                    </template>
                </Column>
                <Column field="price" header="Price">
                    <template #body="slotProps">
                        {{ formatCurrency(slotProps.data.price) }}
                    </template>
                </Column>
                <Column field="category" header="Category"></Column>
                <Column field="rating" header="Reviews">
                    <template #body="slotProps">
                        <Rating :modelValue="slotProps.data.rating" readonly />
                    </template>
                </Column>
                <Column header="Status">
                    <template #body="slotProps">
                        <Tag
                            :value="slotProps.data.inventoryStatus"
                            :severity="getStockSeverity(slotProps.data)"
                        />
                    </template>
                </Column>
                <template #expansion="slotProps">
                    <div class="p-4">
                        <h5>Orders for {{ slotProps.data.name }}</h5>
                        <DataTable :value="slotProps.data.orders">
                            <Column field="id" header="Id" sortable></Column>
                            <Column
                                field="customer"
                                header="Customer"
                                sortable
                            ></Column>
                            <Column
                                field="date"
                                header="Date"
                                sortable
                            ></Column>
                            <Column field="amount" header="Amount" sortable>
                                <template #body="slotProps">
                                    {{ formatCurrency(slotProps.data.amount) }}
                                </template>
                            </Column>
                            <Column field="status" header="Status" sortable>
                                <template #body="slotProps">
                                    <Tag
                                        :value="
                                            slotProps.data.status.toLowerCase()
                                        "
                                        :severity="
                                            getOrderSeverity(slotProps.data)
                                        "
                                    />
                                </template>
                            </Column>
                            <Column headerStyle="width:4rem">
                                <template #body>
                                    <Button icon="pi pi-search" />
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </template>
            </DataTable>
        </div>
    </AppLayout>
</template>
