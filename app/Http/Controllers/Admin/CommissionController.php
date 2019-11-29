<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\Commission;
    use App\Models\Products\Product;
    use App\Models\Users\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Carbon\Carbon;

    class CommissionController extends Controller
    {

        public function index()
        {
            $commissions = Commission::all();
            return view('web.admin.commissions.index', compact('commissions'));
        }

        public function approve(Commission $commission)
        {
            $commission->pending_start_at = Carbon::now();

            if ($commission->amount !== request()->amount) {
                $commission->manual = 1;
            }
            
            $commission->amount = request()->amount;

            $commission->save();

            return redirect()->back();
        }

        public function accrued()
        {
            $commissions = Commission::awaitConfirmation()->get();
            return view('web.admin.commissions.index', compact('commissions'));
        }

        public function pending()
        {
            $commissions = Commission::pending()->get();
            return view('web.admin.commissions.index', compact('commissions'));
        }

        public function ready()
        {
            $commissions = Commission::pendingOver()->get();
            return view('web.admin.commissions.index', compact('commissions'));
        }

        public function archive()
        {

        }
    }
