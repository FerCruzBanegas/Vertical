<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

class Action extends ApiModel
{
    protected $fillable = ['name', 'method', 'order'];

    public function profiles()
    {
        return $this->belongsToMany(Profile::class)->withTimestamps();
    }

    public static function listActions()
    {
        return static::select('title', 'name', 'id')->get();
    }
}
