<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import { useToast } from '@/Components/ui/toast/use-toast'
import { Label } from '@/components/ui/label'
import {Link, router, useForm, usePage} from '@inertiajs/vue3';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';

const { toast } = useToast();

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    first_name: user.profile.first_name,
    last_name: user.profile.last_name,
    gender: user.profile.gender,
    date_of_birth: user.profile.date_of_birth,
    email: user.email,
});

function refreshUser()
{
    router.get(route('profile.edit'), {}, {
        preserveScroll: true,
    });
}

function submitForm() {
    form.patch(route('profile.update'), {
        onSuccess: () => {
            refreshUser();
            toast({
                title: 'Profile Updated',
                description: 'Your profile information has been successfully updated.',
                variant: 'success',
            });
        },
    });
}
</script>

<template>
    <div class="w-full">
        <section >
            <header>
                <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

                <p class="mt-1 text-sm text-gray-600">
                    Update your account's profile information and email address.
                </p>
            </header>

            <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                <div>
                    <Label for="first_name">First Name</Label>

                    <Input
                        id="first_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.first_name"
                        :class="{ 'border-red-500': form.errors.first_name }"
                        autofocus
                        autocomplete="first_name"
                    />

                    <InputError class="mt-2" :message="form.errors.first_name" />
                </div>

                <div>
                    <Label for="last_name">Last Name</Label>

                    <Input
                        id="last_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.last_name"
                        :class="{ 'border-red-500': form.errors.last_name }"
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>

                <div>
                    <Label for="email">Email</Label>

                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        :class="{ 'border-red-500': form.errors.email }"
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <Label for="date_of_birth">Date of Birth</Label>

                    <Input
                        id="date_of_birth"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.date_of_birth"
                        :class="{ 'border-red-500': form.errors.date_of_birth }"
                        placeholder="yyyy-mm-dd"
                        v-mask="'####-##-##'"
                        autocomplete="date_of_birth"
                    />

                    <InputError class="mt-2" :message="form.errors.date_of_birth" />
                </div>

                <div>
                    <Label for="gender">Gender</Label>

                    <RadioGroup v-model="form.gender"  class="mt-2">
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem id="male" value="male" />
                            <Label for="male">Male</Label>
                        </div>
                        <div class="flex items-center space-x-2">
                            <RadioGroupItem id="female" value="female" />
                            <Label for="female">Female</Label>
                        </div>
                    </RadioGroup>
                </div>

                <div v-if="mustVerifyEmail && user.email_verified_at === null">
                    <p class="text-sm mt-2 text-gray-800">
                        Your email address is unverified.
                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div
                        v-show="status === 'verification-link-sent'"
                        class="mt-2 font-medium text-sm text-green-600"
                    >
                        A new verification link has been sent to your email address.
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <Button :disabled="form.processing" class="w-40">Save</Button>
                </div>
            </form>
        </section>
    </div>
</template>
