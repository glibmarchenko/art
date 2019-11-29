<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Product\Save;
    use App\Models\Products\Product;
    use Illuminate\Http\Request;

    class ProductController extends Controller
    {
        /**
         * @param \App\Http\Requests\Product\Save $request
         *
         * @return \App\Models\Products\Product
         */
        public function store(Save $request)
        {
            $poster = new Product();
            $poster->fillAndStore($request);
            return $poster;
        }

        /**
         * @param \App\Models\Products\Product    $product
         * @param \App\Http\Requests\Product\Save $request
         *
         * @return \App\Models\Products\Product
         */
        public function update(Product $product, Save $request)
        {
            $product->fillAndStore($request);
            return $product;
        }

        /**
         * Delete Product
         *
         * @param \App\Models\Products\Product $product
         */
        public function delete(Product $product)
        {
            $product->delete();
        }

    }
