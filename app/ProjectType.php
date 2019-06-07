<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectType extends ApiModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public static function listProjectTypes()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
