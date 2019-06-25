<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ProjectType extends ApiModel
{ 
    use SoftDeletes, LogsActivity;

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
