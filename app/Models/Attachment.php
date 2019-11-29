<?php

    namespace App\Models;

    use App\Models\Products\Product;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;
    use Intervention\Image\Facades\Image;
    use File;


    class Attachment extends Model
    {
        protected $guarded = [];

        public function product()
        {
            return $this->belongsTo(Product::class);
        }

        public function fillAndStore($file, $user_id)
        {
            if (isset($file['content'])) {
                $this->path = $this->saveBase64Image($file['name'], $file['content'], $user_id);
                $this->user_id = $user_id;
                $this->name = $file['name'];
                $this->save();
            }
            return $this;
        }


        private function saveBase64Image($name, $base64Image, $user_id)
        {
            $path = public_path() . "/storage/users/" . $user_id;
            File::makeDirectory($path, 0777, true, true);
            $img = base64_decode(substr($base64Image, strpos($base64Image, ",") + 1));
            $img = Image::make($img);

            $img->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $savePath = $path . '/' . $name . '.jpg';
            $publicPath = "/storage/users/" . $user_id . '/' . $name . '.jpg';

            $img->save($savePath);
     
            return $publicPath;
        }
    }
