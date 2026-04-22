<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $guarded = [];

    public function sport(){
        return $this->belongsTo(Sport::class);
    }
    public function season(){
        return $this->belongsTo(Season::class);
    }
}
