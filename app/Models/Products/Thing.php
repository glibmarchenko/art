<?php

namespace App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Thing extends Product
{
    protected $fillable = [
        'user_id',
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
    ];

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery()->whereType(3);
    }

    public function fillAndStore(Request $request)
    {
        if (! $request->user_id) {
            $this->user_id = Auth::id();
        }
        $this->fill($request->all());
        $this->type = 3;
        $this->save();

        $this->fillTags($request->tags);
        $this->fillCategories($request->styles);
        $this->fillAttachments($request->attachments);
        $this->fillMaterials($request->materials);
        $this->processColors();
    }
}
