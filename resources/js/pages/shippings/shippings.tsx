import { Head } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';
import { shippings } from '@/routes';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shippings',
        href: shippings().url,
    },
];

export default function Shippings() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Shippings" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"></div>
        </AppLayout>
    );
}
