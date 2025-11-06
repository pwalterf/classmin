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

export type BreadcrumbItemType = BreadcrumbItem;

export interface Facet {
    value: string;
    label: string;
    options: Enum[];
}

export interface Enum {
    value: string;
    label?: string;
    color?: string;
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

export interface Teacher {
    id: number;
    bio: string | null;
    user: User;
};

export interface Course {
    id: number;
    title: string;
    description: string;
    started_at: string | undefined;
    status: Enum;
    schedule: string | null;
    teacher: Teacher;
    enrollments: Enrollment[];
    prices: CoursePrice[];
    lastPrice: CoursePrice;
    students: Student[];
    lessons: Lesson[];
};

export interface CoursePrice {
    id: number;
    price: number;
    currency: string;
    started_at: string | undefined;
    ended_at: string | undefined;
    course: Course;
};

export interface Student {
    id: number;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string;
    date_of_birth: string | undefined;
    phone_number: string | null;
    teacher: Teacher;
    enrollments?: Enrollment[];
};

export interface Enrollment {
    id?: number;
    status: Enum;
    enrolled_at: string | undefined;
    credits: number;
    discount_pct: number | undefined;
    student: Student;
    course?: Course;
    payments?: Payment[];
    creditTransactions?: CreditTransaction[];
};

export interface Lesson {
    id: number;
    notes: string;
    student_page: string | null;
    workbook_page: string | null;
    taught_at: string | undefined;
    course: Course;
    attendances: Attendance[];
}

export interface Attendance {
    id?: number;
    status: Enum;
    notes?: string;
    enrollment?: Enrollment;
    lesson?: Lesson;
}

export interface Payment {
    id: number;
    amount: number;
    currency: string;
    credits_purchased: number;
    paid_at: string;
    comments?: string;
    enrollment: Enrollment;
};

export interface CreditTransaction {
    id: number;
    transacted_at: string | undefined;
    type: Enum;
    credits: number;
    balance: number;
    description?: string;
    enrollment: Enrollment;
    transactable?: Payment | Attendance;
};