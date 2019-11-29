<?php


namespace App\Http;
use App\Models\Color;
use Auth;
use Image;

class Helpers {

    public static function saveImageSize($directory,$filename){
        $file = explode('.',$filename);
        if(isset($file[0])&&isset($file[1])){
            Image::make($directory."/".$filename)->widen(env('IMAGE_WIDTH_PREV'), function ($constraint) {$constraint->upsize();})->save($directory."/".$file[0]."_".env('IMAGE_WIDTH_PREV').".".$file[1]);
            /*Image::make($directory."/".$filename)->widen(env('IMAGE_WIDTH2'), function ($constraint) {$constraint->upsize();})->save($directory."/".$file[0]."_".env('IMAGE_WIDTH2').".".$file[1]);
            Image::make($directory."/".$filename)->widen(env('IMAGE_WIDTH3'), function ($constraint) {$constraint->upsize();})->save($directory."/".$file[0]."_".env('IMAGE_WIDTH3').".".$file[1]);*/
        }
    }

    public static function processImageColors($id, $type, $image){
        $imagePath = storage_path() . "/app/" . $image;
        if (!file_exists($imagePath)) {
            return null;
        }
        $data = [];
        $palette = new \BrianMcdo\ImagePalette\ImagePalette( $imagePath, env('COUNT_IMAGE_PIXELS'), env('COUNT_IMAGE_COLORS') );
        foreach($palette as $p){
            $hsl = self::hex2hsl((string)$p);
            $data[] = [
                'user_id'=>Auth::id(),
                'item_type'=>$type,
                'item_id'=>$id,
                'h'=>$hsl['h'],
                's'=>$hsl['s'],
                'l'=>$hsl['l'],
                'hex'=>(string)$p,
            ];
        }
        Color::where('item_type',$type)->where('item_id',$id)->delete();
        Color::insert($data);
        return $data;
    }

    static function rgb2hex($rgb) {
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

        return $hex; // returns the hex value including the number sign (#)
    }

    static function hex2hsl($hexcode){
        // $hexcode is the six digit hex colour code we want to convert

        $redhex  = substr($hexcode,1,2);
        $greenhex = substr($hexcode,3,2);
        $bluehex = substr($hexcode,5,2);

        // $var_r, $var_g and $var_b are the three decimal fractions to be input to our RGB-to-HSL conversion routine

        $var_r = (hexdec($redhex)) / 255;
        $var_g = (hexdec($greenhex)) / 255;
        $var_b = (hexdec($bluehex)) / 255;


        // Input is $var_r, $var_g and $var_b from above
        // Output is HSL equivalent as $h, $s and $l — these are again expressed as fractions of 1, like the input values

        $var_min = min($var_r,$var_g,$var_b);
        $var_max = max($var_r,$var_g,$var_b);
        $del_max = $var_max - $var_min;

        $l = ($var_max + $var_min) / 2;

        if ($del_max == 0)
        {
            $h = 0;
            $s = 0;
        }
        else
        {
            if ($l < 0.5)
            {
                $s = $del_max / ($var_max + $var_min);
            }
            else
            {
                $s = $del_max / (2 - $var_max - $var_min);
            };

            $del_r = ((($var_max - $var_r) / 6) + ($del_max / 2)) / $del_max;
            $del_g = ((($var_max - $var_g) / 6) + ($del_max / 2)) / $del_max;
            $del_b = ((($var_max - $var_b) / 6) + ($del_max / 2)) / $del_max;

            if ($var_r == $var_max)
            {
                $h = $del_b - $del_g;
            }
            elseif ($var_g == $var_max)
            {
                $h = (1 / 3) + $del_r - $del_b;
            }
            elseif ($var_b == $var_max)
            {
                $h = (2 / 3) + $del_g - $del_r;
            };

            if ($h < 0)
            {
                $h += 1;
            };

            if ($h > 1)
            {
                $h -= 1;
            };
        };

        // Calculate the opposite hue, $h2

        $h2 = $h + 0.5;

        if ($h2 > 1)
        {
            $h2 -= 1;
        };

        $res = [
            'h'=>round($h*360),
            's'=>round($s*100),
            'l'=>round($l*100),
        ];
        return $res;


    }
}