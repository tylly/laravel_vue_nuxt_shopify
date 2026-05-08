<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from "@/components/ui/carousel";
import type { ShopifyProductsResponse, Product } from "@/types/shopify";

const config = useRuntimeConfig();
const { isAuthenticated, user } = useSanctumAuth();
const { data } = await useFetch<ShopifyProductsResponse>(`${config.public.apiBase}/api/get-products`);
console.log(data.value);
const products = computed<Product[]>(() => data.value?.data?.products?.edges?.map((edge) => edge.node) ?? []);
</script>
<template>
  <div class="text-center flex flex-col justify-center">
    <h1 class="text-4xl font-roboto mb-20">Shopify Store Wishlist</h1>
    <Carousel
      class="relative w-full mx-auto"
      :opts="{
        align: 'start',
      }">
      <CarouselContent>
        <CarouselItem v-for="product in products" :key="product.id" class="md:basis-1/2 lg:basis-1/3 w-full">
          <div class="p-1">
            <Card class="bg-black/40 shadow-xl border-0 w-64 h-64">
              <CardContent class="flex flex-col items-center justify-center p-6 w-full h-full">
                <img v-if="product.featuredMedia?.preview?.image?.url" :src="product.featuredMedia.preview.image.url" :alt="product.title" class="w-full h-40 object-contain mb-2" />
                <span class="text-white font-saira uppercase text-sm text-center">{{ product.title }}</span>
              </CardContent>
            </Card>
          </div>
        </CarouselItem>
      </CarouselContent>
      <CarouselPrevious />
      <CarouselNext />
    </Carousel>
  </div>
</template>
