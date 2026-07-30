<script setup lang="ts">
interface Props {
    modelValue?: string;
    label: string;
    prop?: string;
    placeholder?: string;
    type?: string;
}

withDefaults(defineProps<Props>(), {
    modelValue: '',
    prop: '',
    placeholder: '',
    type: 'text',
});

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();
</script>

<template>
    <el-form-item :label="label" :prop="prop">
        <el-input
            :model-value="modelValue"
            :placeholder="placeholder"
            :type="type"
            @update:model-value="emit('update:modelValue', $event)"
        />
    </el-form-item>
</template>
