<script setup lang="ts">
    import { Home, Images, ArrowRight } from "lucide-vue-next";
    import { Link } from "@inertiajs/vue3";
    import { ref, watchEffect } from "vue";

    const openDropdown = ref<string | null>(null);
    const dropdownRoutesMap: Record<string, string[]> = {
        album: ['albums.index', 'albums.trashed'],
    };
    const toggleDropdown = (dropdownName: string) => {
        openDropdown.value = openDropdown.value === dropdownName ? null : dropdownName;
    };

    watchEffect(() => {
        for (const [dropdown, routes] of Object.entries(dropdownRoutesMap)) {
            if (routes.some(routeName => route().current(routeName))) {
                openDropdown.value = dropdown;
                return;
            }
        }

        openDropdown.value = null;
    });

</script>

<template>
    <nav class="grid items-start px-2 text-sm font-medium lg:px-4">
        <!-- Dashboard Link -->
        <Link
          :href="route('dashboard')"
          class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg text-muted-foreground hover:text-primary"
          :class="{ 'bg-muted': route().current('dashboard') }"
        >
          <Home class="w-4 h-4" />
          Dashboard
        </Link>

        <div>
            <a
                href="#"
                @click="toggleDropdown('album')"
                class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg text-muted-foreground hover:text-primary"
                :class="{ 'bg-muted': openDropdown === 'album' }"
            >
                <Images class="w-4 h-4" />
                Albums
                <ArrowRight
                    class="ml-auto transition-transform"
                    :class="{ 'rotate-90': openDropdown === 'album' }"
                />
            </a>

            <ul v-if="openDropdown === 'album'" class="ml-6 space-y-1">
                <li>
                    <Link
                        :href="route('albums.index')"
                        class="flex items-center gap-2 px-3 py-1 transition-all rounded-lg text-muted-foreground hover:text-primary"
                        :class="{ 'underline': route().current('albums.index') }">
                        <span class="w-2 h-2 bg-primary rounded-full"></span>
                        Albums
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('albums.trashed')"
                        class="flex items-center gap-2 px-3 py-1 transition-all rounded-lg text-muted-foreground hover:text-primary"
                        :class="{ 'bg-muted': route().current('albums.trashed') }"
                    >
                        <span class="w-2 h-2 bg-primary rounded-full"></span>
                        Archived Albums
                    </Link>
                </li>
            </ul>
        </div>
    </nav>
</template>
