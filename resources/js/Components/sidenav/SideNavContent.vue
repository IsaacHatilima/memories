<script setup lang="ts">
import { ArrowRight, Home, LineChart, Package, ShoppingCart, Users } from "lucide-vue-next";
import { Badge } from "@/Components/ui/badge";
import { Link } from "@inertiajs/vue3";
import { ref, watchEffect } from "vue";

// Reactive state for open dropdown
const openDropdown = ref<string | null>(null);

// Dropdown-to-route map
const dropdownRoutesMap: Record<string, string[]> = {
  profile: ['profile.edit'], // Using 'profile.edit' as per your route
};

// Function to toggle dropdowns manually
const toggleDropdown = (dropdownName: string) => {
  // Toggle dropdown state manually
  openDropdown.value = openDropdown.value === dropdownName ? null : dropdownName;
};

// Watch for route changes and open the relevant dropdown automatically
watchEffect(() => {
  // Iterate over the routes map and open dropdown if route matches
  for (const [dropdown, routes] of Object.entries(dropdownRoutesMap)) {
    if (routes.some(routeName => route().current(routeName))) {
      openDropdown.value = dropdown;
      return; // Exit the loop when a match is found
    }
  }

  // If no route matches, close the dropdown
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

    <!-- Orders with Badge -->
    <a
      href="#"
      class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg text-muted-foreground hover:text-primary"
    >
      <ShoppingCart class="w-4 h-4" />
      Orders
      <Badge class="flex items-center justify-center w-6 h-6 ml-auto rounded-full shrink-0">
        6
      </Badge>
    </a>

    <!-- Profile Dropdown -->
    <div>
        <a
            href="#"
            @click="toggleDropdown('profile')"
            class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg text-muted-foreground hover:text-primary"
            :class="{ 'bg-muted': openDropdown === 'profile' }"
        >
        <Users class="w-4 h-4" />
        Profile
        <ArrowRight
          class="ml-auto transition-transform"
          :class="{ 'rotate-90': openDropdown === 'profile' }"
        />
      </a>

      <!-- Dropdown content -->
      <ul v-if="openDropdown === 'profile'" class="ml-6 space-y-1">
        <li>
            <Link
                :href="route('profile.edit')"
                class="flex items-center gap-2 px-3 py-1 transition-all rounded-lg text-muted-foreground hover:text-primary"
                :class="{ 'underline': route().current('profile.edit') }">
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                Edit Profile
            </Link>
        </li>
        <li>
            <Link
                :href="route('dashboard')"
                class="flex items-center gap-2 px-3 py-1 transition-all rounded-lg text-muted-foreground hover:text-primary"
                :class="{ 'bg-muted': route().current('dashboard') }"
                >
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                Dashboard
            </Link>
        </li>
      </ul>
    </div>

    <!-- Analytics Link -->
    <a
      href="#"
      class="flex items-center gap-3 px-3 py-2 transition-all rounded-lg text-muted-foreground hover:text-primary"
    >
        <LineChart class="w-4 h-4" />
        Analytics
    </a>
  </nav>
</template>
