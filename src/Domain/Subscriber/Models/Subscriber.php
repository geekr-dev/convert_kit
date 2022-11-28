<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;

class Subscriber extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'form_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class)->withDefault();
    }

    public function sentMails()
    {
        return $this->hasMany(SentMail::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
