<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends ApiModel
{
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid', 'name', 'comments', 'start_date', 'end_date', 'project_type_id',
    ];

    // public function getStartDateAttribute($date)
    // {
    //     return $this->getFormatDate($date);
    // }

    public function project_type()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }


    public static function listProjects()
    {
        return static::orderBy('name')->select('id', 'name');
    }
}
