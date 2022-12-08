<?php

namespace Domain\Subscriber\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subscriber extends BaseModel
{
    use HasUser;

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

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }
}
