<?php

    namespace App\Traits\Models;


    use App\Http\Helpers;
    use App\Models\Color;
    use Illuminate\Http\Request;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\URL;
    use Intervention\Image\Image;

    trait HasImageTrait
    {
        /**
         * @var array
         */
        protected $dimensions = [
            'L'  => '1800',
            'M'  => '1200',
            'S'  => '400',
            'XS' => '150',
        ];

        /**
         * @var
         */
        private $hash;

        /**
         * Image source onFill processing
         * Store Image to folder and write image hash to database
         *
         * @param $value
         * @return string Image hash
         */
        public function setImageSourceAttribute($file)
        {
            return '';
        }

        /**
         * Preview onFill processing
         * Store Image to folder and write image hash to database
         *
         * @param $value
         * @return string Image hash
         */
        public function setImagePreviewAttribute($file)
        {

            if (!strpos($file, 'base64'))  {
                return false;
            }

            if (!$file instanceof UploadedFile) {
                $file = $this->saveBase64Image(md5($file),$file,Auth::id());
            }

            $this->hash = strtok($file->hashName(), '.');
            $storedFilePath = $file->storeAs($this->getStoragePath(), $this->hash . '.jpg');

            $this->attributes['image_preview'] = $storedFilePath;


            $this->prepareImagePreviews($storedFilePath);


        }

        /**
         * @return mixed
         */
        public function getImagePreviewOriginalAttribute()
        {
            $link = str_replace('.', '.', '/storage/' . $this->image_preview);
            $link = str_replace('/public', '', $link);
            return $link;
        }

        /**
         * @return mixed
         */
        public function getImagePreviewSAttribute()
        {
            $link = str_replace('.', '_S.', '/storage/' . $this->image_preview);
            $link = str_replace('/public', '', $link);
            return $link;
        }

        /**
         * @return mixed
         */
        public function getImagePreviewXsAttribute()
        {
            $link = str_replace('.', '_CS.', '/storage/' . $this->image_preview);
            $link = str_replace('/public', '', $link);
            return $link;
        }

        /**
         * @return mixed
         */
        public function getImagePreviewMAttribute()
        {
            $link = str_replace('.', '_M.', '/storage/' . $this->image_preview);
            $link = str_replace('/public', '', $link);
            return $link;
        }

        /**
         *
         */
        public function processColors()
        {
            $this->processImageColors($this->id, 'poster', $this->image_preview_m);
        }

        /**
         * @return mixed
         */
        private function getImageName()
        {
            $imageName = $this->hash;
            return $imageName;
        }

        /**
         * @return string
         */
        private function getStoragePath()
        {
            $storagePath = 'public/' . $this->getTable() . '/' . $this->getImageName();
            return $storagePath;
        }

        /**
         * @return string
         */
        private function getPreviewStoragePath()
        {
            $storagePath = 'storage/' . $this->getTable() . '/' . $this->getImageName();
            return $storagePath;
        }

        /**
         * @param $imagePath
         * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
         */
        private function prepareImagePreviews($imagePath)
        {
            $image = \Intervention\Image\Facades\Image::make(Storage::get($imagePath));
            foreach ($this->dimensions as $key => $value) {
                $this->resizeAndStore($image, $key, $value);
            }
        }

        /**
         * @param Image $image
         * @param $size
         * @param $value
         */
        private function resizeAndStore(Image $image, $size, $value)
        {
            $image->widen($value, function ($constraint) {
                $constraint->upsize();
            })->save($this->getPreviewStoragePath() . '/' . $this->getImageName() . '_' . $size . '.jpg');
        }

        /**
         * @param $id
         * @param $type
         * @param $image
         * @return array|null
         */
        private function processImageColors($id, $type, $image)
        {

            $folder = pathinfo($image, PATHINFO_DIRNAME);
            $folderName = array_filter( explode('/', $folder) );
            $folderName = array_pop($folderName);


            $fileName = array_filter( explode('/', $image) );
            $fileName = array_pop($fileName);

            $imagePath = storage_path() . "/app/public/products/" .$folderName.'/'.$fileName;


//            if (!file_exists($imagePath)) {
//                return null;
//            }

            $data = [];

            $palette = new \BrianMcdo\ImagePalette\ImagePalette($imagePath, 35, 7);

            foreach ($palette as $p) {
                $hsl = $this->hex2hsl((string)$p);
                $data[] = [
                    'user_id'   => Auth::id(),
                    'item_type' => $type,
                    'item_id'   => $id,
                    'h'         => $hsl['h'],
                    's'         => $hsl['s'],
                    'l'         => $hsl['l'],
                    'hex'       => (string)$p,
                ];
            }
            Color::where('item_type', $type)->where('item_id', $id)->delete();
            Color::insert($data);
            return $data;
        }

        /**
         * @param $rgb
         * @return string
         */
        private function rgb2hex($rgb)
        {
            $hex = "#";
            $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return $hex; // returns the hex value including the number sign (#)
        }

        /**
         * @param $hexcode
         * @return array
         */
        private function hex2hsl($hexcode)
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
            // Output is HSL equivalent as $h, $s and $l � these are again expressed as fractions of 1, like the input values

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

        private function saveBase64Image($name, $base64Image, $user_id)
        {
            
            $path = public_path() . "/storage/users/" . $user_id;
            File::makeDirectory($path, 0777, true, true);
            $img = base64_decode(substr($base64Image, strpos($base64Image, ",") + 1));
            $savePath = $path . '/' . $name . '.jpg';
            $publicPath = "/storage/users/" . $user_id . '/' . $name . '.jpg';
            file_put_contents($savePath, $img);

            return $this->pathToUploadedFile($savePath);
        }

        private function pathToUploadedFile( $path, $public = false )
        {
            $name = File::name( $path );

            $extension = File::extension( $path );

            $originalName = $name . '.' . $extension;

            $mimeType = File::mimeType( $path );

            $size = File::size( $path );

            $error = null;

            $test = $public;

            $object = new UploadedFile( $path, $originalName, $mimeType, $size, $error, $test );

            return $object;
        }

    }
