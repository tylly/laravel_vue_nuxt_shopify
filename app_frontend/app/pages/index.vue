<script setup lang="ts">
import ProductCard from "~/components/ProductCard.vue";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
import type { ShopifyProductsResponse, Product } from "@/types/shopify";

const config = useRuntimeConfig();
const { isAuthenticated, user } = useSanctumAuth();
const { data } = await useFetch<ShopifyProductsResponse>(`${config.public.apiBase}/api/get-products`);
console.log(isAuthenticated.value);
const products = computed<Product[]>(() => data.value?.data?.products?.edges?.map((edge) => edge.node) ?? []);
</script>
<template>
  <div class="text-center flex flex-col justify-center">
    <h1 class="text-4xl font-saira uppercase mb-20 text-gray-200">Shopify Store Wishlist</h1>
    <Carousel
      class="relative w-full mx-auto"
      :opts="{
        align: 'start',
      }">
      <CarouselContent>
        <CarouselItem v-for="product in products" :key="product.id" class="md:basis-1/2 lg:basis-1/3 w-full">
          <div class="p-1">
            <ProductCard :product="product" :isWishlist="false" />
          </div>
        </CarouselItem>
      </CarouselContent>
      <CarouselPrevious />
      <CarouselNext />
    </Carousel>
  </div>
</template>
