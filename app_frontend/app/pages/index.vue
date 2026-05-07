<template>
  <div>
    <h1 class="text-2xs">
      Welcome to the Workout Planner App!
    </h1>
  </div>
</template>
<script setup>
console.log("Welcome page loaded");
const config = useRuntimeConfig();
const testfunction = async () => {
  try {
    const { data } = await useFetch(`${config.public.apiBase}/test`);
    console.log("route:" + config.public.apiBase);
    console.log("API response:", data.value);
  } catch (error) {
    console.error("Error fetching API:", error);
  }
};

testfunction();
</script>
