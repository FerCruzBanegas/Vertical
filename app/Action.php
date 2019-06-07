<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['name', 'method', 'order'];

    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->withTimestamps();
    }
}
