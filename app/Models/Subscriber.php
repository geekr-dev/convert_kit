<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
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
        return $this->belongsTo(Form::class);
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