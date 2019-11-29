<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Products\Product;
    use Illuminate\Http\Request;

    class PrintController extends Controller
    {
        public function getFilteredResults($product_type)
        {
            $items = [];

            $request = request();

            $path = $request->all();

            $items = Product::where('type', $product_type)->where('for_sale', 1)
                ->availableForCatalog()
                ->with('author')
                ->when($this->hasValue($request->style), function ($q) use ($request) {
                    $q->whereHas('categories', function ($q) use ($request) {
                        $q->where('alias', $request->style['alias']);
                    });
                })
                ->when($this->hasValue($request->material), function ($q) use ($request) {
                    $q->whereHas('materials', function ($q) use ($request) {
                        $q->where('alias', $request->material['alias']);
                    });
                })
                ->when($this->hasValue($request->orientation), function ($q) use ($request) {
                    if ($request->orientation['value'] == 'gorizontalno') {
                        $q->landscape();
                    } else if ($request->orientation['value'] == 'vertikalno') {
                        $q->portrait();
                    } else if ($request->orientation['value'] == 'kvadrat') {
                        $q->square();
                    }
                })
                ->when($this->hasValue($request->size), function ($q) use ($request) {

                })
                ->when($this->hasValue($request->price), function ($q) use ($request) {
                    $price = explode('-', $request->price['value']);
                    $price_from = $price[0];
                    $price_to = $price[1];
                    $q->where('final_price', '>=', $price_from)->where('final_price', '<=', $price_to);
                })
//                ->when($this->hasValue($request->favorite), function ($q) use ($request) {
//                    $q->where('favorite', 1);
//                })
                ->paginate(40);

//            if ($this->hasValue($request->size)) {
//                foreach ($items as $k => $i) {
//                    if ($request->size['value'] == 's') {
//                        if ($i->width <= 500 || $i->height <= 500) {
//                        } else
//                            unset($items[$k]);
//                    } else if ($request->size['value'] == 'm') {
//                        if (($i->width > 500 && $i->width <= 950) || ($i->height > 500 && $i->height <= 950)) {
//                        } else
//                            unset($items[$k]);
//                    } else if ($request->size['value'] == 'l') {
//                        if (($i->width > 950 && $i->width <= 1500) || ($i->height > 950 && $i->height <= 1500)) {
//                        } else
//                            unset($items[$k]);
//                    } else if ($request->size['value'] == 'xl') {
//                        if ($i->width > 1500 || $i->height > 1500) {
//                        } else
//                            unset($items[$k]);
//                    }
//                }
//            }


            return $items;
        }


        private function filterByPrice($items, $price)
        {
            $price = explode('-', $price);
            $price_from = $price[0];
            $price_to = $price[1];
            return $items->where('final_price', '>=', $price_from)->where('final_price', '<=', $price_to);
        }


        private function hasValue($value)
        {
            if (is_array($value)) {
                if ($value['value'] != null && $value['value'] != 999) {
                    return true;
                }
            }
            return false;
        }

    }
