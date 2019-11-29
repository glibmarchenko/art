<?php

    namespace App\Http\Controllers;

    use App\Facades\Decta;
    use App\Http\Helpers;
    use App\Http\Requests\SaveUserDataFromStepOne;
    use App\Models\Color;
    use App\Models\Gallery;
    use App\Models\Like;
    use App\Models\Order;
    use App\Models\Products\Picture;
    use App\Models\Products\Poster;
    use App\Models\Products\Thing;
    use App\Models\Subscription;
    use App\Models\Users\Author;
    use App\Models\Users\User;
    use Auth;
    use File;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Validator;
    use Response;

    class WebController extends Controller
    {
        public function test()
        {
            $x = '3.5secondss';
            settype($x, 'double');
            settype($x, 'integer');
            settype($x, 'string');
            print($x);
        }

        public function activate($token)
        {
            /** @var \App\Models\Users\User $user */
            $user = User::whereToken($token)->where('email_confirmed', 0)->firstOrFail();

            $user->email_confirmed = 1;
            $user->save();

            Auth::login($user);

            return redirect('register-page');
        }

        public function testMail()
        {
            $user = Auth::user();
            Mail::send('web.emails.register', [], function ($message) use ($user) {
                $message->to($user->email)->subject('Успешная регистрация.');
            });
        }

        public function showProfilePage()
        {
            if (Auth::user()->gallery_profile) {
                return redirect()->route('gallery.show', Auth::user()->gallery_profile->id);
            }

            return redirect()->route('profile.page', Auth::id());
        }

        /**
         * Show profile page
         *
         * @param $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function profilePage($id)
        {
            $user = User::find($id);

            /**
             * By default show products only those that are available for Profile lookup
             */
            $products = $user->products()->availableForProfile()->paginate(100);

            /**
             * Authenticated User Can see all the products
             */
            if (request()->user()) {
                if ($user->id === request()->user()->id) {
                    $products = $user->products()->paginate(100);
                }
            }

//            /**
//             * If User Is Gallery User & Checks same gallery author
//             * Can see All products
//             */
//            if (request()->user()) {
//                if (request()->user()->isGalleryUser()) {
//                    if (request()->user()->gallery_profile->authors()->whereId($id)) {
//                        $products = $user->products()->paginate(100);
//                    }
//                }
//            }

            if(request()->wantsJson()) {
                return $products;
            }

            return view('web.pages.author.index', compact('user', 'products'));
        }

        /**
         * Display index page
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index()
        {
            $authorIDs = [23, 24, 34, 27, 29, 31, 32, 33, 37, 38, 39, 40];

            $authors = User::whereIn('id', $authorIDs)->get();

            $products = \App\Models\Products\Product::availableForTop()->latest()->limit(100)->paginate(100)->toJson();

            if(request()->wantsJson()) {
                return $products;
            }

            return view('web.pages.index', compact('authors', 'products'));
        }

        /**
         * Display page with prints
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function prints()
        {
            return view('web.pages.prints.index');
        }

        /**
         * Display page with prints
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function authorPage()
        {
            return view('web.pages.author.index');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function authorIndex()
        {
            /** @var \Illuminate\Support\Collection $authorsIds */
            $authorsIds = Author::approved()->pluck('id');

            /** @var \Illuminate\Support\Collection $galleriesIds */
            $galleriesIds = Gallery::approved()->pluck('id');

            /** @var \Illuminate\Support\Collection $galleryAuthorsIds */
            $galleryAuthorsIds = User::whereIn('gallery_id', $galleriesIds)->pluck('id');

            $authors = User::whereIn('id', $authorsIds->merge($galleryAuthorsIds)->sort())->whereNotNull('avatar')->whereNotNull('nickname')->get();

            return view('web.pages.author.list', compact('authors'));
        }

        /**
         * Register page with change user type
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function registerMain()
        {
            if (Auth::user()->role == 0) {
                return view('web.pages.register.user-type');
            }

            return redirect(route('home'));
        }

        /**
         * Register page with profile params form
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function registerStep1($role = null)
        {
            $role = intval($role);
            if ($role == 1 || $role == 2 || $role == 3) {
                Auth::user()->role = $role;
                Auth::user()->save();
            }

            $user = Auth::user();

            $form_route = 'register.completed';
            if ($role == 3) {
                $form_route = 'register.gallery.post';
            }

            return view('web.pages.register.step-1', compact('user', 'form_route'));
        }

        /**
         * Save user profile data from step 1
         *
         * @param \App\Http\Requests\SaveUserDataFromStepOne $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function saveUserDataFromStep1(SaveUserDataFromStepOne $request)
        {
            $inputs = $request->only(['name', 'surname', 'pseudonym', 'nickname', 'country', 'city']);
            /** @var \App\Models\Users\User $user */
            $user = Auth::user();
            $sendEmail = false;
            if ($user->temp_email) {
                $inputs['temp_email'] = 0;
                $inputs['email'] = $request->email;
                $sendEmail = true;
            }
            $user->fill($inputs);
            $user->save();

            if ($user->role === 1) {
                return redirect(route('settings.profile'));
            }

            return redirect(route('register.step2'));
        }

        public function saveGalleryData(Request $request)
        {
            $this->validateGalleryData($request->all())->validate();
            $inputs = $request->only(['gallery_name']);
            $user = Auth::user();
            $sendEmail = false;
            if ($user->temp_email) {
                $inputs['temp_email'] = 0;
                $inputs['email'] = $request->email;
                $sendEmail = true;
            }

            $user->role = 3;
            $user->name = $request->gallery_name;
            $user->pseudonym = $request->gallery_name;
            $user->fill($inputs);
            $user->save();

            if ($user->role == '3') {
                $gallery = $user->gallery_profile;
                if (!$gallery) {
                    $gallery = new Gallery();
                    $gallery->user_id = $user->id;
                }
                $gallery->name = $request->gallery_name;
                $gallery->country = $request->country;
                $gallery->city = $request->city;
                $gallery->save();
            }

            if ($sendEmail) {
                /* Mail::send('web.emails.register', [], function($message) use ($user){
                     $message->to($user->email)->subject('Успешная регистрация.');
                 });*/
            }

            return redirect(route('settings.gallery'));
        }

        public function validateGalleryData(array $data)
        {
            $rules = [
                'gallery_name' => 'required|string|max:255',
                'country'      => 'required|filled|string|max:255',
                'city'         => 'string|max:255',
            ];
            if (Auth::user()->temp_email) {
                $rules['email'] = 'required|string|email|max:255|unique:users';
            }

            return Validator::make($data, $rules);
        }

        /**
         * Register page with address form
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function registerStep2()
        {
            $user = Auth::user();

            return view('web.pages.register.step-2', compact('user'));
        }

        /**
         * Save user profile data from step 2
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Illuminate\Validation\ValidationException
         */
        public function saveUserDataFromRegister(Request $request)
        {
            if (Auth::user()->role == '1') {
                $this->validatorSimpleUserRegister($request->all())->validate();
                $fields = [
                    'name',
                    'surname',
                    'pseudonym',
                    'nickname',
                    'country',
                    'city',
                ];
            } else {
                $this->validatorUserRegister($request->all())->validate();
                $fields = [
                    'name',
                    'surname',
                    'pseudonym',
                    'nickname',
                    'country',
                    'city',
                    'phone',
                ];
            }
            $inputs = $request->only($fields);
            $user = Auth::user();
            $user->fill($inputs);
            $user->save();

            /*if ($user->registered_from_url && $user->registered_from_url != '' && $user->role == '1') {
                return redirect($user->registered_from_url);
            }*/

            return redirect(route('settings.profile'));
        }

        /**
         * Get a validator for an incoming User profile data on STEP 1.
         *
         * @param  array $data
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validatorUserRegister(array $data)
        {
            return Validator::make($data, [
                'name'      => 'required|filled|string|max:255',
                'surname'   => 'required|filled|string|max:255',
                'pseudonym' => 'required|filled|string|max:255',
                'nickname'  => 'required|filled|string|max:255',
                'country'   => 'required|filled|string|max:255',
                'city'      => 'string|max:255',
                'phone'     => 'required|filled|string|max:255',
            ]);
        }

        protected function validatorSimpleUserRegister(array $data)
        {
            return Validator::make($data, [
                'name'      => 'required|filled|string|max:255',
                'surname'   => 'required|filled|string|max:255',
                'pseudonym' => 'required|filled|string|max:255',
                'nickname'  => 'required|filled|string|max:255',
                'country'   => 'required|filled|string|max:255',
                'city'      => 'string|max:255',
            ]);
        }

        private function getItem($type, $id)
        {
            $item = null;
            if ($type == 'poster') {
                $item = Poster::find($id);
                $item->nextPrev = $this->getNextPrevItems($item->artist_id, $type, $id);
            } elseif ($type == 'picture') {
                $item = Picture::find($id);
                $item->nextPrev = $this->getNextPrevItems($item->artist_id, $type, $id);
            } elseif ($type == 'object') {
                $item = Thing::find($id);
                $item->nextPrev = $this->getNextPrevItems($item->artist_id, $type, $id);
            }

            return $item;
        }

        public function getItemInfoAjax($type, $id, Request $request)
        {
            $item = $this->getItem($type, $id);
            if ($item) {
                echo json_encode(view('web.layout.sections.product-overview')->with('item', $item)->with('type', $type)->with('prevnext', $request->prevnext)->render());
            } else {
                echo 0;
            }
        }

        public function getItemInfo($type, $id)
        {

        }

        /**
         * Toggle Like Ajax
         *
         * @param $type
         * @param $id
         * @return bool - Liked true false
         */
        public function toggleLikeAjax($type, $id)
        {
            $like = Like::findLiked(Auth::id(), $type, $id);
            if (!$like) {
                Like::fillAndStore(Auth::id(), $type, $id);

                return response()->json(true);
            } else {
                $like->delete();

                return response()->json(false);
            }
        }

        /**
         * @return mixed
         */
        public function likedPosts()
        {
            $user = Auth::user();

            $products = $user->liked_products()->orderBy('likes.created_at', 'desc')->paginate(100);

            if(request()->wantsJson()) {
                return $products;
            }

            return view('web.pages.author.liked', compact('products', 'user'));
        }

        public function subscribeToArtist($id)
        {
            $res = [
                'status' => 0,
                'count'  => 0,
            ];
            if (Auth::guest()) {
                return response($res);
            }
            $subscribed = $this->checkSubscription($id);
            if (!$subscribed) {
                $this->saveSubscription($id);
            }
            $user = User::find($id);
            if ($user) {
                $res['status'] = 1;
                $res['count'] = count($user->subscribedToMe);
            }

            return response($res);
        }

        private function checkSubscription($id)
        {
            $subscribe = Subscription::where('user_id', Auth::id())->where('subscription_id', $id)->first();
            if ($subscribe) {
                $subscribe->delete();
            }

            return $subscribe;
        }

        private function saveSubscription($id)
        {
            $subscribe = new Subscription();
            $subscribe->user_id = Auth::id();
            $subscribe->subscription_id = $id;
            $subscribe->save();
        }

        public function subscriptionNews()
        {
            $user = Auth::user();
            //   $products = $user->subscriptions_products()->orderBy('products.created_at', 'desc')->get();

            $subscriptionsList = Auth::user()->subscriptions;
            $galleryProducts = collect([]);
            foreach ($subscriptionsList as $subscription) {
                if ($subscription->author->gallery_profile) {
                    $galleryProducts = $galleryProducts->merge($subscription->author->gallery_profile->items);
                }
            }

            $products = $galleryProducts->merge($user->subscriptions_products()->paginate(100));

            if(request()->wantsJson()) {
                return $products;
            }

            return view('web.pages.author.news', compact('user', 'products'));
        }

        public function subscriptionsList($type)
        {
            if (!$type || $type == 'author') {
                return $this->showSubscriptionsListAuthors();
            }

            return $this->showSubscriptionsListGalleries();
        }

        public function showSubscriptionsListAuthors()
        {
            $subscriptions = [];
            $subscriptionsList = Auth::user()->subscriptions;
            foreach ($subscriptionsList as $subscription) {
                if ($subscription->author->role !== 3) {
                    $subscriptions[] = $subscription->author;
                }
            }

            return view('web.pages.subscriptions.author-subscriptions', compact('subscriptions'));
        }

        public function showSubscriptionsListGalleries()
        {
            $galleries = [];
            $subscriptionsList = Auth::user()->subscriptions;
            foreach ($subscriptionsList as $subscription) {
                if ($subscription->author->gallery_profile) {
                    $galleries[] = $subscription->author->gallery_profile;
                }
            }

            return view('web.pages.subscriptions.gallery-subscriptions', compact('galleries'));
        }

        private function decodeColorToHSL($rgb)
        {
            $hex = $this->rgb2hex($rgb);
            $hsl = $this->hex2hsl($hex);

            return $hsl;
        }

        public function rgb2hex($rgb)
        {
            $hex = "#";
            $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return $hex; // returns the hex value including the number sign (#)
        }

        public function hex2hsl($hexcode)
        {
            // $hexcode is the six digit hex colour code we want to convert

            $redhex = substr($hexcode, 1, 2);
            $greenhex = substr($hexcode, 3, 2);
            $bluehex = substr($hexcode, 5, 2);

            // $var_r, $var_g and $var_b are the three decimal fractions to be input to our RGB-to-HSL conversion routine

            $var_r = (hexdec($redhex)) / 255;
            $var_g = (hexdec($greenhex)) / 255;
            $var_b = (hexdec($bluehex)) / 255;

            // Input is $var_r, $var_g and $var_b from above
            // Output is HSL equivalent as $h, $s and $l — these are again expressed as fractions of 1, like the input values

            $var_min = min($var_r, $var_g, $var_b);
            $var_max = max($var_r, $var_g, $var_b);
            $del_max = $var_max - $var_min;

            $l = ($var_max + $var_min) / 2;

            if ($del_max == 0) {
                $h = 0;
                $s = 0;
            } else {
                if ($l < 0.5) {
                    $s = $del_max / ($var_max + $var_min);
                } else {
                    $s = $del_max / (2 - $var_max - $var_min);
                };

                $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
                $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
                $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

                if ($var_r == $var_max) {
                    $h = $del_b - $del_g;
                } elseif ($var_g == $var_max) {
                    $h = (1 / 3) + $del_r - $del_b;
                } elseif ($var_b == $var_max) {
                    $h = (2 / 3) + $del_g - $del_r;
                };

                if ($h < 0) {
                    $h += 1;
                };

                if ($h > 1) {
                    $h -= 1;
                };
            };

            // Calculate the opposite hue, $h2

            $h2 = $h + 0.5;

            if ($h2 > 1) {
                $h2 -= 1;
            };

            $res = [
                'h' => round($h * 360),
                's' => round($s * 100),
                'l' => round($l * 100),
            ];

            return $res;
        }

        public function decodeItemColors($type)
        {
            ini_set('max_execution_time', 50 * 60);//execution time of 25 min

            $items = [];
            if ($type == 'poster') {
                $items = Poster::get();
            } elseif ($type == 'picture') {
                $items = Picture::get();
            }

            $data = [];
            foreach ($items as $item) {
                $res = Helpers::processImageColors($item->id, $type, $item->image_preview);
                if ($res) {
                    $data[] = $res;
                }
            }

            echo "Processed " . count($data) . " items";
        }

        public function showFile($folder, $name)
        {
            $path = storage_path() . '/app/' . $folder . '/' . $name;
            if (file_exists($path)) {
                return Response::download($path);
            }
        }

        public function updateResizeImages($type)
        {
            if (isset($_GET['key']) && $_GET['key'] == 'JhCNfv23kiP6IpBphtU3SJ5JyACxafHRWrmjDO0t') {
                ini_set('max_execution_time', 25 * 60);//execution time of 15 min
                echo '<pre><tt>';
                echo "LOG:<br>";
                $directory = storage_path() . "/app/" . $type;
                if (!file_exists($directory)) {
                    echo "Files not found";

                    return null;
                }
                $files = File::allFiles($directory);
                $counts = 0;
                $deleted = [];
                $resized = [];
                foreach ($files as $filepath) {

                    $file = explode('/', $filepath);
                    $filename = end($file);
                    $filesize = explode('_', $filename);
                    if (isset($filesize[1])) {
                        unlink($filepath);
                        $deleted[] = $filename;
                    }
                }
                foreach ($files as $filepath) {

                    $file = explode('/', $filepath);
                    $filename = end($file);
                    $filesize = explode('_', $filename);
                    if (!isset($filesize[1])) {
                        $r = Helpers::saveImageSize($directory, $filename);
                        $resized[] = $filename;
                        $counts++;
                    }
                }
                echo '<br><br>DELETED:<br>';
                print_r($deleted);
                echo '<br><br>RESIZED:<br>';
                print_r($resized);
                echo '<br>SUCCESS: All image (' . $counts . ') sizes updated';
            } else {
                echo 'Nothing...';
            }
        }

        public function deleteItem(Request $request, $type)
        {
            $item = null;
            if ($type == 'poster') {
                $item = Poster::find($request->itemId);
                if (!$item) {
                    return response('error', 500);
                }
            } else {
                if ($type == 'picture') {
                    $item = Picture::find($request->itemId);
                    if (!$item) {
                        return response('error', 500);
                    }
                } elseif ($type == 'Thing') {
                    $item = Thing::find($request->itemId);
                    if (!$item) {
                        return response('error', 500);
                    }
                }
            }

            if ($item && $item->artist_id == Auth::id()) {
                Storage::delete($item->image_preview);
                if (isset($item->image_source)) {
                    Storage::delete($item->image_source);
                }
                $fileName = str_replace('.', '_' . env('IMAGE_WIDTH_PREV') . '.', $item->image_preview);
                Storage::delete($fileName);
                $fileName = str_replace('.', '_' . env('IMAGE_WIDTH_SHOW') . '.', $item->image_preview);
                Storage::delete($fileName);

                Color::where('item_type', $type)->where('item_id', $item->id)->delete();

                $item->delete();

                return response('OK', 200);
            }

            return response('error', 500);
        }
    }


