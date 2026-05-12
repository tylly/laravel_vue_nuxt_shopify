<script setup lang="ts">
definePageMeta({
  middleware: ["sanctum:auth"],
});
</script>
<template>
  <h1>Accounts page</h1>
</template>
