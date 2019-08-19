<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends ApiModel
{
	use SoftDeletes, LogsActivity, FullTextSearch, CascadeSoftDeletes;

    protected $cascadeDeletes = ['expenses', 'incomes'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'location', 'comments', 'start_date', 'end_date', 'state', 'project_type_id',
    ];

    protected $searchable = [
        'name', 'location',
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
        return static::orderBy('name')->select('id', 'name')->where('state', 1)->get();
    }
}
