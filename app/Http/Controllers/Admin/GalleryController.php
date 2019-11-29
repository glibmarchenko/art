<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\Gallery;
    use Illuminate\Http\Request;

    class GalleryController extends Controller
    {
        public function showNew()
        {
            $galleries = Gallery::whereViewed(false)->get();

            return view('web.admin.users.gallery', compact('galleries'));
        }

        public function showAccepted()
        {
            $galleries = Gallery::whereViewed(true)->active()->get();

            return view('web.admin.users.gallery', compact('galleries'));
        }

        public function showRejected()
        {
            $galleries = Gallery::notActive()->get();

            return view('web.admin.users.gallery', compact('galleries'));
        }

        public function showTop()
        {
            $galleries = Gallery::whereTop(true)->get();

            return view('web.admin.users.gallery', compact('galleries'));
        }

        public function index()
        {
            $galleries = Gallery::all();

            return view('web.admin.users.gallery', compact('galleries'));
        }

        public function toggleRejected($id, Request $request)
        {
            $gallery = Gallery::findOrFail($id);
            $gallery->is_active = ! $gallery->is_active;
            $gallery->viewed = 1;
            $gallery->save();

            return redirect()->to($request->header('referer') . '#' . $gallery->id);
        }

        public function toggleViewed($id, Request $request)
        {
            $gallery = Gallery::findOrFail($id);
            $gallery->viewed = !$gallery->viewed;
            $gallery->save();

            return redirect()->to($request->header('referer') . '#' . $gallery->id);
        }

        public function toggleTop($id, Request $request)
        {
            $gallery = Gallery::findOrFail($id);
            $gallery->viewed = 1;
            $gallery->is_active = 1;
            $gallery->top = !$gallery->top;
            $gallery->save();

            return redirect()->to($request->header('referer') . '#' . $gallery->id);
        }
    }