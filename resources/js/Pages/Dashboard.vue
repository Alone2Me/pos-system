<script setup>
// import { defined } from "chart.js/dist/helpers/helpers.core";
import {
    onMounted,
    ref,
    watch,
} from "vue";

import AppLayout from "@/Layouts/AppLayout.vue";
import { useLayout } from "@/Layouts/composables/layout";
import { ProductService } from "@/service/ProductService";

const { getPrimary, getSurface, isDarkTheme } = useLayout();
const products = ref(null);
const chartData = ref(null);
const chartOptions = ref(null);
const items = ref([
  { label: "Add New", icon: "pi pi-fw pi-plus" },
  { label: "Remove", icon: "pi pi-fw pi-trash" },
]);
onMounted(() => {
  ProductService.getProductsSmall().then((data) => (products.value = data));
  chartData.value = setChartData();
  chartOptions.value = setChartOptions();
});
function setChartData() {
  const documentStyle = getComputedStyle(document.documentElement);
  return {
    labels: ["Q1", "Q2", "Q3", "Q4"],
    datasets: [
      {
        type: "bar",
        label: "Subscriptions",
        backgroundColor: documentStyle.getPropertyValue("--p-primary-400"),
        data: [4000, 10000, 15000, 4000],
        barThickness: 32,
      },
      {
        type: "bar",
        label: "Advertising",
        backgroundColor: documentStyle.getPropertyValue("--p-primary-300"),
        data: [2100, 8400, 2400, 7500],
        barThickness: 32,
      },
      {
        type: "bar",
        label: "Affiliate",
        backgroundColor: documentStyle.getPropertyValue("--p-primary-200"),
        data: [4100, 5200, 3400, 7400],
        borderRadius: {
          topLeft: 8,
          topRight: 8,
        },
        borderSkipped: true,
        barThickness: 32,
      },
    ],
  };
}
function setChartOptions() {
  const documentStyle = getComputedStyle(document.documentElement);
  const borderColor = documentStyle.getPropertyValue("--surface-border");
  const textMutedColor = documentStyle.getPropertyValue("--text-color-secondary");
  return {
    maintainAspectRatio: false,
    aspectRatio: 0.8,
    scales: {
      x: {
        stacked: true,
        ticks: {
          color: textMutedColor,
        },
        grid: {
          color: "transparent",
          borderColor: "transparent",
        },
      },
      y: {
        stacked: true,
        ticks: {
          color: textMutedColor,
        },
        grid: {
          color: borderColor,
          borderColor: "transparent",
          drawTicks: false,
        },
      },
    },
  };
}
const formatCurrency = (value) => {
  return value.toLocaleString("en-US", { style: "currency", currency: "USD" });
};
watch([getPrimary, getSurface, isDarkTheme], () => {
  chartData.value = setChartData();
  chartOptions.value = setChartOptions();
});
defineProps([
  "product",
  "customers",
  "sale_revenue",
  "purchase_orders",
  "notifications",
  "best_selling",
  "comments"
]);

const colors = ["#f97316", "#06b6d4", "#ec4899", "#22c55e", "#a855f7", "#14b8a6"];
</script>
<template>
  <AppLayout>
    <div class="grid grid-cols-12 gap-8">
      <div class="col-span-12 lg:col-span-6 xl:col-span-3">
        <div class="card mb-0">
          <div class="flex justify-between mb-4">
            <div>
              <span class="block text-muted-color font-medium mb-4">Orders</span>
              <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                {{ purchase_orders.orders }}
              </div>
            </div>
            <div
              class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border"
              style="width: 2.5rem; height: 2.5rem"
            >
              <i class="pi pi-shopping-cart text-blue-500 !text-xl"></i>
            </div>
          </div>
          <span class="text-primary font-medium">{{ purchase_orders.pending }} new </span>
          <span class="text-muted-color">since last visit</span>
        </div>
      </div>
      <div class="col-span-12 lg:col-span-6 xl:col-span-3">
        <div class="card mb-0">
          <div class="flex justify-between mb-4">
            <div>
              <span class="block text-muted-color font-medium mb-4">Revenue</span>
              <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                $ {{ sale_revenue.revenue }}
              </div>
            </div>
            <div
              class="flex items-center justify-center bg-orange-100 dark:bg-orange-400/10 rounded-border"
              style="width: 2.5rem; height: 2.5rem"
            >
              <i class="pi pi-dollar text-orange-500 !text-xl"></i>
            </div>
          </div>
          <span class="text-primary font-medium"
            >% {{ sale_revenue.revenue_percentage_change }}
          </span>
          <span class="text-muted-color"> since last week</span>
        </div>
      </div>
      <div class="col-span-12 lg:col-span-6 xl:col-span-3">
        <div class="card mb-0">
          <div class="flex justify-between mb-4">
            <div>
              <span class="block text-muted-color font-medium mb-4">Customers</span>
              <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                {{ customers.total_customer }}
              </div>
            </div>
            <div
              class="flex items-center justify-center bg-cyan-100 dark:bg-cyan-400/10 rounded-border"
              style="width: 2.5rem; height: 2.5rem"
            >
              <i class="pi pi-users text-cyan-500 !text-xl"></i>
            </div>
          </div>
          <span class="text-primary font-medium">{{ customers.new_customer }} </span>
          <span class="text-muted-color"> newly registered</span>
        </div>
      </div>
      <div class="col-span-12 lg:col-span-6 xl:col-span-3">
        <div class="card mb-0">
          <div class="flex justify-between mb-4">
            <div>
              <span class="block text-muted-color font-medium mb-4">Comments</span>
              <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
                {{ comments.unread }} Unread
              </div>
            </div>
            <div
              class="flex items-center justify-center bg-purple-100 dark:bg-purple-400/10 rounded-border"
              style="width: 2.5rem; height: 2.5rem"
            >
              <i class="pi pi-comment text-purple-500 !text-xl"></i>
            </div>
          </div>
          <span class="text-primary font-medium">{{ comments.responded }} </span>
          <span class="text-muted-color"> responded</span>
        </div>
      </div>
      <div class="col-span-12 xl:col-span-6">
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
              field="name"
              header="Name"
              :sortable="true"
              style="width: 35%"
            ></Column>
            <Column field="price" header="Price" :sortable="true" style="width: 35%">
              <template #body="slotProps">
                {{ formatCurrency(slotProps.data.price) }}
              </template>
            </Column>
            <Column style="width: 15%" header="View">
              <template #body>
                <Button icon="pi pi-search" type="button" class="p-button-text"></Button>
              </template>
            </Column>
          </DataTable>
        </div>
        <div class="card">
          <div class="flex justify-between items-center mb-6">
            <div class="font-semibold text-xl">Best Selling Products</div>
            <div>
              <Button
                icon="pi pi-ellipsis-v"
                class="p-button-text p-button-plain p-button-rounded"
                @click="$refs.menu2.toggle($event)"
              ></Button>
              <Menu ref="menu2" :popup="true" :model="items" class="!min-w-40"></Menu>
            </div>
          </div>
          <ul class="list-none p-0 m-0">
            <li
              v-for="(product, index) in best_selling.data"
              :key="index"
              class="flex flex-col md:flex-row md:items-center md:justify-between mb-6"
            >
              <div>
                <span
                  class="text-surface-900 dark:text-surface-0 font-medium mr-2 mb-1 md:mb-0"
                  >{{ product.product_name }}</span
                >
                <div class="mt-1 text-muted-color">{{ product.category_name }}</div>
              </div>
              <div class="mt-2 md:mt-0 flex items-center">
                <div
                  class="bg-surface-300 dark:bg-surface-500 rounded-border overflow-hidden w-40 lg:w-24"
                  style="height: 8px"
                >
                  <div
                    class="h-full"
                    :style="{
                      width: product.sales_percentage + '%',
                      backgroundColor: colors[index],
                    }"
                  ></div>
                </div>
                <span class="ml-4 font-medium" :style="{ color: colors[index] }">
                  %{{ product.sales_percentage }}
                </span>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-span-12 xl:col-span-6">
        <div class="card">
          <div class="font-semibold text-xl mb-4">Revenue Stream</div>
          <Chart type="bar" :data="chartData" :options="chartOptions" class="h-80" />
        </div>
        <div class="card">
          <div class="flex items-center justify-between mb-6">
            <div class="font-semibold text-xl">Notifications</div>
            <div>
              <Button
                icon="pi pi-ellipsis-v"
                class="p-button-text p-button-plain p-button-rounded"
                @click="$refs.menu1.toggle($event)"
              ></Button>
              <Menu ref="menu1" :popup="true" :model="items" class="!min-w-40"></Menu>
            </div>
          </div>
          <span
            v-if="notifications.today.data.length !== 0"
            class="block text-muted-color font-medium mb-4"
            >TODAY</span
          >
          <ul class="p-0 mx-0 mt-0 mb-6 list-none">
            <li
              v-for="notification in notifications.today.data"
              :key="notification.id"
              class="flex items-center py-2 border-b border-surface"
            >
              <div
                :class="[
                  'w-12 h-12 flex items-center justify-center rounded-full mr-4 shrink-0',
                  {
                    'bg-blue-100 dark:bg-blue-400/10': notification.type === 'purchase',
                    'bg-green-100 dark:bg-green-400/10': notification.type === 'revenue',
                    'bg-pink-100 dark:bg-pink-400/10': notification.type === 'question',
                    'bg-purple-100 dark:bg-purple-400/10':
                      notification.type === 'wishlist',
                    'bg-orange-100 dark:bg-orange-400/10':
                      notification.type === 'withdrawal',
                  },
                ]"
              >
                <i
                  :class="[
                    {
                      'pi pi-dollar text-blue-500': notification.type === 'purchase',
                      'pi pi-arrow-up text-green-500': notification.type === 'revenue',
                      'pi pi-question text-pink-500': notification.type === 'question',
                      'pi pi-heart text-purple-500': notification.type === 'wishlist',
                      'pi pi-download text-orange-500':
                        notification.type === 'withdrawal',
                    },
                    '!text-xl', // Always apply this class
                  ]"
                ></i>
              </div>
              <span class="text-surface-900 dark:text-surface-0 leading-normal"
                >{{ notification.name }}
                <span class="text-surface-700 dark:text-surface-100"
                  >{{ notification.message }}
                  <span class="text-primary font-bold">$79.00</span>
                </span>
              </span>
            </li>
          </ul>

          <span
            v-if="notifications.yesterday.data.length !== 0"
            class="block text-muted-color font-medium mb-4"
            >YESTERDAY</span
          >
          <ul class="p-0 mx-0 mt-0 mb-6 list-none">
            <li
              v-for="notification in notifications.yesterday.data"
              :key="notification.id"
              class="flex items-center py-2 border-b border-surface"
            >
              <div
                :class="[
                  'w-12 h-12 flex items-center justify-center rounded-full mr-4 shrink-0',
                  {
                    'bg-blue-100 dark:bg-blue-400/10': notification.type === 'purchase',
                    'bg-green-100 dark:bg-green-400/10': notification.type === 'revenue',
                    'bg-pink-100 dark:bg-pink-400/10': notification.type === 'question',
                    'bg-purple-100 dark:bg-purple-400/10':
                      notification.type === 'wishlist',
                    'bg-orange-100 dark:bg-orange-400/10':
                      notification.type === 'withdrawal',
                  },
                ]"
              >
                <i
                  :class="[
                    {
                      'pi pi-dollar text-blue-500': notification.type === 'purchase',
                      'pi pi-arrow-up text-green-500': notification.type === 'revenue',
                      'pi pi-question text-pink-500': notification.type === 'question',
                      'pi pi-heart text-purple-500': notification.type === 'wishlist',
                      'pi pi-download text-orange-500':
                        notification.type === 'withdrawal',
                    },
                    '!text-xl', // Always apply this class
                  ]"
                ></i>
              </div>
              <span class="text-surface-900 dark:text-surface-0 leading-normal"
                >{{ notification.name }}
                <span class="text-surface-700 dark:text-surface-100"
                  >{{ notification.message }}
                  <span class="text-primary font-bold">$79.00</span>
                </span>
              </span>
            </li>
          </ul>
          <span
            v-if="notifications.last_week.data.length !== 0"
            class="block text-muted-color font-medium mb-4"
            >LAST WEEK</span
          >
          <ul class="p-0 mx-0 mt-0 mb-6 list-none">
            <li
              v-for="notification in notifications.last_week.data"
              :key="notification.id"
              class="flex items-center py-2 border-b border-surface"
            >
              <div
                :class="[
                  'w-12 h-12 flex items-center justify-center rounded-full mr-4 shrink-0',
                  {
                    'bg-blue-100 dark:bg-blue-400/10': notification.type === 'purchase',
                    'bg-green-100 dark:bg-green-400/10': notification.type === 'revenue',
                    'bg-pink-100 dark:bg-pink-400/10': notification.type === 'question',
                    'bg-purple-100 dark:bg-purple-400/10':
                      notification.type === 'wishlist',
                    'bg-orange-100 dark:bg-orange-400/10':
                      notification.type === 'withdrawal',
                  },
                ]"
              >
                <i
                  :class="[
                    {
                      'pi pi-dollar text-blue-500': notification.type === 'purchase',
                      'pi pi-arrow-up text-green-500': notification.type === 'revenue',
                      'pi pi-question text-pink-500': notification.type === 'question',
                      'pi pi-heart text-purple-500': notification.type === 'wishlist',
                      'pi pi-download text-orange-500':
                        notification.type === 'withdrawal',
                    },
                    '!text-xl', // Always apply this class
                  ]"
                ></i>
              </div>
              <span class="text-surface-900 dark:text-surface-0 leading-normal"
                >{{ notification.name }}
                <span class="text-surface-700 dark:text-surface-100"
                  >{{ notification.message }}
                  <span class="text-primary font-bold">$79.00</span>
                </span>
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
