<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\Products\Poster;
    use Illuminate\Http\Request;

    class PosterController extends Controller
    {
        public function getPostersIndex()
        {
            $items = Poster::all();
            return view('web.admin.items.posters', compact('items'));
        }

        public function getPostersNew()
        {
            $items = Poster::whereViewed(false)->get();

            return view('web.admin.items.posters', compact('items'));
        }

        public function getPostersFavorite()
        {
            $items = Poster::whereFavorite(true)->get();

            return view('web.admin.items.posters', compact('items'));
        }

        public function getPostersRejected()
        {
            $items = Poster::notActive()->get();

            return view('web.admin.items.posters', compact('items'));
        }

        public function toggleFavorite($id,Request $request)
        {
            $poster = Poster::findOrFail($id);
            $poster->favorite = !$poster->favorite;
            $poster->viewed = 1;
            $poster->save();

            return redirect()->to($request->header('referer'). '#'.$poster->id);
        }

        public function toggleRejected($id, Request $request)
        {
            $poster = Poster::findOrFail($id);
            $poster->is_active = ! $poster->is_active;
            $poster->viewed = 1;
            $poster->save();

            return redirect()->to($request->header('referer'). '#'.$poster->id);
        }

        public function toggleViewed($id, Request $request)
        {
            $poster = Poster::findOrFail($id);
            $poster->viewed = !$poster->viewed;
            $poster->save();

            return redirect()->to($request->header('referer'). '#'.$poster->id);
        }
    }
