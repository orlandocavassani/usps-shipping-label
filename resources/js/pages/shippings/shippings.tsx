import { Head, Link } from '@inertiajs/react';
import { Plus, Printer } from 'lucide-react';

import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { shippings } from '@/routes';
import { create } from '@/routes/shippings';
import { type BreadcrumbItem } from '@/types';

interface Shipping {
    id: number;
    name: string;
    street: string;
    city: string;
    state: string;
    zip: string;
    country: string;
    phone: string;
    email: string;
    length: string;
    width: string;
    height: string;
    weight: string;
    label_url: string | null;
    created_at: string;
}

interface ShippingsProps {
    shippings: Shipping[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shippings',
        href: shippings().url,
    },
];

export default function Shippings({ shippings }: ShippingsProps) {
    const handlePrint = (shipping: Shipping) => {
        if (shipping.label_url) {
            window.open(shipping.label_url, '_blank');
        } else {
            alert('Label not available yet');
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Shippings" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-end justify-end">
                    <Button asChild>
                        <Link href={create().url}>
                            <Plus className="mr-2 h-4 w-4" />
                            New Shipping
                        </Link>
                    </Button>
                </div>

                {shippings.length === 0 ? (
                    <Card className="p-8 text-center">
                        <p className="text-muted-foreground">
                            No shippings found. Create your first shipping
                            label.
                        </p>
                    </Card>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full border-collapse">
                            <thead>
                                <tr className="border-b">
                                    <th className="px-4 py-3 text-left font-semibold">
                                        Recipient
                                    </th>
                                    <th className="px-4 py-3 text-left font-semibold">
                                        Address
                                    </th>
                                    <th className="px-4 py-3 text-left font-semibold">
                                        Dimensions
                                    </th>
                                    <th className="px-4 py-3 text-left font-semibold">
                                        Weight
                                    </th>
                                    <th className="px-4 py-3 text-left font-semibold">
                                        Date
                                    </th>
                                    <th className="px-4 py-3 text-right font-semibold">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {shippings.map((shipping) => (
                                    <tr
                                        key={shipping.id}
                                        className="border-b hover:bg-muted/50"
                                    >
                                        <td className="px-4 py-3">
                                            <div>
                                                <div className="font-medium">
                                                    {shipping.name}
                                                </div>
                                                <div className="text-sm text-muted-foreground">
                                                    {shipping.email}
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="text-sm">
                                                <div>{shipping.street}</div>
                                                <div className="text-muted-foreground">
                                                    {shipping.city},{' '}
                                                    {shipping.state}{' '}
                                                    {shipping.zip}
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-4 py-3 text-sm">
                                            {shipping.length} × {shipping.width}{' '}
                                            × {shipping.height} in
                                        </td>
                                        <td className="px-4 py-3 text-sm">
                                            {shipping.weight} oz
                                        </td>
                                        <td className="px-4 py-3 text-sm text-muted-foreground">
                                            {new Date(
                                                shipping.created_at,
                                            ).toLocaleDateString()}
                                        </td>
                                        <td className="px-4 py-3 text-right">
                                            <Button
                                                size="sm"
                                                variant="outline"
                                                onClick={() =>
                                                    handlePrint(shipping)
                                                }
                                            >
                                                <Printer className="mr-2 h-4 w-4" />
                                                Print
                                            </Button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
