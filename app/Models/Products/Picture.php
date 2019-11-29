<?php

namespace App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Picture extends Product
{
    protected $fillable = [
        'artist_id',
        'name',
        'image_preview',
        'image_source',
        'price',
        'width',
        'height',
        'year',
        'description',
        'for_sale',
        'depth',
        'weight',
        'user_id',
    ];

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery()->whereType(2);
    }

    /**
     * @param $request
     */
    public function fillAndStore(Request $request)
    {
        if (! $request->user_id) {
            $this->user_id = Auth::id();
        }
        $this->fill($request->all());
        $this->type = 2;
        $this->save();

        $this->fillTags($request->tags);
        $this->fillCategories($request->styles);
        $this->fillAttachments($request->attachments);
        $this->fillMaterials($request->materials);
        $this->processColors();
    }
}
