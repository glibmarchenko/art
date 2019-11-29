<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\PosterStoreRequest;
    use App\Models\CategoryType;
    use App\Models\Products\Picture;
    use Auth;
    use Illuminate\Http\Request;
    use Response;

    class PictureController extends Controller
    {


        /**
         * Instantiate a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth')->except(['index', 'showPicturePreview']);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $pictures = Picture::availableForCatalog()->paginate(40);
            $categories = CategoryType::get();
            return view('web.pages.pictures.index', compact('pictures', 'categories'));
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $title = trans('dashboard.Adding painting');
            $type = 2;
            return view('web.pages.products.create', compact('title','type'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(PosterStoreRequest $request)
        {
            $picture = new Picture();
            $picture->fillAndStore($request);
            return redirect($picture->author->profileURL());
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
            $title = 'Редактирование картины';
            $picture = Picture::find($id);
            if (!$picture || $picture->artist_id != Auth::id()) {
                return redirect()->back();
            }
            return view('web.pages.items.editPicture', compact('picture','title'));
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
            $picture = Picture::findOrFail($id);
            if ($picture->user_id == Auth::id()) {
                $picture->viewed = 0;
                $picture->favorite = 0;
                $picture->is_active = 1;
            }
            $picture->fillAndStore($request);
            return redirect($picture->author->profileURL());

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


        public function showPicturePreview($id)
        {
            $picture = Picture::find($id);
            if (!$picture) {
                return null;
            }
            $path = storage_path() . '/app/' . $picture->image_preview;
            if (file_exists($path)) {
                return Response::download($path);
            }
        }
    }
