<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $dates    = ['deleted_at'];
    protected $fillable = ['description'];
    protected $appends  = ['action_list'];

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
        return array_map('strval', $this->actions->pluck('id')->toArray());
    }
}
