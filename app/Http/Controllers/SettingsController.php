<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\Settings\Authors\Save;
    use App\Http\Requests\Settings\AuthorsSave;
    use App\Http\Requests\Settings\ProfileSave;
    use App\Models\Gallery;
    use App\Models\Users\Author;
    use App\Models\Users\User;
    use Auth;
    use File;
    use Hash;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Mail;

    class SettingsController extends Controller
    {
        /**
         * Main settings page
         * redirect to Profile settings
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function settingsMain()
        {
            return redirect(route('settings.profile'));
        }

        /**
         * Settings page with profile parameters
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function settingsProfile()
        {
            $user = Auth::user();
            if ($user->role == 3) {
                return redirect(route('settings.gallery'));
            }
            return view('web.pages.settings.profile', compact('user'));
        }

        /**
         * Function for save profile params
         * redirect to back
         *
         * @param \App\Http\Requests\Settings\ProfileSave $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function settingsProfileSave(ProfileSave $request)
        {
            $inputs = $request->only('name', 'surname', 'pseudonym', 'nickname', 'country', 'description', 'contact_email', 'contact_phone');
            $user = $request->user();
            $avatar = static::saveAvatar($request, $user->avatar);
            if ($avatar) {
                $inputs['avatar'] = $avatar;
            }
            $user->fill($inputs);
            $user->save();

            session(['dialog-box' => 'gallery_update']);
            return redirect(route('profile.page', $user));
        }

        /**
         * Deleting old user avatar
         *
         * @param $directory
         * @param $avatar
         */
        private static function deleteOldAvatar($directory, $avatar)
        {
            if (!$avatar) {
                return;
            }
            $filePath = public_path() . $directory . $avatar;
            if (File::exists($filePath)) {
                unlink($filePath);
            }

        }

        /**
         * Save new avatar from base64
         *
         * @param $request
         * @param $oldAvatar
         *
         * @return null|string
         */
        public static function saveAvatar($request, $oldAvatar)
        {
            $avatar = null;
            if (isset($request->avatar_base64) && $request->avatar_base64) {
                $directory = '/web/images/avatars/';
                $avatar = static::saveBase64File($request->avatar_base64, $directory);
                static::deleteOldAvatar($directory, $oldAvatar);
            }
            return $avatar;
        }

        public static function saveGalleryBg($request, $oldAvatar)
        {
            $avatar = null;
            if (isset($request->gallery_bg_base64) && $request->gallery_bg_base64) {
                $directory = '/web/images/galleries/';
                $avatar = static::saveBase64File($request->gallery_bg_base64, $directory);
                static::deleteOldAvatar($directory, $oldAvatar);
            }
            return $avatar;
        }

        /**
         * Save base64 image
         *
         * @param $base64
         * @param $directory
         * @return string filename
         */
        public static function saveBase64File($base64, $directory)
        {
            $path = public_path() . $directory;
            static::checkExistPath($path);
            $filename = md5(time() . uniqid()) . ".jpg";
            $filePath = $path . $filename;
            static::base64ToJpeg($base64, $filePath);
            return $filename;

        }

        /**
         * Check exist path otherwise create this directory with 0777
         *
         * @param $path
         */
        public static function checkExistPath($path)
        {
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true);
            }
        }

        /**
         * Convert base64 code to JPEG image file
         *
         * @param $base64
         * @param $file
         * @return mixed
         */
        private static function base64ToJpeg($base64, $file)
        {
            $ifp = fopen($file, "wb");
            $data = explode(',', $base64);
            fwrite($ifp, base64_decode($data[1]));
            fclose($ifp);
            return $file;
        }

        /**
         * Settings page with items list
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function settingsItems()
        {
            if (Auth::user()->gallery_profile) {
                $items = Auth::user()->gallery_profile->items;
            } else {
                $items = Auth::user()->items;
            }
            return view('web.pages.settings.items', compact('items'));
        }

        /**
         * Settings page address params
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function settingsAddress()
        {
            $user = Auth::user();
            return view('web.pages.settings.address', compact('user'));
        }

        /**
         * Save address params
         *
         * @param Request $request
         */
        public function settingsAddressSave(Request $request)
        {
            $this->validatorUserAddress($request->all())->validate();
            $inputs = $request->only('country', 'city', 'street', 'house_number', 'apartment_number', 'index', 'phone', 'note');
            $user = Auth::user();
            $user->fill($inputs);
            $user->save();
            return redirect(route('settings.address') . '#saved');


        }

        /**
         * Get a validator for an incoming User address data
         *
         * @param  array $data
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validatorUserAddress(array $data)
        {
            return Validator::make($data, [
                'country' => 'required|filled|string|max:255',
                'phone'   => 'required|filled|string|max:255',
            ]);
        }

        /**
         * Settings page with login params (email/password)
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function settingsAuth()
        {
            $user = Auth::user();
            return view('web.pages.settings.auth', compact('user'));
        }

        /**
         * Save auth params (login/password)
         *
         * @param Request $request
         */
        public function settingsAuthSave(Request $request)
        {
            $errorsEmail = $this->updateUserEmail($request->email);
            $errorsPassword = $this->updateUserPassword($request);
            $errors = array_merge($errorsEmail, $errorsPassword);
            if (count($errors)) {
                return redirect()->back()->with(["errors" => (object)$errors])->withInput();
            }
            return redirect(route('settings.auth') . '#saved');
        }

        /**
         * Check new email and update it
         *
         * @param $email
         * @return array with errors
         */
        private function updateUserEmail($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['email' => 'Введите корректный адрес почты'];
            }
            $user = Auth::user();
            $checkEmail = User::where('email', $email)->first();
            if ($checkEmail && $checkEmail->id != $user->id) {
                return ['email' => 'Почта уже используется другим пользователем'];
            }
            if (!$checkEmail) {

                Mail::send('web.emails.changed-email', ['email' => $email], function ($message) use ($user) {
                    $message->to($user->email)->subject('Изменен почтовый адрес.');
                });
                Mail::send('web.emails.changed-new-email', [], function ($message) use ($email) {
                    $message->to($email)->subject('Изменен почтовый адрес.');
                });
                if ($user->temp_email) {
                    $user->temp_email = 0;
                }
                $user->email = $email;
                $user->save();
            }

            return [];
        }

        /**
         * Check password and update it
         *
         * @param $request - with old and new passwords
         * @return array with errors
         */
        private function updateUserPassword($request)
        {
            if (!$request->old_password && !$request->new_password && !$request->confirm_password) {
                return [];
            }

            $user = Auth::user();
            if (!$this->validOldPassword($user, $request)) {
                return ['old_password' => 'Введен неправильный старый пароль'];
            }

            if (!$this->validNewPasswords($request)) {
                return ['new_password' => 'Новый пароль не совпадает'];
            }

            if ($user->no_password) {
                $user->no_password = 0;
            }

            $user->password = Hash::make($request->new_password);
            $user->save();


            Mail::send('web.emails.changed-password', [], function ($message) use ($user) {
                $message->to($user->email)->subject('Изменен пароль.');
            });

            return [];
        }

        /**
         * Validate old user password
         *
         * @param $user
         * @param $request
         * @return bool
         */
        private function validOldPassword($user, $request)
        {
            return $user->no_password || Hash::check($request->old_password, $user->password);
        }

        /**
         * Compare new password
         *
         * @param $request
         * @return bool
         */
        private function validNewPasswords($request)
        {
            return $request->new_password != '' && $request->new_password == $request->confirm_password;
        }

        /**
         * Settings page with finance params
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function settingsFinance()
        {
            return view('web.pages.settings.finance');
        }

        /**
         * Show user finance page
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function userFinance()
        {
            $commissions = Auth::user()->commissions;

            return view('web.pages.settings.userFinance', compact('commissions'));
        }

        public function settingsGallery()
        {
            $user = Auth::user();

            $gallery = $user->gallery_profile;

            return view('web.pages.settings.edit-gallery', compact('user', 'gallery'));
        }

        public function settingsAuthors()
        {
            //34
            $user = Auth::user();

            $authors = $user->gallery_profile->authors;



            return view('web.pages.settings.authors', compact('user', 'authors'));
        }

        public function settingsGallerySave(Request $request)
        {
            $user = Auth::user();
            $gallery = $user->gallery_profile;
            $gallery->fill($request->all());
            $gallery->save();
            return redirect(route('settings.gallery') . '#saved');
        }


        protected function validatorGalleryData(array $data)
        {
            return Validator::make($data, [
                'name'    => 'required|filled|string|max:255',
                'address' => 'required|filled|string|max:255',
            ]);
        }

        public function addNewAuthor()
        {
            $author = new User();
            return view('web.pages.settings.authors-add', compact('author'));
        }

        /**
         * @param \App\Http\Requests\Settings\AuthorsSave $request
         * @param null $id
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function saveAuthor(AuthorsSave $request, $id = null)
        {
            if ($id) {
                $author = User::find($id);
                if (!$author) {
                    return redirect(route('settings.authors'));
                }
            } else {
                $author = new User();
                $author->email = md5(time()) . '@gmail.com';
                $author->gallery_id = Auth::user()->gallery_profile->id;
            }

            $author->fill($request->all());

            $avatar = $this->saveAvatar($request, $author->avatar);

            if ($avatar) {
                $author->avatar = $avatar;
            }

            $author->save();

            return redirect(route('settings.authors'));
        }

        /**
         * Validate user data
         *
         * @param array $data
         * @return mixed
         */
        protected function validatorAuthorData(array $data)
        {
            return Validator::make($data, [
                'name'    => 'required|filled|string|max:255',
                'surname' => 'required|filled|string|max:255',
                'country' => 'required|filled|string|max:255',
            ]);
        }

        public function editAuthor($id)
        {
            $author = User::find($id);
            if (!$author) {
                return redirect(route('settings.authors'));
            }

            return view('web.pages.settings.authors-add', compact('author'));
        }

        public function deleteAuthor($id)
        {

            $author = Author::find($id);
            $galleryUser = Auth::user();

            if (!$author || $galleryUser->gallery_profile->id != $author->gallery_id) {
                return redirect(route('settings.authors'));
            }

            $author->delete();

            return response()->json('1');
        }

    }
