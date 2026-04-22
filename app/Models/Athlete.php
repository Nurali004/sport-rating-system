<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    protected $guarded = [];
    protected $casts = [
        'cover_photo' => 'array',
    ];

    public function achievments()
    {
        return $this->hasMany(Achievement::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }


}
