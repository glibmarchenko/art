<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Color extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'item_type',
            'item_id',
            'h',
            's',
            'l',
            'hex',
        ];

        static function getItemsByColor($color, $type)
        {
            $colors = self::where('h', '>=', intval($color['h']) - env('COLOR_H'))
                ->where('h', '<=', intval($color['h']) + env('COLOR_H'))
                ->where('s', '>=', intval($color['s']) - env('COLOR_S'))
                ->where('s', '<=', intval($color['s']) + env('COLOR_S'))
                ->where('l', '>=', intval($color['l']) - env('COLOR_L'))
                ->where('l', '<=', intval($color['l']) + env('COLOR_L'))
                ->orderBy('item_id', 'desc')->get();
            $items = [];
            foreach ($colors as $col) {
                if ($type == 0 && $col->item_type == 'picture') {
                    if ($col->picture) {
                        $items[] = $col->picture;
                    }
                } elseif ($type == 1 && $col->item_type == 'poster') {
                    if ($col->poster) {
                        $items[] = $col->poster;
                    }
                }
            }
            return collect($items);
        }

        public function poster()
        {
            return $this->hasOne('App\Models\Poster', 'id', 'item_id');
        }

        public function picture()
        {
            return $this->hasOne('App\Models\Picture', 'id', 'item_id');
        }

        public static function decodeColorToHSL($rgb)
        {
            $hex = self::rgb2hex($rgb);
            $hsl = self::hex2hsl($hex);
            return $hsl;
        }

        public static function rgb2hex($rgb)
        {
            $hex = "#";
            $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return $hex; // returns the hex value including the number sign (#)
        }

        public static function hex2hsl($hexcode)
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

    }
