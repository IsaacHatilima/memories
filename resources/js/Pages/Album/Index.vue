<script setup lang="ts">
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import {Button} from '@/components/ui/button'
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import InputError from "@/components/InputError.vue";
import {Card, CardContent} from "@/components/ui/card";
import {useToast} from '@/components/ui/toast/use-toast';
import {computed, ref} from 'vue';
import { Album } from '@/types'

const {toast} = useToast();
let albums = usePage().props.albums as Album[];
const searchQuery = ref('');
const selectedAlbum = ref({ name: '', description: '' });

const filteredAlbums = computed(() => {
    return albums.filter(album =>
        album.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

function formatDate(date: string): string {
    return new Date(date).toLocaleDateString();
}

const form = useForm({
    name: '',
    description: ''
});

const refreshAlbums = (routeName: string) => {
    router.visit(route(routeName), {
        preserveScroll: true,
        only: ['albums'],
    });
}

const handleSubmit = () => {
    form.post(route('albums.store'), {
        onSuccess: () => {
            form.reset();
            refreshAlbums('albums.index');

            toast({
                title: 'Success',
                description: 'Album created successfully.',
                variant: 'success',
            });
        },
        onError: (errors) => {
            toast({
                title: 'Warning',
                description: 'Something unexpected happened.',
                variant: 'warning',
            });
        },
    });
};

const selectAlbum = (album: Album) => {
    selectedAlbum.value = { ...album };
};

const handleUpdate = (albumId: string) => {
    form.name = selectedAlbum.value.name;
    form.description = selectedAlbum.value.description;

    form.patch(route('albums.update', albumId), {
        onSuccess: () => {
            toast({
                title: 'Success',
                description: 'Album updated successfully.',
                variant: 'success',
            });
            selectedAlbum.value = { name: '', description: '' };
            refreshAlbums('albums.index');
        },
        onError: (errors) => {
            toast({
                title: 'Warning',
                description: 'Something unexpected happened.',
                variant: 'warning',
            });
        },
    });
};

const handleDelete = (albumId: string) => {
    const { url } = usePage();
    console.log(url)
    form.delete(route('albums.destroy', albumId), {
        onSuccess: () => {
            if(url === '/albums') {
                refreshAlbums('albums.index');
            } else {
                refreshAlbums('albums.trashed');
            }

            toast({
                title: 'Success',
                description: 'Album deleted successfully.',
                variant: 'success',
            });
        },
        onError: () => {
            toast({
                title: 'Warning',
                description: 'Something unexpected happened.',
                variant: 'warning',
            });
        },
    });
};

const handleArchive = (albumId: string) => {
    form.patch(route('albums.archive', albumId), {
        onSuccess: () => {
            refreshAlbums('albums.index');

            toast({
                title: 'Success',
                description: 'Album archived successfully.',
                variant: 'success',
            });
        },
        onError: () => {
            toast({
                title: 'Warning',
                description: 'Something unexpected happened.',
                variant: 'warning',
            });
        },
    });
};

const handleRestore = (albumId: string) => {
    form.patch(route('albums.restore', albumId), {
        onSuccess: () => {
            refreshAlbums('albums.trashed');

            toast({
                title: 'Success',
                description: 'Album restored successfully.',
                variant: 'success',
            });
        },
        onError: () => {
            toast({
                title: 'Warning',
                description: 'Something unexpected happened.',
                variant: 'warning',
            });
        },
    });
};

</script>

<template>
    <Head title="Albums" />

    <AuthenticatedLayout>
        <div class="pr-4">
            <Dialog>
                <div class="flex justify-end">
                    <DialogTrigger as-child>
                        <Button class="w-40 border-2 border-slate-700 text-white hover:text-white">
                            Create Album
                        </Button>
                    </DialogTrigger>
                </div>

                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Create Album</DialogTitle>
                        <DialogDescription>
                            Create an album to group memories
                        </DialogDescription>
                    </DialogHeader>

                    <form @submit.prevent="handleSubmit">
                        <div class="grid w-full max-w-sm items-center gap-1.5">
                            <Label for="name">Album Name</Label>
                            <Input
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                :class="{ 'border-red-500': form.errors.name }"
                                v-model="form.name"
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="grid w-full max-w-sm items-center gap-1.5 mt-4">
                            <Label for="description">Album Description</Label>
                            <Input
                                id="description"
                                type="text"
                                class="mt-1 block w-full"
                                :class="{ 'border-red-500': form.errors.description }"
                                v-model="form.description"
                                autocomplete="description"
                            />
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <DialogFooter>
                            <Button
                                class="w-full mt-2"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Create
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            <div class="mt-4 flex justify-end">
                <Input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search albums..."
                    class="border rounded p-2 mb-4 w-96"
                />
            </div>


            <div class="flex-grow overflow-y-auto">
                <div v-if="filteredAlbums.length === 0" class="text-center text-gray-500">
                    No Album found
                </div>
                <div v-else class="grid md:grid-cols-3 gap-4">
                    <div v-for="album in filteredAlbums" :key="album.public_id">
                        <Card class="h-40">


                            <CardContent class="flex row -mx-6">
                                <img src="https://picsum.photos/200" alt="Image" height="100" width="158" class="rounded-l-md">
                                <div class="w-full pt-4">
                                    <div class="flex flex-col items-baseline justify-between px-2">
                                        <Link
                                            :href="route('albums.show', album.public_id)"
                                            class="font-bold text-sky-500 underline">
                                            {{ album.name }}
                                        </Link>
                                        <span class="text-sm text-gray-400">Created: {{ formatDate(album.created_at) }}</span>
                                    </div>
                                    <div class="flex flex-col justify-end px-2 h-20">

                                        <div class="flex justify-end">
                                            <div class="w-24 flex" :class="!album.deleted_at ? 'justify-between' : 'justify-end'">
                                        <span class="text-sky-600" v-if="!album.deleted_at">
                                            <Dialog>
                                                <div class="flex justify-end">
                                                    <DialogTrigger as-child>
                                                        <span class="cursor-pointer" @click="selectAlbum(album)">Edit</span>
                                                    </DialogTrigger>
                                                </div>

                                                <DialogContent class="sm:max-w-[425px]">
                                                    <DialogHeader>
                                                        <DialogTitle>Update Album</DialogTitle>
                                                    </DialogHeader>

                                                    <form @submit.prevent="handleUpdate(album.public_id)">
                                                        <div class="grid w-full max-w-sm items-center gap-1.5">
                                                            <Label for="name">Album Name</Label>
                                                            <Input
                                                                id="name"
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                :class="{ 'border-red-500': form.errors.name }"
                                                                v-model="selectedAlbum.name"
                                                                autocomplete="name"
                                                            />
                                                            <InputError class="mt-2" :message="form.errors.name" />
                                                        </div>

                                                        <div class="grid w-full max-w-sm items-center gap-1.5 mt-4">
                                                            <Label for="description">Album Description</Label>
                                                            <Input
                                                                id="description"
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                :class="{ 'border-red-500': form.errors.description }"
                                                                v-model="selectedAlbum.description"
                                                                autocomplete="description"
                                                            />
                                                            <InputError class="mt-2" :message="form.errors.description" />
                                                        </div>

                                                        <DialogFooter>
                                                            <Button
                                                                class="w-full mt-2"
                                                                :class="{ 'opacity-25': form.processing }"
                                                                :disabled="form.processing"
                                                            >
                                                                Update
                                                            </Button>
                                                        </DialogFooter>
                                                    </form>
                                                </DialogContent>
                                            </Dialog>
                                        </span>

                                                <span class="text-red-600">
                                          <AlertDialog>
                                            <AlertDialogTrigger>Delete</AlertDialogTrigger>
                                            <AlertDialogContent>
                                              <AlertDialogHeader>
                                                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                                                <AlertDialogDescription>
                                                  This action cannot be undone. This will permanently delete album <span class="font-bold text-black">{{album.name}}</span>.
                                                </AlertDialogDescription>
                                              </AlertDialogHeader>
                                              <AlertDialogFooter>
                                                <AlertDialogCancel>Cancel</AlertDialogCancel>
                                                <AlertDialogAction class="bg-red-600 hover:bg-red-500" @click="handleDelete(album.public_id)">Continue</AlertDialogAction>
                                                <AlertDialogAction v-if="!album.deleted_at" class="bg-yellow-600 hover:bg-yellow-500" @click="handleArchive(album.public_id)">Archive Instead</AlertDialogAction>
                                                <AlertDialogAction v-if="album.deleted_at" class="bg-green-600 hover:bg-green-500" @click="handleRestore(album.public_id)">Restore Instead</AlertDialogAction>
                                              </AlertDialogFooter>
                                            </AlertDialogContent>
                                          </AlertDialog>
                                        </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

