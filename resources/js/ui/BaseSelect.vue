<script setup lang="ts">
import type { SelectOption } from '@/types/zoho';

interface Props {
    modelValue?: string;
    label: string;
    prop?: string;
    placeholder?: string;
    options: SelectOption[];
}

withDefaults(defineProps<Props>(), {
    modelValue: '',
    prop: '',
    placeholder: 'Оберіть значення',
});

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();
</script>

<template>
    <el-form-item :label="label" :prop="prop">
        <el-select
            :model-value="modelValue"
            :placeholder="placeholder"
            class="w-full"
            @update:model-value="emit('update:modelValue', $event)"
        >
            <el-option
                v-for="option in options"
                :key="option.value"
                :label="option.label"
                :value="option.value"
            />
        </el-select>
    </el-form-item>
</template>
