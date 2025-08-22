import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface Enum {
    value: string;
    label: string;
    color: string;
};

export interface User {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    status: Enum;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
};

export type BreadcrumbItemType = BreadcrumbItem;

export interface Teacher {
    id: number;
    bio: string | null;
    user: User;
};

export interface Facet {
    value: string
    label: string
    options: Array<Enum>
}