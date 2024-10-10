<script setup lang="ts">
import { Album, Member } from '@/types'
import {Head, router, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Card, CardContent} from "@/components/ui/card";
import {Label} from "@/components/ui/label";
import {
    Sheet, SheetClose,
    SheetContent,
    SheetDescription, SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet'
import {Button} from '@/components/ui/button'
import {Input} from "@/components/ui/input";
import InputError from "@/components/InputError.vue";
import {useToast} from '@/components/ui/toast/use-toast';

const {toast} = useToast();
let members = usePage().props.members as Member[];
let album = usePage().props.album as Album;

const form = useForm({
    email: '',
    album_id: album.public_id
});
function formatDate(date: string): string {
    return new Date(date).toLocaleDateString();
}

const refreshAlbums = (routeName: string) => {
    router.visit(route(routeName, album.public_id), {
        preserveScroll: true,
        only: ['album'],
    });
}

const handleSubmit = () => {
    form.post(route('album.members.store'), {
        onSuccess: () => {
            form.reset();
            refreshAlbums('albums.show');

            toast({
                title: 'Success',
                description: 'Album Member added successfully.',
                variant: 'success',
            });
        },
        onError: (errors) => {
            if (!form.hasErrors) {
                toast({
                    title: 'Warning',
                    description: 'Something unexpected happened.',
                    variant: 'warning',
                });
            }
        },
    });
};


</script>

<template>
    <Head title="Albums" />

    <AuthenticatedLayout>
        <Card>
            <CardContent class="flex md:flex-row flex-col p-4">
                <img src="https://picsum.photos/seed/picsum/200" alt="Image" class="rounded-md">
                <div class="w-full pt-4">
                    <div class="flex flex-col h-full justify-between px-2">
                        <Label class="font-bold text-sky-500 text-md">
                            {{ album.name }}
                        </Label>
                        <Label class="font-semibold text-black my-2">
                            {{ album.description }}
                        </Label>
                        <div class="flex justify-between items-baseline">
                            <span class="text-sm text-gray-400">Created: {{ formatDate(album.created_at) }}</span>
                            <Sheet>
                                <SheetTrigger as-child>
                                    <Button class="py-4">
                                        Members
                                    </Button>
                                </SheetTrigger>
                                <SheetContent>
                                    <SheetHeader>
                                        <SheetTitle>Members</SheetTitle>
                                        <SheetDescription>
                                            Add more members to the album
                                        </SheetDescription>
                                    </SheetHeader>
                                    <form @submit.prevent="handleSubmit">
                                        <div class="grid w-full max-w-sm items-center gap-1.5 py-4">
                                            <Label for="email">Email</Label>
                                            <Input
                                                id="email"
                                                type="text"
                                                class="mt-1 block w-full"
                                                :class="{ 'border-red-500': form.errors.email }"
                                                v-model="form.email"
                                                autocomplete="email"
                                            />
                                            <InputError class="mt-2" :message="form.errors.email" />
                                        </div>
                                        <SheetFooter>
                                            <SheetClose as-child>
                                                <Button variant="outline">
                                                    CLose
                                                </Button>
                                            </SheetClose>
                                            <Button type="submit"
                                                    :class="{ 'opacity-25': form.processing }"
                                                    :disabled="form.processing">
                                                Save changes
                                            </Button>
                                        </SheetFooter>
                                    </form>
                                    <div v-for="member in members" :key="member.public_id" class="mt-4 border-2 rounded-md p-2">
                                        <Label>
                                            {{ member.user.profile.first_name }} <span class="text-gray-400 text-sm">({{ member.user.email }})</span>
                                        </Label>
                                    </div>
                                </SheetContent>
                            </Sheet>
                        </div>

                    </div>

                </div>
            </CardContent>
        </Card>
        <div class="flex">
            <div class="flex-1">images here</div>

        </div>
    </AuthenticatedLayout>
</template>
