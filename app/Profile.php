<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Profile extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates    = ['deleted_at'];
    protected $fillable = ['description'];
    protected $appends  = ['action_list'];

    protected $searchable = [
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function actions()
    {
        return $this->belongsToMany(Action::class)->withTimestamps();
    }

    public function getActionListAttribute()
    {
        return $this->actions->pluck('id')->toArray();
    }

    public static function listProfiles()
    {
        return static::orderBy('id', 'DESC')->select('id', 'description')->get();
    }
}
