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
      amount: string;
    };
    maxVariantPrice: {
      amount: string;
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
