<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\CategoryType;
    use App\Models\Like;
    use Illuminate\Http\Request;

    class LikeController extends Controller
    {

        /**
         *  Like toggle
         * 
         * @param Request $request
         * @param int $product_type
         * @param int $product_id
         * @return bool
         */
        public function toggle(Request $request, $product_type, $product_id)
        {
            $like = Like::findLiked($request->user()->id, $product_type, $product_id);
            if (!$like) {
                Like::fillAndStore($request->user()->id, $product_type, $product_id);
                return response()->json(true);
            } else {
                $like->delete();
                return response()->json(false);
            }
        }

    }