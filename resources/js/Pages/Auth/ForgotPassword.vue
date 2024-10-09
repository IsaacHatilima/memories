<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import {CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import { Label } from '@/components/ui/label'
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <CardContent>
            <div class="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset
                link that will allow you to choose a new one.
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
            <div>
                <Label for="email">Email</Label>

                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': form.errors.email }"
                    v-model="form.email"
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <Button class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </Button>
            </div>
        </form>
        </CardContent>
    </GuestLayout>
</template>
