<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from '@/Components/ui/button';
import {CardContent} from "@/Components/ui/card";
import { useToast } from '@/Components/ui/toast/use-toast';
import { Head } from '@inertiajs/vue3';
import {PinInput, PinInputGroup, PinInputInput} from "@/Components/ui/pin-input";
import axios from "axios";
import {ref} from "vue";

const otp = ref<string[]>([])
const loading = ref(false);
let errorMessage = ref<string>('');
const { toast } = useToast();

function submitOTP() {
    loading.value = true;
    try {
        axios.post('/two-factor-challenge', {'code' : otp.value.join('') })
            .then(response => {
                errorMessage.value = '';
                window.location.href = route('dashboard');
            })
            .catch(error => {
                errorMessage.value = 'Invalid 2FA Code';
            });
    } catch (error) {
        errorMessage.value = 'An unexpected error occurred';
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <GuestLayout>
        <Head title="2FA Challenge" />
        <CardContent>
            <div class="flex flex-col items-center justify-center">
                <PinInput
                    id="pin-input"
                    v-model="otp"
                    placeholder="○"
                    class="my-4"
                >
                    <PinInputGroup>
                        <PinInputInput
                            v-for="(id, index) in 6"
                            :key="id"
                            :index="index"
                        />
                    </PinInputGroup>
                </PinInput>
                <p v-if="errorMessage" class="text-red-600 mb-2 font-semibold">{{ errorMessage }}</p>
                <Button class="w-full" @click="submitOTP" :disabled="loading">Confirm</Button>
            </div>
        </CardContent>
    </GuestLayout>
</template>
