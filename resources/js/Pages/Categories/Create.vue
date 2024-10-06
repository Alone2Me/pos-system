<script setup>
import { useToast } from "primevue/usetoast";

import InputError from "@/Components/InputError.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

InputError;

const form = useForm({
    category_name: "",
    description: "",
});

const toast = useToast();
const store = () => {
    form.post(route("categories.store"), {
        errorBag: "createCategories",
        preserveScroll: true,
        onSuccess: () => {
            toast.add(
                {
                    severity: "success",
                    summary: "Product Created",
                    detail: `Product "${form.category_name}" was successfully created.`,
                    life: 6000,
                },
                form.reset()
            );
        },
    });
};
</script>

<template>
    <AppLayout>
        <div class="md:w-1/2">
            <form @submit.prevent="store">
                <!-- Added form and submit handler -->
                <div class="card flex flex-col gap-4">
                    <div class="font-semibold text-xl">Category Name</div>
                    <InputText
                        v-model="form.category_name"
                        type="text"
                        placeholder="Default"
                    />
                    <InputError :message="form.errors.category_name" />
                    <div class="font-semibold text-xl">Description</div>
                    <Textarea
                        v-model="form.description"
                        placeholder="Category description"
                        :autoResize="true"
                        rows="3"
                        cols="30"
                    />
                    <div class="flex justify-end gap-2">
                        <Button 
                            label="Create"
                            type="submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        ></Button>
                        <!-- Button type set to submit -->
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
