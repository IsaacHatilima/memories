<script setup lang="ts">
import Modal from '@/Components/Modal.vue';


import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import {CardContent} from "@/Components/ui/card";
import { Label } from '@/Components/ui/label'
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from "@/Components/InputError.vue";

const confirmingUserDeletion = ref(false);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </header>
        <div class="flex justify-end mt-4">
            <Button variant="destructive" @click="confirmUserDeletion" class="w-40">Delete Account</Button>
        </div>


        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Please
                    enter your password to confirm you would like to permanently delete your account.
                </p>

                <div class="mt-6">
                    <Label for="password" value="Password" class="sr-only" />

                    <Input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        :class="{ 'border-red-500': form.errors.password }"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <Button @click="closeModal"> Cancel </Button>

                    <Button
                        variant="destructive"
                        class="ms-3 bg-red-500"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </Button>
                </div>
            </div>
        </Modal>
    </section>
</template>
