export interface ZohoFormData {
    account_name: string;
    website: string;
    phone: string;
    deal_name: string;
    stage: string;
}

export interface ZohoCreateResponse {
    message: string;
    data: {
        account_id: string;
        deal_id: string;
    };
}

export interface ZohoApiError {
    error?: string;
    message?: string;
}

export interface SelectOption {
    label: string;
    value: string;
}
