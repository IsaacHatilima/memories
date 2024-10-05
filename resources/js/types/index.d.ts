import {Config} from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    downloaded_code: boolean;
    email_verified_at?: string;
    two_factor_secret?: string;
    two_factor_confirmed_at?: string;
    profile: Profile;
}

export interface Profile {
    first_name: string;
    last_name: string;
    date_of_birth: string;
    gender: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};
