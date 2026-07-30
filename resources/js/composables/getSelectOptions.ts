import axios from 'axios';
import type { SelectOption } from '@/types/zoho';

export const getStages = () =>
    axios.get<SelectOption[]>('/api/stages');
