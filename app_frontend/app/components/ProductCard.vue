<script setup lang="ts">
import type { Product } from "@/types/shopify";
import { Card, CardContent } from "@/components/ui/card";
import { toast } from "vue-sonner";
const props = defineProps<{
  product: Product;
  isWishlist: Boolean;
}>();
const { isAuthenticated } = useSanctumAuth();

const saveToWishlist = async () => {
  try {
    await useSanctumFetch("/api/wishlist", {
      method: "POST",
      body: {
        product_id: props.product.id,
      },
    });
    toast.success(`${props.product.title} was added to your wishlist!`);
  } catch (error) {
    console.error("Failed to save to wishlist:", error);
     toast.error(`${props.product.title} could not be added to your wishlist!`);
  }
};

const deleteFromWishlist = async () => {
  try {
    await useSanctumFetch("/api/wishlist", {
      method: "DELETE",
      body: {
        product_id: props.product.id,
      },
    });
    window.location.reload();
  } catch (error) {
    console.error("Failed to save to wishlist:", error);
  }
};
</script>
<template>
  <Card class="bg-black/40 shadow-xl border-0 w-64 h-84">
    <CardContent class="flex flex-col items-center justify-center p-6 w-full h-full">
      <img v-if="product.featuredMedia?.preview?.image?.url" :src="product.featuredMedia.preview.image.url" :alt="product.title" class="h-40 mb-2 rounded-2xl" />
      <span class="text-gray-200 font-saira uppercase text-sm text-center h-10 flex items-center justify-center">{{ product.title }}</span>
      <span
        v-if="product.priceRangeV2.minVariantPrice.amount === product.priceRangeV2.maxVariantPrice.amount"
        class="text-emerald-500 font-saira uppercase text-md text-center h-6 flex items-center justify-center mt-4">
        ${{ parseFloat(product.priceRangeV2.minVariantPrice.amount).toFixed(2) }}
      </span>
      <span v-else class="text-emerald-500 font-saira uppercase text-md text-center h-6 flex items-center justify-center mt-4">
        ${{ parseFloat(product.priceRangeV2.minVariantPrice.amount).toFixed(2) }} - ${{ parseFloat(product.priceRangeV2.maxVariantPrice.amount).toFixed(2) }}
      </span>
      <Button
        @click="saveToWishlist"
        v-if="isAuthenticated && !isWishlist"
        variant="outline"
        class="text-gray-200 font-saira uppercase text-md text-center mt-4 w-full bg-gray-500 hover:bg-emerald-500"
        >SAVE</Button
      >
      <Button @click="deleteFromWishlist" v-if="isAuthenticated && isWishlist" variant="outline" class="text-gray-200 font-saira uppercase text-md text-center mt-4 w-full bg-red-800 hover:bg-red-500"
        >DELETE</Button
      >
    </CardContent>
  </Card>
</template>
