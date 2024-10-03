<script setup lang="ts">

import {CircleUser, Menu, Search} from "lucide-vue-next";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem, DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from "@/Components/ui/dropdown-menu";
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/Components/ui/card";
import {Button} from "@/Components/ui/button";
import {Sheet, SheetContent, SheetTrigger, SheetTitle, SheetDescription} from "@/Components/ui/sheet";
import {Input} from "@/Components/ui/input";
import { Link } from '@inertiajs/vue3';
import { ScrollArea } from '@/Components/ui/scroll-area';
import SideNavContent from "./sidenav/SideNavContent.vue";
</script>

<template>
    <header class="flex h-14 items-center shadow-md gap-4 bg-white px-4 lg:h-[60px] lg:px-6">
        <Sheet>
            <SheetTrigger as-child>
                <Button
                    variant="outline"
                    size="icon"
                    class="shrink-0 md:hidden"
                >
                    <Menu class="h-5 w-5" />
                    <span class="sr-only">Toggle navigation menu</span>
                </Button>
            </SheetTrigger>
            <SheetContent side="left" class="flex flex-col">
                <SheetTitle>
                    <a href="/" class="flex items-center gap-2 font-semibold">
                        <span>Acme Inc</span>
                    </a>
                </SheetTitle>
                <SheetDescription class="hidden">Description goes here</SheetDescription>
                <div class="flex-1 overflow-hidden">
                    <ScrollArea class="h-full max-h-[calc(100vh-60px-16px)]">
                        <!-- <SideNavContent /> -->
                         <SideNavContent/>
                    </ScrollArea>
                </div>
                <div class="mt-auto">
                    <Card>
                        <CardHeader>
                            <CardTitle>Upgrade to Pro</CardTitle>
                            <CardDescription>
                                Unlock all features and get unlimited access to our
                                support team.
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <Button size="sm" class="w-full">
                                Upgrade
                            </Button>
                        </CardContent>
                    </Card>
                </div>
            </SheetContent>
        </Sheet>
        <div class="w-full flex-1">
            <form>
                <div class="relative">
                    <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                    <Input
                        type="search"
                        placeholder="Search products..."
                        class="w-full appearance-none bg-background pl-8 shadow-none md:w-2/3 lg:w-1/3"
                    />
                </div>
            </form>
        </div>
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="secondary" size="icon" class="rounded-full">
                    <CircleUser class="h-5 w-5" />
                    <span class="sr-only">Toggle user menu</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>{{ $page.props.auth.user.profile.first_name }} {{ $page.props.auth.user.profile.last_name }}</DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                    <Link :href="route('profile.edit')">
                        Settings
                    </Link>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem>
                    <Link :href="route('logout')" method="post" as="button">
                        Logout
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    </header>
</template>
