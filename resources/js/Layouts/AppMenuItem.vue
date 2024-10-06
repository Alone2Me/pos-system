<script setup>
import {
    onBeforeMount,
    ref,
    watch,
} from "vue";

import NavLink from "@/Components/NavLink.vue";
import { useLayout } from "@/Layouts/composables/layout";

const { layoutState, setActiveMenuItem, onMenuToggle } = useLayout();
const props = defineProps({
  item: {
    type: Object,
    default: () => ({}),
  },
  index: {
    type: Number,
    default: 0,
  },
  root: {
    type: Boolean,
    default: true,
  },
  parentItemKey: {
    type: String,
    default: null,
  },
});
const isActiveMenu = ref(false);
const itemKey = ref(null);
onBeforeMount(() => {
  itemKey.value = props.parentItemKey
    ? props.parentItemKey + "-" + props.index
    : String(props.index);
  const activeItem = layoutState.activeMenuItem;
  isActiveMenu.value =
    activeItem === itemKey.value || activeItem
      ? activeItem.startsWith(itemKey.value + "-")
      : false;
});
watch(
  () => layoutState.activeMenuItem,
  (newVal) => {
    isActiveMenu.value =
      newVal === itemKey.value || newVal.startsWith(itemKey.value + "-");
  }
);
function itemClick(event, item) {
  if (item.disabled) {
    event.preventDefault();
    return;
  }
  if (
    (item.route || item.url) &&
    (layoutState.staticMenuMobileActive || layoutState.overlayMenuActive)
  ) {
    onMenuToggle();
  }
  if (item.command) {
    item.command({ originalEvent: event, item: item });
  }
  const foundItemKey = item.items
    ? isActiveMenu.value
      ? props.parentItemKey
      : itemKey
    : itemKey.value;
  setActiveMenuItem(foundItemKey);
}
function checkActiveRoute(item) {
  return route().current() === item.route;
}
</script>
<template>
  <li :class="{ 'layout-root-menuitem': root, 'active-menuitem': isActiveMenu }">
    <div v-if="root && item.visible !== false" class="layout-menuitem-root-text">
      {{ item.label }}
    </div>
    <a
      v-if="(!item.route || item.items) && item.visible !== false"
      :href="item.url"
      @click="itemClick($event, item, index)"
      :class="item.class"
      :target="item.target"
      tabindex="0"
    >
      <i :class="item.icon" class="layout-menuitem-icon"></i>
      <span class="layout-menuitem-text">{{ item.label }}</span>
      <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items"></i>
    </a>
    <nav-link
      v-if="item.route && !item.items && item.visible !== false"
      @click="itemClick($event, item, index)"
      :class="[item.class, { 'active-route': checkActiveRoute(item) }]"
      tabindex="0"
      :href="route(item.route)"
    >
      <i :class="item.icon" class="layout-menuitem-icon"></i>
      <span class="layout-menuitem-text">{{ item.label }}</span>
      <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items"></i>
    </nav-link>
    <Transition v-if="item.items && item.visible !== false" name="layout-submenu">
      <ul v-show="root ? true : isActiveMenu" class="layout-submenu">
        <app-menu-item
          v-for="(child, i) in item.items"
          :key="child"
          :index="i"
          :item="child"
          :parentItemKey="itemKey"
          :root="false"
        ></app-menu-item>
      </ul>
    </Transition>
  </li>
</template>
<style lang="scss" scoped></style>