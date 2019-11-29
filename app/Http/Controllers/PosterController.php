<?php

    namespace App\Http\Controllers;

    use App\Models\CategoryType;
    use App\Models\Products\Poster;
    use Illuminate\Http\Request;
    use Response;

    class PosterController extends Controller
    {

        /**
         * Instantiate a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth')->except(['index', 'showPosterPreview', 'getPostersJson']);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $posters = Poster::availableForCatalog()->paginate(40)->toJson();

            $categories = CategoryType::get();

            return view('web.pages.prints.index', compact('posters', 'categories'));
        }

        public function getPostersJson()
        {
            $posters = Poster::orderBy('id', 'desc')->with('author')->get();
            return $posters;
        }

        /**
         * Show the form for creating a new print.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function create()
        {
            $title = trans('dashboard.Adding print');
            $type = 1;
            return view('web.pages.products.create', compact('title', 'type'));
        }


        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $poster = new Poster();
            $poster->fillAndStore($request);

            return redirect($poster->author->profileURL());
        }

        /**
         * Get expression for validate Float number
         *
         * @return string
         */
        private function floatNumberRegex()
        {
            return "/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/";
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {


        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $poster = Poster::find($id);
            $title = 'Редактирование принта';
            $type = 1;
            return view('web.pages.products.create', compact('title', 'type', 'poster'));
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
            $poster = Poster::findOrFail($id);
            if ($poster->user_id == $request->user_id) {
                $poster->viewed = 0;
                $poster->favorite = 0;
                $poster->is_active = 0;
            }
            $poster->fillAndStore($request);
            return redirect($poster->author->profileURL());

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

        public function showPosterPreview($id)
        {
            $poster = Poster::find($id);
            if (!$poster) {
                return null;
            }
            $path = storage_path() . '/app/' . $poster->image_preview;
            if (file_exists($path)) {
                return Response::download($path);
            }
        }


    }
