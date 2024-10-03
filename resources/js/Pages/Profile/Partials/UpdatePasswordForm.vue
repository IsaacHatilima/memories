<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { useForm } from 'laravel-precognition-vue-inertia';
import { ref } from 'vue';
import { useToast } from '@/Components/ui/toast/use-toast'

const { toast } = useToast();

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

/*
const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});
*/

const form = useForm('put', route('password.update'), {
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        toast({
            title: 'Password Updated',
            description: 'Your password has been successfully updated.',
            variant: 'success',
        });
        form.reset();
    },
    onError: () => {
        if (form.errors.password) {
            form.reset('password', 'password_confirmation');
            passwordInput.value?.focus();
        }
        if (form.errors.current_password) {
            form.reset('current_password');
            // currentPasswordInput.value?.focus();
        }
    },
});

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <Label for="current_password">Current Password</Label>

                <Input
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': form.errors.current_password }"
                    autocomplete="current-password"
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div>
                <Label for="password">New Password</Label>

                <Input
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': form.errors.password }"
                    autocomplete="new-password"
                    @input="form.validate('password')"
                />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div>
                <Label for="password_confirmation">Confirm Password</Label>

                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': form.errors.password_confirmation }"
                    autocomplete="new-password"
                    @input="form.validate('password_confirmation')"
                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-4">
                <Button :disabled="form.processing" class="w-40">Save</Button>
            </div>
        </form>
    </section>
</template>
