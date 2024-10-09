<script lang="ts" setup>

import {CircleUser, Menu, Search} from "lucide-vue-next";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from "@/components/ui/dropdown-menu";
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Sheet, SheetContent, SheetDescription, SheetTitle, SheetTrigger} from "@/components/ui/sheet";
import {Input} from "@/components/ui/input";
import {Link} from '@inertiajs/vue3';
import {ScrollArea} from '@/components/ui/scroll-area';
import SideNavContent from "./sidenav/SideNavContent.vue";
</script>

<template>
    <header class="flex h-14 items-center shadow-md gap-4 bg-white px-4 lg:h-[60px] lg:px-6 justify-between md:justify-end">
        <Sheet>
            <SheetTrigger as-child>
                <Button
                    class="shrink-0 md:hidden"
                    size="icon"
                    variant="outline"
                >
                    <Menu class="h-5 w-5"/>
                    <span class="sr-only">Toggle navigation menu</span>
                </Button>
            </SheetTrigger>
            <SheetContent class="flex flex-col" side="left">
                <SheetTitle>
                    <a class="flex items-center gap-2 font-semibold" href="/">
                        <span>Memories</span>
                    </a>
                </SheetTitle>
                <SheetDescription class="hidden">Description goes here</SheetDescription>
                <div class="flex-1 overflow-hidden">
                    <ScrollArea class="h-full max-h-[calc(100vh-60px-16px)]">
                        <!-- <SideNavContent /> -->
                        <SideNavContent/>
                    </ScrollArea>
                </div>
            </SheetContent>
        </Sheet>
        <DropdownMenu >
            <DropdownMenuTrigger as-child>
                <Button class="rounded-full" size="icon" variant="secondary">
                    <CircleUser class="h-5 w-5"/>
                    <span class="sr-only">Toggle user menu</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>{{ $page.props.auth.user.profile!.first_name }}
                    {{ $page.props.auth.user.profile!.last_name }}
                </DropdownMenuLabel>
                <DropdownMenuSeparator/>
                <DropdownMenuItem>
                    <Link :href="route('profile.edit')">
                        Settings
                    </Link>
                </DropdownMenuItem>
                <DropdownMenuSeparator/>
                <DropdownMenuItem>
                    <Link :href="route('logout')" as="button" method="post">
                        Logout
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </header>
</template>
