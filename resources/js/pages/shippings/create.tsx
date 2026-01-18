import { Form, Head, Link } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AppLayout from '@/layouts/app-layout';
import { shippings } from '@/routes';
import { store } from '@/routes/shippings';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shippings',
        href: shippings().url,
    },
    {
        title: 'New Shipping',
        href: '#',
    },
];

export default function CreateShipping() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="New Shipping" />
            <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <Button variant="outline" size="icon" asChild>
                        <Link href={shippings().url}>
                            <ArrowLeft className="h-4 w-4" />
                        </Link>
                    </Button>
                    <h1 className="text-2xl font-bold">New Shipping</h1>
                </div>

                <Form {...store.form()} className="max-w-2xl space-y-6">
                    {({ processing, errors }) => (
                        <>
                            <div className="space-y-4">
                                <h2 className="text-lg font-semibold">
                                    Recipient Information
                                </h2>

                                <div className="space-y-2">
                                    <Label htmlFor="name">Full Name *</Label>
                                    <Input
                                        id="name"
                                        name="name"
                                        type="text"
                                        autoFocus
                                        tabIndex={1}
                                        placeholder="John Doe"
                                        required
                                    />
                                    <InputError message={errors.name} />
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="email">Email *</Label>
                                    <Input
                                        id="email"
                                        name="email"
                                        type="email"
                                        tabIndex={2}
                                        placeholder="john@example.com"
                                        required
                                    />
                                    <InputError message={errors.email} />
                                </div>

                                <div className="space-y-2">
                                    <Label htmlFor="phone">Phone *</Label>
                                    <Input
                                        id="phone"
                                        name="phone"
                                        type="tel"
                                        tabIndex={3}
                                        placeholder="(555) 123-4567"
                                        onChange={(e) => {
                                            const value =
                                                e.target.value.replace(
                                                    /\D/g,
                                                    '',
                                                );
                                            const match = value.match(
                                                /^(\d{0,3})(\d{0,3})(\d{0,4})$/,
                                            );
                                            if (match) {
                                                e.target.value = !match[2]
                                                    ? match[1]
                                                    : `(${match[1]}) ${match[2]}${match[3] ? `-${match[3]}` : ''}`;
                                            }
                                        }}
                                        maxLength={14}
                                        required
                                    />
                                    <InputError message={errors.phone} />
                                </div>
                            </div>
                            {/* Address Information */}
                            <div className="space-y-4">
                                <h2 className="text-lg font-semibold">
                                    Address
                                </h2>

                                <div className="space-y-2">
                                    <Label htmlFor="street">
                                        Street Address *
                                    </Label>
                                    <Input
                                        id="street"
                                        name="street"
                                        type="text"
                                        tabIndex={4}
                                        placeholder="123 Main Street"
                                        required
                                    />
                                    <InputError message={errors.street} />
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="city">City *</Label>
                                        <Input
                                            id="city"
                                            name="city"
                                            type="text"
                                            tabIndex={5}
                                            placeholder="New York"
                                            required
                                        />
                                        <InputError message={errors.city} />
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="state">State *</Label>
                                        <Input
                                            id="state"
                                            name="state"
                                            type="text"
                                            tabIndex={6}
                                            placeholder="NY"
                                            maxLength={2}
                                            className="uppercase"
                                            required
                                        />
                                        <InputError message={errors.state} />
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="zip">ZIP Code *</Label>
                                        <Input
                                            id="zip"
                                            name="zip"
                                            type="text"
                                            tabIndex={7}
                                            placeholder="10001"
                                            maxLength={5}
                                            required
                                        />
                                        <InputError message={errors.zip} />
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="country">
                                            Country *
                                        </Label>
                                        <Input
                                            id="country"
                                            name="country"
                                            type="text"
                                            tabIndex={8}
                                            placeholder="US"
                                            maxLength={2}
                                            className="uppercase"
                                            required
                                        />
                                        <InputError message={errors.country} />
                                    </div>
                                </div>
                            </div>

                            {/* Package Dimensions */}
                            <div className="space-y-4">
                                <h2 className="text-lg font-semibold">
                                    Package Dimensions
                                </h2>

                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="length">
                                            Length (inches) *
                                        </Label>
                                        <Input
                                            id="length"
                                            name="length"
                                            type="number"
                                            tabIndex={9}
                                            step="0.01"
                                            min="0"
                                            placeholder="12.5"
                                            required
                                        />
                                        <InputError message={errors.length} />
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="width">
                                            Width (inches) *
                                        </Label>
                                        <Input
                                            id="width"
                                            name="width"
                                            type="number"
                                            tabIndex={10}
                                            step="0.01"
                                            min="0"
                                            placeholder="8.5"
                                            required
                                        />
                                        <InputError message={errors.width} />
                                    </div>
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="height">
                                            Height (inches) *
                                        </Label>
                                        <Input
                                            id="height"
                                            name="height"
                                            type="number"
                                            tabIndex={11}
                                            step="0.01"
                                            min="0"
                                            placeholder="6.5"
                                            required
                                        />
                                        <InputError message={errors.height} />
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="weight">
                                            Weight (oz) *
                                        </Label>
                                        <Input
                                            id="weight"
                                            name="weight"
                                            type="number"
                                            tabIndex={12}
                                            step="0.01"
                                            min="0"
                                            placeholder="16"
                                            required
                                        />
                                        <InputError message={errors.weight} />
                                    </div>
                                </div>
                            </div>

                            <div className="flex gap-4">
                                <Button type="submit" tabIndex={13}>
                                    {processing && <Spinner />}
                                    Create Shipping
                                </Button>
                                <Button
                                    tabIndex={14}
                                    variant="outline"
                                    type="button"
                                    asChild
                                >
                                    <Link href={shippings().url}>Cancel</Link>
                                </Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </AppLayout>
    );
}
