<script setup lang="ts">
import "vue-sonner/style.css";
import { Toaster } from "@/components/ui/sonner";
</script>
<template>
  <div class="bg-gray-600 min-h-screen">
    <div class="w-full bg-gray-700 h-24 flex justify-around">
      <a href="/" class="text-2xs text-white p-4 font-roboto uppercase my-auto">Explore Products</a>
      <a href="/account" class="text-2xs text-white p-4 font-roboto uppercase my-auto">My Account</a>
    </div>
    <div class="max-w-5xl mx-auto px-4 py-8">
      <NuxtPage />
    </div>
    <Toaster position="top-center" />
  </div>
</template>
