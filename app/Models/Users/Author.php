<?php

namespace App\Models\Users;

class Author extends User
{

    protected $table = 'users';

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
        return '/web/images/avatars/'.$this->avatar;
    }

    public function gallery()
    {
        return $this->belongsTO(\App\Models\Gallery::class);
    }
}
