<script lang="ts" setup>
import SideNav from "@/Components/sidenav/SideNav.vue";
import TopNav from "@/Components/TopNav.vue";
import {Toaster} from '@/Components/ui/toast'
import {ScrollArea} from '@/Components/ui/scroll-area'
</script>

<template>
    <Toaster/>
    <div class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]">
        <SideNav/>
        <div class="flex flex-col">
            <TopNav/>
            <div class="flex flex-col flex-1 overflow-hidden">
                <ScrollArea class="w-full h-[calc(100vh-5vh)] overflow-y-auto p-4">
                    <main class="flex flex-col flex-1 gap-4">
                        <slot/>
                    </main>
                </ScrollArea>
            </div>
        </div>
    </div>

</template>
