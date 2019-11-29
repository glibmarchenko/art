<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    /**
     * Set application locale
     *
     * @param $lang
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocale($lang, Request $request)
    {
        $user = $request->user();
        if (array_key_exists($lang, config('app.languages'))) {
            session(['locale' => $lang]);
            \Cookie::queue('locale', $lang);
            //if ($user) {
            //    $user->locale = $lang;
            //    $user->disableLogging();
            //    $user->save();
            //}
        }

        if ($request->wantsJson()) {
            //$strings = $this->prepareLocalization($lang);

            return response()->json();
        }

        if($request->route()->name === 'lang'){
            return redirect('/');
        }

        return redirect()->back();
    }
}
