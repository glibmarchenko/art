<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'country',
        'about',
        'exhibition',
        'education',
        'avatar',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'user_id',
    ];

    protected $appends = [
        'profile_url',
        'avatar_link'
    ];

    public function profileURL()
    {
        return route('gallery.author',[$this->gallery->id,$this->id]);
    }

    public function getProfileUrlAttribute()
    {
        return $this->profileURL();
    }

    public function getAvatarLinkAttribute()
    {
        return $this->avatar? '/web/images/avatars/'.$this->avatar : '/images/nophoto.jpg';
    }

    public function items() {
        $posters = $this->hasMany('App\Models\Poster', 'author_id', 'id')->get();
        $pictures = $this->hasMany('App\Models\Picture', 'author_id', 'id')->get();
        $objects = $this->hasMany('App\Models\Object', 'author_id', 'id')->get();
        $items = [];
        foreach($posters as $poster){
            $items[date('Y-m-d H:i:s',strtotime($poster->created_at))] = $poster;
        }

        foreach($pictures as $picture){
            $items[date('Y-m-d H:i:s',strtotime($picture->created_at))] = $picture;
        }

        foreach($objects as $object){
            $items[date('Y-m-d H:i:s',strtotime($object->created_at))] = $object;
        }
        krsort($items);
        return $items;
    }

    public function gallery()
    {
        return $this->hasOne('App\Models\Gallery', 'user_id', 'user_id');
    }

}
