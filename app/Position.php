<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Position extends ApiModel
{
    use LogsActivity;

    protected $fillable = [
        'description'
    ];

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

    public static function listPositions()
    {
        return static::orderBy('id', 'DESC')->select('id', 'description')->get();
    }
}
