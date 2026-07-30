import { ref, reactive } from 'vue';
import { ElMessage, type FormInstance, type FormRules } from 'element-plus';
import axios, { AxiosError } from 'axios';
import type { ZohoFormData, ZohoCreateResponse, ZohoApiError } from '@/types/zoho';

export function useZohoForm() {
    const formRef = ref<FormInstance | null>(null);
    const loading = ref<boolean>(false);

    const formData = reactive<ZohoFormData>({
        account_name: '',
        website: '',
        phone: '',
        deal_name: '',
        stage: '',
    });

    const rules = reactive<FormRules<ZohoFormData>>({
        account_name: [
            {
                required: true,
                message: "Введіть ім'я облікового запису",
                trigger: 'blur'
            },
        ],
        deal_name: [
            {
                required: true,
                message: 'Введіть назву угоди',
                trigger: 'blur'
            },
        ],
        stage: [
            {
                required: true,
                message: 'Оберіть стадію угоди',
                trigger: 'change'
            },
        ],
        phone: [
            {
                pattern: /^\+?[0-9]{10,15}$/,
                message: 'Введіть коректний номер телефону',
                trigger: 'blur',
            },
        ],
        website: [
            {
                type: 'url',
                message: 'Введіть коректний URL (наприклад, https://site.com)',
                trigger: 'blur'
            },
        ],
    });

    const submitForm = async (): Promise<void> => {
        if (!formRef.value) return;

        await formRef.value.validate(async (valid: boolean) => {
            if (!valid) return;

            loading.value = true;
            try {
                const response = await axios.post<ZohoCreateResponse>('/api/zoho/lead-deal', formData);

                ElMessage.success({
                    message: response.data.message || 'Записи успішно створено!',
                    duration: 5000,
                });

                formRef.value?.resetFields();
            } catch (error) {
                const err = error as AxiosError<ZohoApiError>;
                const errorMessage = err.response?.data?.error || 'Помилка при створенні записів.';

                ElMessage.error({
                    message: errorMessage,
                    duration: 5000,
                });
            } finally {
                loading.value = false;
            }
        });
    };

    return {
        formRef,
        formData,
        rules,
        loading,
        submitForm,
    };
}
