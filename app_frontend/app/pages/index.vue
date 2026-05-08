<script setup lang="ts">
import { Button } from "@/components/ui/button";
console.log("Welcome page loaded");
const config = useRuntimeConfig();
const testfunction = async () => {
  try {
    const data = await $fetch(`${config.public.apiBase}/api/get-products`);
    console.log("route:" + config.public.apiBase);
    console.log("API response:", data);
  } catch (error) {
    console.error("Error fetching API:", error);
  }
};
const { isAuthenticated, user } = useSanctumAuth();
console.log(user);
</script>
<template>
  <div>
    <h1 class="text-2xs font-saira mb-20">Welcome to the Workout Planner App!</h1>
    <Button @click="testfunction()" variant="outline">Test</Button>
  </div>
</template>
