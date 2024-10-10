<script lang="ts" setup>
import {onMounted, ref} from 'vue';
import {Button} from '@/components/ui/button';
import {useToast} from '@/components/ui/toast/use-toast';
import {router, useForm, usePage} from '@inertiajs/vue3';
import axios from 'axios';
import {PinInput, PinInputGroup, PinInputInput,} from '@/components/ui/pin-input'
import {Inertia} from '@inertiajs/inertia';

const {toast} = useToast();
const user = usePage().props.auth.user;
const qrCode = ref<string | null>(null);
const recoveryCodes = ref<string[]>([]);
const otp = ref<string[]>([])
const loading = ref(false);

// Form handling
const form = useForm({});

onMounted(() => {
    if (user.two_factor_secret != '') {
        getTwoFactorQRCode();
        getTwoFactorRecoveryCodes();
    }
});

// Submit 2FA Confirmation code
function submitOTP() {
    loading.value = true;
    try {
        // Make POST request to the server
        axios.post('/user/confirmed-two-factor-authentication', {'code': otp.value.join('')})
            .then(response => {
                Inertia.visit(route('profile.edit'), {
                    only: ['user'],
                })
                toast({
                    title: '2FA Verified',
                    description: 'Your 2FA has been verified.',
                    variant: 'success',
                });
            })
            .catch(error => {
                toast({
                    title: 'Warning',
                    description: '2FA verification failed.',
                    variant: 'warning',
                });
            });


    } catch (error) {
        // Handle error
        console.error('Error submitting data:', error);
        alert('Failed to submit data');
    } finally {
        loading.value = false; // Reset loading state
    }
}

// Fetch QR code from API
function getTwoFactorQRCode() {
    axios.get('/user/two-factor-qr-code')
        .then(response => {
            qrCode.value = response.data.svg; // Update the ref's value
        })
        .catch(error => {
            toast({
                title: 'Warning',
                description: 'Error fetching QR code.',
                variant: 'warning',
            });
        });
}

function getTwoFactorRecoveryCodes() {
    axios.get('/user/two-factor-recovery-codes')
        .then(response => {
            recoveryCodes.value = response.data; // Update the ref's value
        })
        .catch(error => {
            toast({
                title: 'Warning',
                description: 'Error fetching recovery code.',
                variant: 'warning',
            });
        });
}

function refreshUser() {
    router.get(route('profile.edit'), {}, {
        preserveScroll: true,
    });
}

// Activate 2FA
function activateTwoFA() {
    axios.post('/user/two-factor-authentication')
        .then(response => {
            refreshUser();
            getTwoFactorQRCode();
            toast({
                title: '2FA Enabled',
                description: 'Your 2FA has been enabled.',
                variant: 'success',
            });
        })
        .catch(error => {
            toast({
                title: 'Warning',
                description: '2FA enabling failed.',
                variant: 'warning',
            });
        });
}

// Disable 2FA
function deactivateTwoFA() {
    axios.delete('/user/two-factor-authentication')
        .then(response => {
            refreshUser();
            toggleRecoveryCodesDownload();
            two_factor_confirmed_at();
            toast({
                title: '2FA Enabled',
                description: 'Your 2FA has been disabled.',
                variant: 'success',
            });
        })
        .catch(error => {
            toast({
                title: 'Warning',
                description: '2FA disabling failed.',
                variant: 'warning',
            });
        });
}

// Clear Two Factor Confirmed At
function two_factor_confirmed_at() {
    return axios.patch(route('clear.2fa.confirmation'));
}

// Toggle Recover Codes Copied
function toggleRecoveryCodesDownload() {
    return axios.patch(route('recovery.codes'));
}

// Download Recovery Codes
function downloadFile(recoveryCodes: string[]) {
    // Create the content for the file using the existing recoveryCodes
    const content = recoveryCodes.join('\n');

    // Create a Blob object with the content
    const blob = new Blob([content], {type: 'text/plain'});

    // Create a temporary anchor element to trigger the download
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'recoveryCodes.txt';

    toggleRecoveryCodesDownload()
        .then(response => {
            link.click();
            refreshUser();
            toast({
                title: '2FA Recovery Codes',
                description: 'Codes downloaded successfully..',
                variant: 'success',
            });
        })
        .catch(error => {
            toast({
                title: 'Warning',
                description: 'Recovery codes download failed.',
                variant: 'warning',
            });
        });
    // Cleanup the URL object
    URL.revokeObjectURL(link.href);
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Two Factor Authentication</h2>

            <p class="mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <div v-if="user.two_factor_secret  && !user.two_factor_confirmed_at"
             class="mb-4 mt-4 text-red-400 font-medium text-sm">
            Please finish configuring two factor authentication below.
        </div>

        <div v-if="user.two_factor_secret  && !user.two_factor_confirmed_at"
             class="flex flex-col md:flex-row items-center justify-between">
            <div v-if="qrCode" v-html="qrCode"></div>
            <div class="flex flex-1 flex-col mt-4 items-center ">
                <div class="flex-1 ml-4 mb-4">
                    <PinInput
                        id="pin-input"
                        v-model="otp"
                        placeholder="○"
                    >
                        <PinInputGroup>
                            <PinInputInput
                                v-for="(id, index) in 6"
                                :key="id"
                                :index="index"
                            />
                        </PinInputGroup>
                    </PinInput>
                </div>

            </div>

        </div>

        <div v-if="!user.downloaded_code && user.two_factor_confirmed_at">
            <ul class="mt-5 mb-4">
                <li v-for="(item, index) in recoveryCodes" :key="index" class="font-semibold">
                    → {{ item }}
                </li>
            </ul>

            <Button @click="downloadFile(recoveryCodes)">
                Download as .txt
            </Button>
        </div>

        <div v-if="user.two_factor_secret  && user.two_factor_confirmed_at" class="flex justify-end mt-2">
            <Button :disabled="loading" variant="destructive" @click="deactivateTwoFA">Deactivate 2FA</Button>
        </div>

        <div v-if="user.two_factor_secret  && !user.two_factor_confirmed_at" class="flex justify-end mt-2">
            <Button :disabled="loading" class="bg-yellow-500 hover:bg-yellow-600 mr-2" @click="deactivateTwoFA">Cancel
                2FA Activation
            </Button>
            <Button :disabled="loading" @click="submitOTP">Confirm</Button>
        </div>

        <div v-if="!user.two_factor_secret  && !user.two_factor_confirmed_at"
             class="flex items-center justify-end gap-4">
            <Button :disabled="form.processing" class="w-40" @click="activateTwoFA">Activate</Button>
        </div>
    </section>
</template>
