<script setup>
import {
    onMounted,
    ref,
} from "vue";

import AppLayout from "@/Layouts/AppLayout.vue";
import { NodeService } from "@/service/NodeService";

const treeValue = ref(null);
const selectedTreeValue = ref(null);
const treeTableValue = ref(null);
const selectedTreeTableValue = ref(null);
onMounted(() => {
    NodeService.getTreeNodes().then((data) => (treeValue.value = data));
    NodeService.getTreeTableNodes().then(
        (data) => (treeTableValue.value = data)
    );
});
</script>
<template>
    <AppLayout>
        <div class="card">
            <div class="font-semibold text-xl">Tree</div>
            <Tree
                :value="treeValue"
                selectionMode="checkbox"
                v-model:selectionKeys="selectedTreeValue"
            ></Tree>
        </div>
        <div class="card">
            <div class="font-semibold text-xl mb-4">TreeTable</div>
            <TreeTable
                :value="treeTableValue"
                selectionMode="checkbox"
                v-model:selectionKeys="selectedTreeTableValue"
            >
                <Column field="name" header="Name" :expander="true"></Column>
                <Column field="size" header="Size"></Column>
                <Column field="type" header="Type"></Column>
            </TreeTable>
        </div>
    </AppLayout>
</template>
