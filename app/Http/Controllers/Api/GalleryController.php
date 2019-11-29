<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SettingsController;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function update($id, Request $request)
    {
        /** @var \App\Models\Users\User $user */
        $user = $request->user();
        $gallery = $user->gallery_profile;
        if($gallery === null) {
          // TODO: Переделать. Что это? на вход ID, но мы берем галерею текущего юзера
          abort(500);
        }

        $gallery->fill($request->all());
        $gallery->save();

        // TODO: добавить проверку, если новое фото такое же, как и существующее: skip. Или переделать
        if ($request->get('gallery_bg_base64')) {
          $gallery->bg = SettingsController::saveGalleryBg($request, $gallery->bg);
          $gallery->save();
        }

        if ($request->get('avatar_base64')) {
          $avatar = SettingsController::saveAvatar($request, $user->avatar);
          if ($avatar) {
            $user->avatar = $avatar;
            $user->save();
          }
        }

        return $gallery;
    }
}
