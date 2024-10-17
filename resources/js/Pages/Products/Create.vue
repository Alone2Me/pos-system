<script setup>
import { ref } from "vue";

import { useToast } from "primevue/usetoast";

import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
  categories: Object,
});
const toast = useToast();
const form = useForm({
  product_name: "",
  category_id: "",
  description: "",
  price: "",
  image: "",
  sku: "",
});
const createProduct = () => {
  form.post(route("products.store"), {
    errorBag: "createProduct",
    preserveScroll: true,
    onSuccess: () => {
      toast.add(
        {
          severity: "success",
          summary: "Product Created",
          detail: `Product "${form.product_name}" was successfully created.`,
          life: 6000,
        },
        form.reset()
      );
    },
  });
};

</script>
<template>
  <app-layout>
    <FormSection @submitted="createProduct">
      <template #title> Product Details </template>
      <template #description>
        Fill in the details below to create a new product.
      </template>
      <template #form>
        <!-- Display Authenticated User Information -->
        <div class="col-span-6">
          <InputLabel value="Team Owner" />
          <div class="flex items-center mt-2">
            <img
              class="object-cover w-12 h-12 rounded-full"
              :src="$page.props.auth.user.profile_photo_url"
              :alt="$page.props.auth.user.name"
            />
            <div class="ms-4 leading-tight">
              <div class="text-gray-900">{{ $page.props.auth.user.name }}</div>
              <div class="text-sm text-gray-700">
                {{ $page.props.auth.user.email }}
              </div>
            </div>
          </div>
        </div>
        <!-- Product Name Input -->
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="name" value="Product Name" />
          <TextInput
            id="name"
            v-model="form.product_name"
            type="text"
            class="block w-full mt-1"
          />
          <InputError :message="form.errors.product_name" class="mt-2" />
        </div>
        <!-- Category Select -->
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="category_id" value="Category" />
          <Select
            id="category_id"
            v-model="form.category_id"
            :options="categories.data"
            optionValue="category_id"
            optionLabel="name"
            placeholder="Select"
            class="block w-full mt-1"
          />
          <InputError :message="form.errors.category_id" class="mt-2" />
        </div>
        <!-- Description Textarea -->
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="description" value="Description" />
          <Textarea
            id="description"
            v-model="form.description"
            class="block w-full mt-1"
          />
          <InputError :message="form.errors.description" class="mt-2" />
        </div>

        <!-- Price Input -->
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="price" value="Price" />
          <TextInput
            id="price"
            v-model="form.price"
            type="number"
            class="block w-full mt-1"
          />
          <InputError :message="form.errors.price" class="mt-2" />
        </div>
        <!-- SKU Input -->
        <div class="col-span-6 sm:col-span-4">
          <InputLabel for="sku" value="SKU" />
          <TextInput id="sku" v-model="form.sku" type="text" class="block w-full mt-1" />
          <InputError :message="form.errors.sku" class="mt-2" />
        </div>
      </template>
      <!-- Form Submission -->
      <template #actions>
        <ActionMessage :on="form.recentlySuccessful" class="me-3">
          Product created.
        </ActionMessage>
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Create
        </PrimaryButton>
      </template>
    </FormSection>
  </app-layout>
</template>
