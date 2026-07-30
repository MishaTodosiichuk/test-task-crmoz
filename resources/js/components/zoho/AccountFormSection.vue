<script setup lang="ts">

import type { ZohoFormData } from '@/types/zoho';
import BaseInput from "@/ui/BaseInput.vue";

defineProps<{
    modelValue: ZohoFormData;
}>();
</script>

<template>
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold text-lg mb-3 text-gray-700">Дані Облікового запису</h3>

        <BaseInput
            v-model="modelValue.account_name"
            label="Ім'я облікового запису"
            prop="account_name"
            placeholder="ТОВ 'Вектор'"
        />

        <BaseInput
            v-model="modelValue.website"
            label="Веб-сайт"
            prop="website"
            placeholder="https://example.com"
        />

        <BaseInput
            v-model="modelValue.phone"
            label="Телефон"
            prop="phone"
            placeholder="+380971234567"
        />
    </div>
</template>
