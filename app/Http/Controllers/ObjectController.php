<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\ObjectStoreRequest;
    use App\Models\Products\Thing;
    use Auth;
    use Illuminate\Http\Request;

    class ObjectController extends Controller
    {

        /**
         * Instantiate a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth')->except(['index']);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $objects = Thing::availableForCatalog()->paginate(40)->toJson();

            return view('web.pages.objects.index', compact('objects'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $title = trans('dashboard.Adding design');
            $type = 3;
            return view('web.pages.products.create', compact('title','type'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $object = new Thing();

            $object->fillAndStore($request);

            return redirect($object->author->profileURL());
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $object = Thing::find($id);
            if (!$object || $object->artist_id != Auth::id()) {
                return redirect()->back();
            }
            return view('web.pages.items.editObject', compact('object'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            $object = Thing::find($id);

            if ($object->user_id == Auth::id()) {
                $object->viewed = 0;
                $object->favorite = 0;
                $object->is_active = 1;
            }
            $object->fillAndStore($request);
            return redirect($object->author->profileURL());
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            //
        }
    }
