<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::whereViewed(1)->whereIsActive(1)->orderBy('id', 'desc')->get();
        return view('web.pages.galleries.index',compact('galleries'));
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        return view('web.pages.galleries.show-new',compact('gallery'));
    }


    public function showAuthorPage($galleryId, $authorId)
    {
        $user = Author::find($authorId);
        if(!$user || $user->gallery->id != $galleryId){
            return redirect()->back();
        }
        $author = true;
        return view('web.pages.author.index',compact('user','author'));
    }
}
