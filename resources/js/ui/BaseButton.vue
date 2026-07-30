<script setup lang="ts">
interface Props {
    type?: 'primary' | 'success' | 'warning' | 'danger' | 'info' | 'default';
    size?: 'large' | 'default' | 'small';
    loading?: boolean;
    disabled?: boolean;
}

withDefaults(defineProps<Props>(), {
    type: 'primary',
    size: 'large',
    loading: false,
    disabled: false,
});

defineEmits<{
    (e: 'click', event: MouseEvent): void;
}>();
</script>

<template>
    <el-button
        :type="type"
        :size="size"
        :loading="loading"
        :disabled="disabled"
        class="w-full"
        @click="$emit('click', $event)"
    >
        <slot></slot>
    </el-button>
</template>
