<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
  inventories: Object,
});

function getStockSeverity(inventories) {
  const statusMap = {
    INSTOCK: "success",
    LOWSTOCK: "warn",
    OUTOFSTOCK: "danger",
  };

  return inventories.status ? statusMap[inventories.status] || null : null;
}

</script>
<template>
  <app-layout>
    <div class="card">
      {{ console.table(inventories.data) }}
      <div class="font-semibold text-xl mb-4">inventories</div>
      <DataTable
        :value="inventories.data"
        :rows="5"
        :paginator="true"
        responsiveLayout="scroll"
      >
      <Column
          field="location"
          header="Locations"
          :sortable="true"
          style="width: 35%"
        ></Column>
        <Column
          field="category"
          header="Category"
          :sortable="true"
          style="width: 35%"
        ></Column>
        <Column
          field="product"
          header="Product"
          :sortable="true"
          style="width: 35%"
        ></Column>
        <Column header="Status">
          <template #body="slotProps">
            <Tag
              :value="slotProps.data.status"
              :severity="getStockSeverity(slotProps.data)"
            />
          </template>
        </Column>
        <Column
          field="quantity"
          header="Quantity"
          :sortable="true"
          style="width: 35%"
        ></Column>

        <!-- Status Column -->
        <Column style="width: 15%" header="View">
          <template #body>
            <Button icon="pi pi-search" type="button" class="p-button-text"></Button>
          </template>
        </Column>
      </DataTable>
    </div>
  </app-layout>
</template>
