<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users\Artist;
use App\Models\Users\Author;
use App\Models\Users\User;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function toggleViewed($id)
    {
        $user = User::findOrFail($id);
        $user->viewed = ! $user->viewed;
        $user->save();

        return redirect()->back();
    }

    public function toggleRejected($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = ! $user->is_active;
        $user->save();

        return redirect()->back();
    }

    public function showNew()
    {
        $users = Author::whereRole(2)->whereViewed(false)->get();

        return view('web.admin.users.artist', compact('users'));
    }

    public function showAccepted()
    {
        $users = Author::whereRole(2)->whereViewed(true)->get();

        return view('web.admin.users.artist', compact('users'));
    }

    public function showRejected()
    {
        $users = Author::whereRole(2)->whereViewed(false)->get();

        return view('web.admin.users.artist', compact('users'));
    }

    public function showTop()
    {
        $users = Author::whereRole(2)->orWhereNotNull('gallery_id')->get()->where('top',true);

        return view('web.admin.users.artist', compact('users'));
    }

    public function index()
    {
        $users = Author::whereRole(2)->orWhereNotNull('gallery_id')->get();

        return view('web.admin.users.artist', compact('users'));
    }

    public function showDeleted()
    {
        $users = Author::onlyTrashed()->get();

        return view('web.admin.users.artist', compact('users'));
    }

    public function showGalleryMembers()
    {
        $users = Author::whereNotNull('gallery_id')->get();

        return view('web.admin.users.artist', compact('users'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Users\User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, User $user)
    {
        /** @var \App\Models\Users\User $admin */
        $admin = $request->user();

        if ($user->gallery_profile) {
            $user->gallery_profile()->delete();
        }

        if ($admin->id !== $user->id && ! $user->trashed()) {
            $user->delete();
        }

        if ($user->trashed()) {
            $user->restore();
        }

        return redirect()->back();
    }
}
