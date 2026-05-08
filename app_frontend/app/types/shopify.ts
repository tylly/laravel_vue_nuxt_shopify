export interface Product {
  id: string;
  title: string;
  featuredMedia: {
    preview: {
      image: {
        url: string;
      };
    };
  };
  priceRangeV2: {
    minVariantPrice: {
      amount: Number;
    };
    maxVariantPrice: {
      amount: Number;
    };
  };
}

export interface ShopifyProductsResponse {
  data: {
    products: {
      edges: {
        node: Product;
      }[];
    };
  };
}
