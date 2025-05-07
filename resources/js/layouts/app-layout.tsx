import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode } from 'react';

interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
    role?: string;
}

export default ({ children, breadcrumbs, role }: AppLayoutProps) => (
    <AppLayoutTemplate breadcrumbs={breadcrumbs} role={role}>
        {children}
    </AppLayoutTemplate>
);
