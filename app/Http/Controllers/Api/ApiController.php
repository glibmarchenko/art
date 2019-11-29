<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\CategoryType;
    use App\Models\Material;
    use App\Models\Settings;
    use App\Models\Tag;
    use Illuminate\Http\Request;

    class ApiController extends Controller
    {

        public function getDeliverySettings()
        {
            $settings = Settings::whereType('Доставка')->pluck('value','name');
            return $settings;
        }

        public function getCategories()
        {
            return CategoryType::pluckNames();
        }

        public function getCategoriesForProductType($product_type_id)
        {
            return CategoryType::pluckNames($product_type_id);
        }

        public function getMaterialsForProductType($product_type_id)
        {
            return Material::select('id as value', 'name as name', 'alias as alias')
                ->where('product_type_id', $product_type_id)
                ->get();
        }

        public function getActiveCategories()
        {
            return CategoryType::whereActive(1)->orderBy('alias')->get();
        }

        public function getActiveCategoriesByType($type)
        {
            return CategoryType::whereActive(1)->whereType($type)->orderBy('alias')->get();
        }


        public function getTags()
        {
            return Tag::getListedTagsByName();
        }

        public function getMaterials($product_type)
        {
            return Material::where('product_type_id', $product_type)->orWhere('type', 2)->get();
        }

        public function getGalleryAuthors(Request $request)
        {
            return $request->user()->gallery_profile->authors;
        }
    }
