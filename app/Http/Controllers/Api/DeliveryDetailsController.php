<?php

    namespace App\Http\Controllers\Api;

    use App\Lib\NovaPoshta;
    use App\Models\DeliveryDetail;
    use App\Http\Controllers\Controller;
    use App\Models\CategoryType;
    use Illuminate\Http\Request;
    
    class DeliveryDetailsController extends Controller
    {
        public function index(Request $request)
        {
            return $request->user()->deliveryDetails;
        }

        public function store(Request $request)
        {
            $deliveryDetail = DeliveryDetail::findOrCreate($request->user()->id);
            $deliveryDetail->fill($request->all());
            $deliveryDetail->user_id = $request->user()->id;
            $deliveryDetail->save();
            return $deliveryDetail;
        }
        
        
    }