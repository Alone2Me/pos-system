<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
defineProps({
  categories: Object,
  product: Object,
});
function getStockSeverity(product) {
  if (product.inventory && product.inventory.status) {
    switch (product.inventory.status.toUpperCase()) {
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
  return null; // Handle cases where inventory or status is missing
}
function formatCurrency(value) {
  return value.toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
  });
}
</script>
<template>
  <app-layout>
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
              :alt="slotProps.data.name"
              width="50"
              class="shadow"
            />
          </template>
        </Column>
        <Column
          field="name"
          header="Product"
          :sortable="true"
          style="width: 35%"
        ></Column>
        <Column field="price" header="Price" :sortable="true" style="width: 35%">
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
        <!-- Status Column -->
        <Column header="Status">
          <template #body="slotProps">
            <Tag
              :value="slotProps.data.inventory.status"
              :severity="getStockSeverity(slotProps.data)"
            />
          </template>
        </Column>
        <Column style="width: 15%" header="View">
          <template #body>
            <Button icon="pi pi-search" type="button" class="p-button-text"></Button>
          </template>
        </Column>
      </DataTable>
    </div>
  </app-layout>
</template>
