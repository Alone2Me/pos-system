<script setup>
defineProps({
  type: {
    type: String,
    default: "submit",
  },
});
</script>

<template>
  <Button :type="type">
    <slot />
  </Button>
</template>
