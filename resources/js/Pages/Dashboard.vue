<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {Button} from "@/components/ui/button";

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <h3 class="text-2xl font-bold tracking-tight">
            You have no products
        </h3>
        <p class="text-sm text-muted-foreground">
            You can start selling as soon as you add a product.
        </p>
        <Button class="mt-4">
            Add Product
        </Button>
        <template x-for="item in items">

        </template>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
        <p class="text-sm text-muted-foreground">You can start selling as soon as you add a product.</p>
    </AuthenticatedLayout>
</template>
