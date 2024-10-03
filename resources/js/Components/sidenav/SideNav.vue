<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import SideNavContent from "./SideNavContent.vue";
import { ScrollArea } from '@/Components/ui/scroll-area';
</script>

<template>
  <div class="hidden bg-white shadow-lg md:block">
    <div class="flex flex-col h-full max-h-screen gap-2">
      <div class="flex h-14 items-center px-4 lg:h-[60px] lg:px-6">
        <a href="/" class="flex items-center gap-2 font-semibold">
          <span>Acme Inc</span>
        </a>
      </div>
      <div class="flex-1 overflow-hidden">
        <ScrollArea class="h-full max-h-[calc(100vh-60px-16px)]">
          <SideNavContent />
        </ScrollArea>
      </div>
    </div>
  </div>
</template>
