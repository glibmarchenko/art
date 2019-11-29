<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\Attachment;
    use App\Models\Products\Product;
    use Illuminate\Http\Request;

    class AttachmentController extends Controller
    {

        public function store(Request $request)
        {
            $attachment = new Attachment();
            $attachment->fillAndStore($request->image, $request->user()->id);
            return $attachment;
        }

        public function delete($id, Request $request)
        {
            $attachment = Attachment::findOrFail($id);
            $product_id = $attachment->product->id;
            $attachment->delete();
            return Product::findOrFail($product_id)->attachments;
        }

    }