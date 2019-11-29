<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\PosterStoreRequest;
    use App\Models\Products\Poster;
    use App\Models\Products\Product;
    use Illuminate\Http\Request;
    use Auth;
    use Response;
    use App\Models\CategoryType;

    class ProductController extends Controller
    {
        
        public function edit($id)
        {
            $product = Product::findOrFail($id);
        
            $type = $product->type;
            
            if($type === 1) {
                $title = 'Редактирование принта';
            }
            if($type === 2) {
                $title = 'Редактирование картины';
            }
            if($type === 3) {
                $title = 'Редактирование предмета';
            }
            return view('web.pages.products.create', compact('title','type','product'));
        }

        public function delete($id, Request $request)
        {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('settings.items');
        }

        /**
         * Display product page
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function productShow($id)
        {
            $product = Product::findOrFail($id);
            $metatags = $product->metatags;
            return view('web.pages.products.show', compact('product','metatags'));
        }
        
    }