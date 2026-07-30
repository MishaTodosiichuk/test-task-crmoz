<script setup lang="ts">
import { useZohoForm } from '@/composables/useZohoForm';
import AccountFormSection from "@/components/zoho/AccountFormSection.vue";
import DealFormSection from "@/components/zoho/DealFormSection.vue";
import BaseButton from "@/ui/BaseButton.vue";

const { formRef, formData, rules, loading, submitForm } = useZohoForm();
</script>

<template>
    <div class="max-w-2xl mx-auto my-8 p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Створення Угоди та Облікового запису</h2>

        <el-form
            ref="formRef"
            :model="formData"
            :rules="rules"
            label-position="top"
            v-loading="loading"
        >
            <DealFormSection v-model="formData" />
            <AccountFormSection v-model="formData" />

            <BaseButton :loading="loading" @click="submitForm">
                Створити
            </BaseButton>
        </el-form>
    </div>
</template>
