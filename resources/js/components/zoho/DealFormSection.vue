<script setup lang="ts">

import type { ZohoFormData, SelectOption } from '@/types/zoho';
import BaseInput from "@/ui/BaseInput.vue";
import BaseSelect from "@/ui/BaseSelect.vue";
import {onMounted, ref} from "vue";
import {ElMessage} from "element-plus";
import {getStages} from "@/composables/getSelectOptions";

defineProps<{
    modelValue: ZohoFormData;
}>();

const stageOptions = ref<SelectOption[]>([]);

onMounted(async () => {
    try {
        const { data } = await getStages();

        stageOptions.value = data;
    } catch {
        ElMessage.error('Не вдалося завантажити список стадій.');
    }
});
</script>

<template>
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold text-lg mb-3 text-gray-700">Дані Угоди</h3>

        <BaseInput
            v-model="modelValue.deal_name"
            label="Назва угоди"
            prop="deal_name"
            placeholder="Закупівля обладнання"
        />

        <BaseSelect
            v-model="modelValue.stage"
            label="Стадія угоди"
            prop="stage"
            placeholder="Оберіть стадію"
            :options="stageOptions"
        />
    </div>
</template>
