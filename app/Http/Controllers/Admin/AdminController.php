<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\Order;
use App\Models\Products\Thing;
use App\Models\Products\Picture;
use App\Models\Products\Poster;
use App\Models\Settings;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function authUser($user_id)
    {
        $user = User::findOrFail($user_id);
        Auth::login($user);
        return redirect('/');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('admin.dashboard'));
    }

    public function toggleTop($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->top = !$user->top;
        $user->save();

        return redirect()->to($request->header('referer') . '#' . $user->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dashboard()
    {
        return view('web.admin.dashboard');
    }

    public function blank()
    {
        return view('web.admin.blank');
    }

    public function orders()
    {
        $orders = Order::all();
        return view('web.admin.orders.index',compact('orders'));
    }

    public function usersCommon()
    {
        $users = User::where('role',1)->orderBy('id','desc')->get();
        return view('web.admin.users.common', compact('users'));
    }

    public function usersArtist()
    {
        $users = User::where('role',2)->orderBy('id','desc')->get();
        return view('web.admin.users.artist', compact('users'));
    }

    public function usersAll()
    {
        $users = User::orderBy('id','desc')->get();
        return view('web.admin.users.all', compact('users'));
    }

    public function usersNew()
    {
        $users = [];
        return view('web.admin.users.new', compact('users'));
    }

    public function usersActive()
    {
        $users = [];
        return view('web.admin.users.active', compact('users'));
    }

    public function usersBlocked()
    {
        $users = [];
        return view('web.admin.users.blocked', compact('users'));
    }

    public function itemsPosters($status = null)
    {
        $items = Poster::all();
        return view('web.admin.items.posters', compact('items'));
    }

    public function itemsPictures()
    {
        $items = Picture::all();
        return view('web.admin.items.pictures', compact('items'));
    }

    public function itemsObjects()
    {
        $items = Thing::all();
        return view('web.admin.items.objects', compact('items'));
    }

    public function itemsModerate()
    {
        return view('web.admin.items.moderate');
    }

    public function itemsFavorite()
    {
        return view('web.admin.items.favorite');
    }

    public function itemsAccepted($type = 'posters')
    {
        $items = [];
        switch ($type){
            case 'posters':
                $items = Poster::all();
                break;
            case 'pictures':
                $items = Picture::all();
                break;
            case 'objects':
                $items = Thing::all();
                break;
        }

        return view('web.admin.items.accepted', compact('items','type'));
    }

    public function itemsRejected()
    {
        return view('web.admin.items.rejected');
    }

    public function showFinanceSettings()
    {
        $settings = Settings::all();
        return view('web.admin.settings.edit',compact('settings'));
    }

    public function updateFinanceSettings(Request $request) {
        foreach ($request->except('_token') as $key => $value) {
            $setting = Settings::whereName($key)->first();
            $setting = $setting ? $setting : new Settings();
            $setting->name = $key;
            $setting->value = $value;
            $setting->save();
        }
        return redirect()->back();
    }
}
