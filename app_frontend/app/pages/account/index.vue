<script setup lang="ts">
import type { ShopifyProductsResponse, Product } from "@/types/shopify";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
definePageMeta({
  middleware: ["sanctum:auth"],
});
const config = useRuntimeConfig();
console.log(config.public.apiBase);
const { data } = await useSanctumFetch<ShopifyProductsResponse>(`${config.public.apiBase}/api/wishlist`, {
  credentials: "include",
});
console.log(data.value);
const products = computed<Product[]>(() => data.value?.data?.products?.edges?.map((edge) => edge.node) ?? []);
import ProductCard from "~/components/ProductCard.vue";
</script>
<template>
  <h1>Accounts page</h1>
  <Carousel
    class="relative w-full mx-auto"
    :opts="{
      align: 'start',
    }">
    <div v-if="products.length === 0">
      <p class="text-gray-200 font-saira uppercase">Your wishlist is empty</p>
    </div>
    <CarouselContent>
      <CarouselItem v-for="product in products" :key="product.id" class="md:basis-1/2 lg:basis-1/3 w-full">
        <div class="p-1">
          <ProductCard :product="product" :isWishlist="true" />
        </div>
      </CarouselItem>
    </CarouselContent>
    <CarouselPrevious />
    <CarouselNext />
  </Carousel>
</template>
